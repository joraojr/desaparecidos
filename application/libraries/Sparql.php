<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*************************************************************
 * This script is developed by Arturs Sosins aka ar2rsawseen, http://webcodingeasy.com
 * Fee free to distribute and modify code, but keep reference to its creator
 *
 * Sparql Query Builder class provides interface for generating
 * SPARQL queries to use in RDF or SPARQL endpoints.
 * It complies with W3C Recommendations http://www.w3.org/TR/rdf-sparql-query/
 * This class reduces amount of text needs to be written comparing to simply writing SPARQL queries,
 * increases code readability and helps you to create user friendly
 * interfaces for SPARQL endpoints
 *
 * For more information, examples and online documentation visit:
 * http://webcodingeasy.com/PHP-classes/Sparql-Query-Builder
 **************************************************************/

class Sparql
{
	//array with graph patterns
	private $pattern = array();
	//contains query type to use (SELECT, ASK, DESCRIBE, CONSTRUCT)
	private $query_type = 'SELECT';
	//string containing prefixes
	private $pref = '';
	//string containing select infromartion
	private $select = '';
	//string containing select type infromartion
	private $select_type = '';
	//string containing construct informaion
	private $construct = 'CONSTRUCT {';
	//string containing describe information
	private $describe = 'DESCRIBE ';
	//string containing askinformaion
	private $ask = 'ASK {';
	//specify sources from where to select
	private $from = array();
	//specify sources from where to select
	private $from_named = array();
	//string containing where clause
	private $where = "WHERE {\n";
	//array containing optional clauses
	private $option = array();
	//array containing graph clauses
	private $graphs = array();
	//bool if true, outputs debug info
	private $debug = false;
	//internal counter for debug info outpu
	private $deb_cnt = 1;
	//bool - if true, outputs query
	private $show_query = false;
	//string containing order information
	private $order = '';
	//string containing limit information
	private $limit = '';
	//string containing offset information
	private $offset = '';
	//patterns which by which to unite
	private $union_head = '';
	//other union elements
	private $union = array();
	//error storage
	private $errors = array();

	//enables debug mode and outputs step by step informationinformation
	public function debug(){
		$this->debug = true;
	}
	//enables debug mode and outputs only end query
	public function show_query(){
		$this->show_query = true;
	}
	//adding prefix $name - prefix contraction, $prefix - URI to contract
	public function prefix($name, $prefix){
		$this->pref .= "PREFIX ".$name.": <".$prefix.">\n";
		if($this->debug)
		{
			echo "<pre>".($this->deb_cnt++).") Prefix added: \n".htmlspecialchars($this->pref)."</pre>";
		}
	}
	//adding what to select
	//if not specified all nodes will be selected
	public function select($sel){
		$this->select .= $sel." ";
		$this->query_type = 'SELECT';
		if($this->debug)
		{
			echo "<pre>".($this->deb_cnt++).") Select information added:\n  ".($this->select)."</pre>";
		}
	}
	//query type - describe
	public function describe($sub){
		$this->describe .= $sub." ";
		$this->query_type = 'DESCRIBE';
		if($this->debug)
		{
			echo "<pre>".($this->deb_cnt++).") Describe information added:\n  ".($this->describe)."</pre>";
		}
	}
	//if not specified all nodes will be selected
	public function select_type($type){
		if(in_array(strtoupper($type), array("REDUCED", "DISTINCT")))
		{
			$this->select_type .= strtoupper($type);
			if($this->debug)
			{
				echo "<pre>".($this->deb_cnt++).") Select type added:\n  ".($this->select_type)."</pre>";
			}
		}
		else if($this->debug)
		{
			echo "<p style='font-weight:bold;'>".($this->deb_cnt++).") Incorrect select type specified</p>";
		}
	}
	//add pattern to construct
	public function construct($cnt){
		$this->construct .= $this->pattern[$cnt];
		unset($this->pattern[$cnt]);
		$this->query_type = "CONSTRUCT";
		if($this->debug)
		{
			echo "<pre>".($this->deb_cnt++).") Construct information added:\n  ".($this->construct)."}</pre>";
		}
	}
	//add pattern to ask
	public function ask($cnt){
		$this->ask .= $this->pattern[$cnt];
		unset($this->pattern[$cnt]);
		$this->query_type = "ASK";
		if($this->debug)
		{
			echo "<pre>".($this->deb_cnt++).") ASK information added:\n  ".($this->ask)."}</pre>";
		}
	}
	//create new pattern with nodes or graph
	public function new_ptrn($graph){
		$this->pattern[] = $graph;
		$keys = array_keys($this->pattern);
		$cnt = end($keys);
		if($this->debug)
		{
			echo "<pre>".($this->deb_cnt++).") New pattern created: \n".htmlspecialchars($this->pattern[$cnt])."</pre>";
		}
		return $cnt;
	}
	//add node or graph to existing pattern
	public function add_ptrn($cnt, $graph){
		$keys = array_keys($this->pattern);
		if(in_array($cnt, $keys))
		{
			$this->pattern[$cnt] .= " ".$graph;
			if($this->debug)
			{
				echo "<pre>".($this->deb_cnt++).") Adding pattern to: \n".htmlspecialchars($this->pattern[$cnt])."</pre>";
			}
		}
		else
		{
			if($this->debug)
			{
				echo "<p style='font-weight:bold;'>".($this->deb_cnt++).") Can't add to specified pattern, because it doesn't exist</p>";
			}
		}
	}
	//add pattern to
	public function where($cnt){
		$keys = array_keys($this->pattern);
		if(in_array($cnt, $keys))
		{
			$this->where .= $this->pattern[$cnt]."\n";
			unset($this->pattern[$cnt]);
			if($this->debug)
			{
				echo "<pre>".($this->deb_cnt++).") Adding to where clause: \n".htmlspecialchars($this->where)."}</pre>";
			}
		}
		else
		{
			if($this->debug)
			{
				echo "<p style='font-weight:bold;'>".($this->deb_cnt++).") Can't add to where clause, because specified pattern does not exist</p>";
			}
		}
	}
	//adding to specified option clause or creating new clause, if none specified
	public function optional($cnt, $opt = ""){
		$keys = array_keys($this->pattern);
		if(in_array($cnt, $keys))
		{
			if($opt !== "")
			{
				$keys = array_keys($this->option);
				if(in_array($opt, $keys))
				{
					$this->option[$opt] .= ($this->pattern[$cnt])."\n";
					unset($this->pattern[$cnt]);
					if($this->debug)
					{
						echo "<pre>\n".($this->deb_cnt++).") Adding to optional: \n";
						print_r($this->option );
						echo "</pre>";
					}
					return $opt;
				}
				else
				{
					echo "<p style='font-weight:bold;'>".($this->deb_cnt++).") Specified optional clause does not exist</p>";
					return false;
				}
			}
			else
			{
				$this->option[] = ($this->pattern[$cnt])."\n";
				unset($this->pattern[$cnt]);
				$keys = array_keys($this->option);
				$cnt = end($keys);
				if($this->debug)
				{
					echo "<pre>\n".($this->deb_cnt++).") Adding to optional: \n";
					print_r($this->option );
					echo "</pre>";
				}
				return $cnt;
			}
		}
		else
		{
			if($this->debug)
			{
				echo "<p style='font-weight:bold;'>".($this->deb_cnt++).") Can't add to optional clause because specified pattern does not exist</p>";
			}
			return false;
		}
	}
	//adding to specified graph clause
	public function graph($cnt, $opt){
		$keys = array_keys($this->pattern);
		if(in_array($cnt, $keys))
		{
			$keys = array_keys($this->graphs);
			if(!in_array($opt, $keys))
			{
				$this->graphs[$opt] = "";
			}
			$this->graphs[$opt] .= ($this->pattern[$cnt])."\n";
			unset($this->pattern[$cnt]);
			if($this->debug)
			{
				echo "<pre>\n".($this->deb_cnt++).") Adding to graph $opt: \n".$this->graphs[$opt];
				echo "</pre>";
			}
			return $opt;
		}
		else
		{
			if($this->debug)
			{
				echo "<p style='font-weight:bold;'>".($this->deb_cnt++).") Can't add to GRAPH because, specified pattern does not exist</p>";
			}
			return false;
		}
	}
	//specify source
	public function from($value){
		$this->from[] = $value;
	}
	//specify source
	public function from_named($value){
		$this->from_named[] = $value;
	}
	//specifying patterns, that will be used in every union clause, by which will unite results
	public function union_h($cnt){
		$keys = array_keys($this->pattern);
		if(in_array($cnt, $keys))
		{
			$this->union_head .= ($this->pattern[$cnt])."\n";
			unset($this->pattern[$cnt]);
			if($this->debug)
			{
				echo "<pre>".($this->deb_cnt++).") Adding union head  to: \n".htmlspecialchars($this->union_head)."</pre>";
			}
		}
		else
		{
			if($this->debug)
			{
				echo "<p style='font-weight:bold;'>".($this->deb_cnt++).") Can't add union head to union clause, because specified pattern does not exist</p>";
			}
			return false;
		}
	}
	//specifying unions
	public function union($cnt, $opt = ""){
		$keys = array_keys($this->pattern);
		if(in_array($cnt, $keys))
		{
			if($opt !== "")
			{
				$keys = array_keys($this->union);
				if(in_array($opt, $keys))
				{
					$this->union[$opt] .= ($this->pattern[$cnt])."\n";
					unset($this->pattern[$cnt]);
					if($this->debug)
					{
						echo "<pre>".($this->deb_cnt++).") Adding to union: \n";
						print_r($this->union);
						echo "</pre>";
					}
					return $opt;
				}
				else
				{
					echo "<p style='font-weight:bold;'>".($this->deb_cnt++).") Can't add to union clause, because specified pattern does not exist</p>";
					return false;
				}
			}
			else
			{
				$this->union[] = ($this->pattern[$cnt])."\n";
				unset($this->pattern[$cnt]);
				$keys = array_keys($this->union);
				$cnt = end($keys);
				if($this->debug)
				{
					echo "<pre>".($this->deb_cnt++).") Adding to union: \n";
					print_r($this->union);
					echo "</pre>";
				}
				return $cnt;
			}
		}
		else
		{
			if($this->debug)
			{
				echo "<p style='font-weight:bold;'>".($this->deb_cnt++).") Specified union clause does not exist</p>";
			}
			return false;
		}
	}
	//setting limit
	public function limit($lim){
		if($lim > 0)
		{
			$this->limit = 'LIMIT '.$lim;
			if($this->debug)
			{
				echo "<pre>".($this->deb_cnt++).") Adding limit: ".($this->limit)."</pre>";
			}
		}
		else
		{
			if($this->debug)
			{
				echo "<p style='font-weight:bold;'>".($this->deb_cnt++).") Limit can not be negative number</p>";
			}
		}
	}
	//setting offset
	public function offset($off){
		$this->offset = 'OFFSET '.$off;
		if($this->debug)
		{
			echo "<pre>".($this->deb_cnt++).") Adding offset: ".($this->offset)."</pre>";
		}
	}
	//order information
	public function order($ord, $desc = false){
		if($desc)
		{
			$this->order = "\nORDER BY DESC(".$ord.")";
		}
		else
		{
			$this->order = "\nORDER BY ".$ord;
		}
	}
	//generate sparql query
	public function query(){
		//checking if select was provided
		switch($this->query_type)
		{
			case "SELECT":
				if($this->select == '')
				{
					$this->select = 'SELECT '.($this->select_type).' *';
				}
				else
				{
					$this->select = 'SELECT '.($this->select_type).' '.$this->select;
				}
				if(!empty($this->from))
				{
					foreach($this->from as $key => $value)
					{
						$this->select .= "\n FROM <".$value.">";
						unset($this->from[$key]);
					}
				}
				if(!empty($this->from_named))
				{
					foreach($this->from_named as $key => $value)
					{
						$this->select .= "\n FROM NAMED <".$value.">";
						unset($this->from_named[$key]);
					}
				}
			break;
			case "CONSTRUCT":
				$this->select = ($this->construct)."}";
			break;
			case "DESCRIBE":
				$this->select = ($this->describe)." ";
			break;
			case "ASK":
				$this->select = ($this->ask)."}";
			break;
		}

		//checking if any union was specified
		if(!empty($this->union))
		{
			//if yes, then no patterns can be outside union clause
			$state = 1;
			foreach($this->union as $key => $value)
			{
				//including union_head in every union clause

				if($state)
				{
					$this->where .= "{\n".($this->union_head).($value)."}\n";
					$state--;
				}
				else
				{
					$this->where .= "UNION {\n".($this->union_head).($value)."}\n";
				}
				unset($this->union[$key]);
			}
			//putting all other specified but unused patterns in last union clause
			$temp_pat = "";
			foreach($this->pattern as $key => $value)
			{
				$temp_pat .= $value." \n";
				unset($this->pattern[$key]);
			}
			if(trim($temp_pat) != "")
			{
				$this->where .= "UNION {\n".($this->union_head).($temp_pat)."}\n";
			}
			$this->union_head = "";
		}
		//if nothing is in where clause, then just putting every specified patern in where clause
		if($this->where == "WHERE {\n")
		{
			if(!empty($this->pattern))
			{
				foreach($this->pattern as $key => $value)
				{
					$this->where .= $value." \n";
					unset($this->pattern[$key]);
				}
			}
		}
		//checking if there are any graphs created if yes, puting them into where clause
		if($this->graphs != array())
		{
			foreach($this->graphs as $key => $value)
			{
				$this->where .= 'GRAPH '.$key." {\n".($value)."}.\n";
				unset($this->graphs[$key]);
			}
		}
		//checking if there are any optional patterns if yes, puting them into where clause
		if($this->option != array())
		{
			foreach($this->option as $key => $value)
			{
				$this->where .= "OPTIONAL {\n".($value)."}.\n";
				unset($this->option[$key]);
			}
		}
		//checking if there is anything in where clause
		if($this->where == "WHERE {\n")
		{
			$this->where = "";
		}
		else
		{
			$this->where .= "}";
		}
		//adding prefix and select to query
		$query = ($this->pref)."".($this->select)."\n".($this->where);
		$this->pref = "";
		$this->select = '';
		$this->select_type = '';
		$this->query_type = 'SELECT';
		$this->construct = 'CONSTRUCT {';
		$this->ask = 'ASK {';
		$this->describe = 'DESCRIBE ';
		$this->where = "WHERE {\n";


		//if specified order, adding order
		if($this->order != '')
		{
			$query .= ' '.($this->order);
			$this->order = '';
		}
		//if specified limit adding limit
		if($this->limit != '')
		{
			$query .= "\n".($this->limit);
			$this->limit = '';
		}
		//if specified offset adding offset
		if($this->offset != '')
		{
			$query .= "\n".($this->offset);
			$this->offset = '';
		}
		if($this->debug || $this->show_query)
		{
			echo "<pre>".($this->deb_cnt++).") Building query: \n".htmlspecialchars($query)."</pre>";
		}
		return $query;
	}
}


/* End of file sparql.php */

?>