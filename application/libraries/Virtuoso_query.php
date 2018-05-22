<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//include("properties.php");

class Virtuoso_query {
    private $query;
    private $graph;
    private $format;
    private $http;
    private $result;
    //application/sparql-results+json
    
    function __construct() {
        $this->format = 'application/sparql-results+json';
        $dados = new Constant;
        $this->http = getProperty($dados->DB_HOST) ;//http://localhost:8890/sparql/ //
    }  //'http://localhost:10035/repositories/desaparecidos'

    public function load_query_sparql($query) {
        $this->query = $query;
    }

    public function load_format($format){
        $this->format = $format;
    }

    public function load_graph($graph){
        $this->graph = $graph;
    }

    public function load_sparql_http($http){
        $this->http = $http;
    }
    
    public function get_query(){
        return $this->query;
    }

    public function execute(){
        $query = str_replace('"', '123321123321', $this->query);
        $query = str_replace('(', 'asdgfasdfasdfasdf', $this->query);
        $query = str_replace(')', 'sgdfhsdfgwersdfas', $this->query);
        $params=array(
	//	"default-graph-uri" => $this->graph,
	//	"should-sponge" => "",
		"query" => $query,
	//	"debug" => "on",
	);

	$querypart="?";
	foreach($params as $name => $value){
		$querypart=$querypart . $name . '=' . urlencode($value) . "&";
	}
        $querypart = str_replace('123321123321', '"', $querypart);
        $querypart = str_replace('asdgfasdfasdfasdf', '(', $querypart);
        $querypart = str_replace('sgdfhsdfgwersdfas', ')', $querypart);
        
        
	$sparqlURL = $this->http . $querypart;
        
        ///////////////////////////////////////////////////////////////////
        /*Imprimindo o retorno 
        echo "<pre>";
       print_r($sparqlURL);
        echo "</pre>";
	*/
        ////////////////////////////////////////////////////////////////////
        $curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $sparqlURL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //Recebe o output da url como uma string
        curl_setopt($curl,CURLOPT_HTTPHEADER,array("Accept: ".$this->format));
        $this->result = curl_exec( $curl );
    }

    public function get_result(){
        return $this->result;
    }

    public function convert_json_to_simple_object($result = -1){
        if($this->format != 'application/sparql-results+json') {
            echo "[erro] - O formato deve ser do tipo <strong>application/sparql-results+json</strong>.";
            return array();
        }
        $objects = array();
        $results = json_decode($this->result);
     foreach($results->results->bindings as $reg){
            $obj = new stdClass();
            foreach($reg as $field => $value){
                $obj->$field = $value->value;
            }
            $objects[] = $obj;
        }

        if(($result == 0) && (sizeof($objects) == 1))
            return $objects[0];
        else
            return $objects;
    }

}

/* End of file virtuoso_query.php */

?>
