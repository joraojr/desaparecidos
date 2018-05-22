<?php
/*
 * This is the metadata config
 * 
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: metadata.php 63 2009-12-15 19:47:37Z hartig $
 */

//
//  BEGIN OF CONFIGURATION
//

/* You have to specify the operator of this Triplify service. The operator is
 * usually you or your group or organization.
 * There are two options to specify the operator. The first option is an HTTP
 * URI that identifies the operator. This is the preferred option.
 */
$provenance['OperatorURI'] = '';
/* The second option is the specification by providing a name, a homepage
 * address, and a URI that identifies the type of the operator.
 */
$provenance['OperatorName'] = '';
$provenance['OperatorHomepage'] = '';
$provenance['OperatorType'] = '';
// $provenance['OperatorType'] = 'http://xmlns.com/foaf/0.1/Organization';
// $provenance['OperatorType'] = 'http://swrc.ontoware.org/ontology#ResearchGroup';


/* If you have an HTTP URI that identifies your triplified dataset (and that
 * links to a voiD description of your dataset) specify it here:
 */
$provenance['Dataset'] = '';

/* If you have an HTTP URI that identifies the accessed database server specify
 * it here:
 */
$provenance['DatabaseServer'] = '';

/* If you have an HTTP URI that identifies the configuration file used by your
 * Triplify installation specify it here:
 */
$provenance['Mapping'] = '';


//
//  END OF CONFIGURATION
//



$triplify['namespaces'] = $triplify['namespaces'] + array(
	'prv'=>'http://purl.org/net/provenance/ns#',
	'prvTypes'=>'http://purl.org/net/provenance/types#',
	'void'=>'http://rdfs.org/ns/void#',
);


function writeMetadata ( $triplifyConfig, $provenanceConfig, $tripleizer ) {
	$p = new ProvenanceWriter( $triplifyConfig, $provenanceConfig );
	$p->describeProvenance( '', $tripleizer );
}

class ProvenanceWriter {
	var $bNodeCounter = 0;

	function ProvenanceWriter ( $triplifyConfig, $provenanceConfig ) {
		$this->tConfig = $triplifyConfig;
		$this->pConfig = $provenanceConfig;
	}

	function describeProvenance ( $subject, $tripleizer ) {
		$this->now = time();
		$this->triplifyInstance = $this->getNewBNodeId();

		$tripleizer->writeTriple( $subject, $tripleizer->uri('rdf:type'), $tripleizer->uri('prv:DataItem') );

		if ( $this->pConfig['Dataset'] ) {
			$tripleizer->writeTriple( $subject, $tripleizer->uri('prv:containedBy'), $tripleizer->uri($this->pConfig['Dataset']) );
			$tripleizer->writeTriple( $tripleizer->uri($this->pConfig['Dataset']), $tripleizer->uri('rdf:type'), $tripleizer->uri('void:Dataset') );
		}

		$creation = $this->getNewBNodeId();
		$tripleizer->writeTriple( $subject, $tripleizer->uri('prv:createdBy'), $creation );
		$this->describeCreation( $creation, $tripleizer );
		$this->describeTriplifyInstance( $this->triplifyInstance, $tripleizer );
	}

	function describeTriplifyInstance ( $subject, $tripleizer ) {
		$tripleizer->writeTriple( $subject, $tripleizer->uri('rdf:type'), $tripleizer->uri('prvTypes:DataCreatingService') );
		$tripleizer->writeTriple( $subject, $tripleizer->uri('rdfs:comment'), 'Triplify '.$tripleizer->version.' (http://Triplify.org)', true );

		$operator = '';
		if ( $this->pConfig['OperatorURI'] )
			$operator = $tripleizer->uri( $this->pConfig['OperatorURI'] );
		else if ( $this->pConfig['OperatorName'] || $this->pConfig['OperatorHomepage'] )
			$operator = $this->getNewBNodeId();
		if ( $operator ) {
			$tripleizer->writeTriple( $subject, $tripleizer->uri('prv:operatedBy'), $operator );
			if ( $this->pConfig['OperatorType'] ) {
				if ( $tripleizer->uri($this->pConfig['OperatorType']) != $tripleizer->uri('prv:HumanActor') )
					$tripleizer->writeTriple( $operator, $tripleizer->uri('rdf:type'), $tripleizer->uri($this->pConfig['OperatorType']) );
			}
			$tripleizer->writeTriple( $operator, $tripleizer->uri('rdf:type'), $tripleizer->uri('prv:HumanActor') );
			if ( $this->pConfig['OperatorName'] )
				$tripleizer->writeTriple( $operator, $tripleizer->uri('foaf:name'), $this->pConfig['OperatorName'], true );
			if ( $this->pConfig['OperatorHomepage'] )
				$tripleizer->writeTriple( $operator, $tripleizer->uri('foaf:homepage'), $this->pConfig['OperatorHomepage'] );
		}
	}

	function describeCreation ( $subject, $tripleizer ) {
		$tripleizer->writeTriple( $subject, $tripleizer->uri('rdf:type'), $tripleizer->uri('prv:DataCreation') );
		$tripleizer->writeTriple( $subject,
		                          $tripleizer->uri('prv:performedAt'),
		                          date('c',$this->now),
		                          true,
		                          $tripleizer->uri('xsd:dateTime') );

		$creator = $this->triplifyInstance;
		$sourceData = $this->getNewBNodeId();

		$mapping = ( $this->pConfig['Mapping'] ) ? $tripleizer->uri($this->pConfig['Mapping']) : $this->getNewBNodeId();

		$tripleizer->writeTriple( $subject, $tripleizer->uri('prv:performedBy'), $creator );
		$tripleizer->writeTriple( $subject, $tripleizer->uri('prv:usedData'), $sourceData );
		$tripleizer->writeTriple( $subject, $tripleizer->uri('prv:usedGuideline'), $mapping );

		$this->describeSourceData( $sourceData, $tripleizer );
		$this->describeMapping( $mapping, $tripleizer );
	}

	function describeSourceData ( $subject, $tripleizer ) {
		$doc = $this->getNewBNodeId();
		$tripleizer->writeTriple( $subject, $tripleizer->uri('prv:containedBy'), $doc );
		$tripleizer->writeTriple( $doc, $tripleizer->uri('rdf:type'), $tripleizer->uri('prv:Representation') );

		$access = $this->getNewBNodeId();
		$tripleizer->writeTriple( $doc, $tripleizer->uri('prv:retrievedBy'), $access );
		$this->describeSourceDataAccess( $access, $tripleizer );
	}

	function describeSourceDataAccess ( $subject, $tripleizer ) {
		$tripleizer->writeTriple( $subject,
		                          $tripleizer->uri('rdf:type'),
		                          $tripleizer->uri('prv:DataAccess') );
		$tripleizer->writeTriple( $subject,
		                          $tripleizer->uri('prv:performedAt'),
		                          date('c',$this->now),
		                          true,
		                          $tripleizer->uri('xsd:dateTime') );

		if ( $this->pConfig['DatabaseServer'] )
			$tripleizer->writeTriple( $subject,
			                          $tripleizer->uri('prv:accessedServer'),
			                          $tripleizer->uri($this->pConfig['DatabaseServer']) );

		$accessor = $this->triplifyInstance;
		$tripleizer->writeTriple( $subject, $tripleizer->uri('prv:performedBy'), $accessor );
	}

	function describeMapping ( $subject, $tripleizer ) {
		$tripleizer->writeTriple( $subject, $tripleizer->uri('rdf:type'), $tripleizer->uri('prvTypes:TriplifyMapping') );
	}

	function getNewBNodeId () {
		$this->bNodeCounter++;
		return '_:x'.$this->bNodeCounter;
	}
}

?>