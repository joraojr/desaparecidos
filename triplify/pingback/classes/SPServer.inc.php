<?php
/**
 * This file contains the Semantic Pingback XML-RPC server.
 *
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright  Copyright (c) 2010, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: $
 */

require_once 'libraries/class-IXR.php';
require_once 'classes/SPRdfXmlParser.inc.php';

class SPServer extends IXR_Server 
{
    private $_config = array();
    private $_dbChecked = false;
    private $_dbConn = null;
    private $_methods = array(
        'pingback.ping' => 'this:pingback_ping'
    );
    
    private $_loadCache = array();
    
    public function __construct($config = array())
    {
        if (!isset($config['db'])) {
            throw new Exception('No database connection was configured.');
        }
        $this->_dbConn = $config['db'];
        
        $defaultConfig = array();
		$this->_config = array_merge($defaultConfig, $config);
    }

	function serveRequest() 
	{
		$this->IXR_Server($this->_methods);
	}
	
	function pingback_ping($args) 
	{
        $source = $args[0];
        $target = $args[1];
	
		$source = str_replace('&amp;', '&', $source);
		$target = str_replace('&amp;', '&', $target);
		$target = str_replace('&', '&amp;', $target);

        	// Check if the page linked to is in our site
		$pos1 = strpos($target, ('http://'  . $_SERVER['HTTP_HOST']));
		$pos2 = strpos($target, ('https://' . $_SERVER['HTTP_HOST']));
		if (($pos1 === false) && ($pos2 === false)) {
		    return new IXR_Error(0, 'Is there no link to us?');
		}

		$foundPingbackTriples = array();
		
		// Let's check the remote site
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $source);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		    'Accept: application/rdf+xml'
		));
		$result = curl_exec($curl);
		$info = curl_getinfo($curl);
		curl_close($curl);
		if (($info['http_code'] === 200) && (strtolower($info['content_type']) === 'application/rdf+xml')) {
		    $rdfData = $result;
		    $triples = $this->_getPingbackTriplesFromRdfXmlString($rdfData, $source, $target);
		    if (is_array($triples)) {
                $foundPingbackTriples = $triples;
            }
		}
		
		if (count($foundPingbackTriples) === 0) {
	        $service = 'http://www.w3.org/2007/08/pyRdfa/extract?format=pretty-xml&warnings=false&parser=lax&space-preserve=true&uri=' . urlencode($source);
	        
	        $curl = curl_init();
    		curl_setopt($curl, CURLOPT_URL, $service);
    		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    		$result = curl_exec($curl);
    		$info = curl_getinfo($curl);
    		curl_close($curl);
    		if (($info['http_code'] === 200) && (strtolower($info['content_type']) === 'application/rdf+xml')) {
	            $rdfData = $result;
    		    $triples = $this->_getPingbackTriplesFromRdfXmlString($rdfData, $source, $target);
    		    if (is_array($triples)) {
                    $foundPingbackTriples = $triples;
                }
	        }
	    }
	    
	    if (count($foundPingbackTriples) === 0) {
	        $curl = curl_init();
    		curl_setopt($curl, CURLOPT_URL, $source);
    		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    		$result = curl_exec($curl);
    		$info = curl_getinfo($curl);
    		curl_close($curl);
    		if ($info['http_code'] === 200) {
	            $htmlDoc = new DOMDocument();
                $r = @$htmlDoc->loadHtml($result);
                $aElements = $htmlDoc->getElementsByTagName('a');

                foreach ($aElements as $aElem) {
                    $a  = $aElem->getAttribute('href');
                    if (strtolower($a) === $target) {
                        $foundPingbackTriples[] = array(
                            's' => $source,
                            'p' => 'http://rdfs.org/sioc/ns#links_to',
                            'o' => $target
                        );
                        break;
                    }
                }
	        }
		}
		
        if (count($foundPingbackTriples) === 0) {    
            $this->_deleteInvalidPingbacks($source, $target);
            
            return new IXR_Error(0x0011, 'No links in source document.');
		}
		
		$added = false;
		foreach ($foundPingbackTriples as $triple) {
		    if (!$this->_pingbackExists($triple['s'], $triple['p'], $triple['o'])) {
		        $this->_addPingback($triple['s'], $triple['p'], $triple['o']);
		        $added = true;
		    }
		}
		
		// remove old pingbacks
		$this->_deleteInvalidPingbacks($source, $target, $foundPingbackTriples);
			
		if (!$added) {
            return new IXR_Error(0x0030, 'Already exists.');
        }
       
        return 'Pingback registered.';
	}
	
	function _deleteInvalidPingbacks($source, $target, $foundPingbackTriples = array())
	{
	    $this->_checkDb();
	    
	    $sql = 'SELECT id, s, p, o FROM triplify_pingbacks WHERE s="' . $source . '" AND o="' . $target. '"';
	    $result = $this->_query($sql);
	    
	    if (!is_array($result)) {
	        return;
	    }
	    
	    foreach ($result as $row) {
	        $found = false;
	        foreach ($foundPingbackTriples as $triple) {
	            if ($triple['p'] === $row['p']) {
	                $found = true;
	                break;
	            }
	        }
	        
	        if (!$found) {
	            $sql = 'DELETE FROM triplify_pingbacks WHERE id=' . $row['id'];
	            $this->_query($sql);
	        }
	    }
	}
	
	function _getPingbackTriplesFromRdfXmlString($rdfXml, $sourceUri, $targetUri)
	{
	    $parser = new SPRdfXmlParser();
	    try {
	        $result = $parser->parse($rdfXml);
	    } catch (Exception $e) {
	        return false;
	    }
        
        $foundTriples = array();
        foreach ($result as $s => $pArray) {
            foreach ($pArray as $p => $oArray) {
                foreach ($oArray as $oSpec) {
                    if ($s === $sourceUri) {
                        if (($oSpec['type'] === 'uri') && ($oSpec['value'] === $targetUri)) {
                            $foundTriples[] = array(
                                's' => $s,
                                'p' => $p,
                                'o' => $oSpec['value']
                            );
                        }
                    } 
                }
            }
        }
        
        return $foundTriples;
	}
	
	function _pingbackExists($s, $p, $o)
	{
	    $this->_checkDb();
	    
	    $sql = 'SELECT * FROM triplify_pingbacks WHERE s="' . $s . '" AND p="' . $p . '" AND o="' . $o . '"';
	    $result = $this->_query($sql);
	    if (!$result) {
	        return false;
	    } else {
	        return true;
	    }
	    
	}
	
	function _addPingback($s, $p, $o)
	{
	    $this->_checkDb();
	    
	    $sql = 'INSERT INTO triplify_pingbacks (s, p, o) VALUES ("' . $s . '", "' . $p . '", "' . $o . '");';
	    $this->_query($sql);
	}
	
	function _checkDb()
	{
	    if ($this->_dbChecked) {
	        return;
	    }
	    
	    $sql = 'SELECT * FROM triplify_pingbacks LIMIT 1';
	    $result = mysql_query($sql, $this->_dbConn);
	    if (!$result) {
	        $this->_createTable();
	    }
	    $result = mysql_query($sql, $this->_dbConn);
	    if (!$result) {
	        throw new Exception('DB check failed.');
	    }
	    
	    $this->_dbChecked = true;
	}
	
	function _createTable()
	{
	    $sql = 'CREATE TABLE IF NOT EXISTS triplify_pingbacks (
	        id TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	        s  VARCHAR(255) COLLATE ascii_bin NOT NULL,
	        p  VARCHAR(255) COLLATE ascii_bin NOT NULL,
	        o  VARCHAR(255) COLLATE ascii_bin NOT NULL
	    );';
	    
	    return mysql_query($sql, $this->_dbConn);
	}
	
	function _query($sql)
	{
	    $result = mysql_query($sql, $this->_dbConn);
	    if (!$result) {
	        return false;
	    }
	    $returnValue = array();
	    while ($row = mysql_fetch_assoc($result)) {
	        $returnValue[] = $row;
	    }
	    
	    if (count($returnValue) === 0) {
	        return false;
	    }
	    
	    return $returnValue;
	}
	
	private function _loadRdfXml($uri)
	{
	    if (isset($this->_loadCache[$uri])) {
	        return $this->_loadCache[$uri];
	    }
	    
	    $curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $uri);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		    'Accept: application/rdf+xml'
		));
		$result = curl_exec($curl);
		$info = curl_getinfo($curl);
		curl_close($curl);
		
		$triples = null;
		if (($info['http_code'] === 200) && ($info['content_type'] === 'application/rdf+xml')) {
    	    $parser = new SPRdfXmlParser();
    	    try {
    	        $triples = $parser->parse($result);
    	    } catch (Exception $e) {
    	        $this->_loadCache[$uri] = null;
    	        return null;
    	    }
	    }
	    
	    $this->_loadCache[$uri] = $triples;
	    
	    return $triples;
	}
}
