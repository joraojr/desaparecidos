<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("properties.php");

class Desaparecido extends CI_Controller {

    public function index(){
//        $this->load->helper('download');
//        force_download('desaparecido.xml', $data);
    }

    public function lista($letra = 'TODOS'){
        $offset = 0;
        if(isset($_GET['offset'])) $offset = $_GET['offset'];
        $data['breadcrumbs'][] = array('title' => 'Página principal', 'link' => '');
        $data['breadcrumbs'][] = array('title' => 'Lista desaparecidos', 'link' => '');
        $data['title'] = 'Lista de desaparecidos';

        //Carrega a classe de consulta no virtuoso
        $this->load->library('virtuoso_query');
        //Carrega a classe para gerar consultas sparql
        $this->load->library('sparql');

        //Montando a consulta SPARQL

        //Defini os prefixos que serão usados
        $this->sparql->prefix("foaf", "http://xmlns.com/foaf/0.1/");
        $this->sparql->prefix("des", get_schema());
        ///////////////////////Alterado///////////////////////////////
        $this->sparql->prefix("dbpprop","http://dbpedia.org/property");
        
        //Defini os campos quer serão exibidos
        $this->sparql->select("?id");
        $this->sparql->select("?nome");        
        $this->sparql->select("?situacao");
        $this->sparql->select("?sexo");
        //Tripla quer será retornada - Está condição deve ser satisfeita para retornar um resultado
        $this->sparql->new_ptrn("?recurso des:id ?id");
        //Condições opcionais
        $this->sparql->optional($this->sparql->new_ptrn("?recurso foaf:name ?nome"));
        $this->sparql->optional($this->sparql->new_ptrn("?recurso des:status ?situacao"));
        $this->sparql->optional($this->sparql->new_ptrn("?recurso foaf:gender ?sexo"));
        if($letra != 'TODOS')
            $this->sparql->new_ptrn('FILTER regex(?nome, "^'.$letra.'", "i")');
        
        $this->sparql->offset($offset);
        $this->sparql->limit(50);
        //Ordena por nome
        $this->sparql->order("?nome");
        //processa a consulta
        $query = $this->sparql->query();

        //Carregando os dados para consulta no virtuoso
        /////////////////////////Alterado///////////////////////////////
        //$this->virtuoso_query->load_sparql_http('http://172.18.40.9:10035/repositories/desaparecidos1');//http://desaparecidos.ice.ufjf.br:8890/sparql/
        $this->virtuoso_query->load_graph(get_graph());
        $this->virtuoso_query->load_query_sparql($query);
        ///////////////////////Alterado///////////////////////////////
        $this->virtuoso_query->load_format('application/sparql-results+json');//application/json
        
        
        //Executa a query SPARQL
        $this->virtuoso_query->execute();

        //Retorna o resultado no formato especificado
        //$obj_json = $this->virtuoso_query->get_result();

        //Retorna como um objeto mais simples
        $data['desaparecidos'] = $this->virtuoso_query->convert_json_to_simple_object();
        $data['letra'] = strtoupper(trim($letra));        
        $data['offset'] = $offset + 50;
        $this->load->view('tema/pages/lista-desaparecidos', $data);
    }
    
    public function buscar(){
        $data['breadcrumbs'][] = array('title' => 'Página principal', 'link' => '');
        $data['breadcrumbs'][] = array('title' => 'Lista desaparecidos', 'link' => '');
        $data['title'] = 'Lista de desaparecidos';

        //Carrega a classe de consulta no virtuoso
        $this->load->library('virtuoso_query');
        //Carrega a classe para gerar consultas sparql
        $this->load->library('sparql');

        //Montando a consulta SPARQL

        //Defini os prefixos que serão usados
        $this->sparql->prefix("foaf", "http://xmlns.com/foaf/0.1/");
        $this->sparql->prefix("des", get_schema());
         ///////////////////////Alterado///////////////////////////////
        $this->sparql->prefix("dbpprop","http://dbpedia.org/property");
        
        //Defini os campos quer serão exibidos
        $this->sparql->select("?id");
        $this->sparql->select("?nome");        
        $this->sparql->select("?situacao");
        $this->sparql->select("?sexo");
        //Tripla quer será retornada - Está condição deve ser satisfeita para retornar um resultado
        $this->sparql->new_ptrn("?recurso des:id ?id");
        //Condições opcionais
        $this->sparql->optional($this->sparql->new_ptrn("?recurso foaf:name ?nome"));
        $this->sparql->optional($this->sparql->new_ptrn("?recurso des:status ?situacao"));
        $this->sparql->optional($this->sparql->new_ptrn("?recurso foaf:gender ?sexo"));
        //Ordena por nome
        $this->sparql->order("?nome");
        //processa a consulta
        $query = $this->sparql->query();

        //Carregando os dados para consulta no virtuoso
        //$this->virtuoso_query->load_sparql_http('http://desaparecidos.ice.ufjf.br:8890/sparql/');
        $this->virtuoso_query->load_graph(get_graph());
        $this->virtuoso_query->load_query_sparql($query);
        
        ///////////////////////Alterado///////////////////////////////
        $this->virtuoso_query->load_format('application/sparql-results+json');//application/json
        //
        //Executa a query SPARQL
        $this->virtuoso_query->execute();

        //Retorna o resultado no formato especificado
        //$obj_json = $this->virtuoso_query->get_result();

        //Retorna como um objeto mais simples
        $data['desaparecidos'] = $this->virtuoso_query->convert_json_to_simple_object();
        $this->load->view('tema/pages/resultado-busca', $data);
    }

    public function html($id = -1){
        if($id == -1){
            redirect('desaparecido');
            exit;
        }
        
        $ID1 = '"'.$id.'"';
        //Carrega a classe de consulta no virtuoso
        $this->load->library('virtuoso_query');
        //Carrega a classe para gerar consultas sparql
        $this->load->library('sparql');

        //Montando a consulta SPARQL

        $fields =  array(
              'foaf:name'=>'nome',
              'foaf:nick'=>'apelido',
              'foaf:birthday'=>'data_nascimento',
              'foaf:gender'=>'sexo',
              'foaf:img'=>'imagem',
              'foaf:age'=>'idade',
              'des:cityDes'=>'cidade',
              'des:stateDes'=>'estado',
              'dbpprop:height'=>'altura',
              'dbpprop:weight'=>'peso',
              'des:skin'=>'pele',
              'dbpprop:hairColor'=>'cor_cabelo',
              'dbpprop:eyeColor'=>'cor_olho',
              'des:moreCharacteristics'=>'mais_caracteristicas',
              'des:disappearanceDate'=>'data_desaparecimento',
              'des:disappearancePlace'=>'local_desaparecimento',
              'des:circumstanceLocation'=>'circunstancia_desaparecimento',
              'des:dateLocation'=>'data_localizacao',
              'des:additionalData'=>'dados_adicionais',
              'des:status'=>'status',
              'des:source'=>'fonte'
        );

        //Defini os prefixos que serão usados
        $this->sparql->prefix("foaf", "http://xmlns.com/foaf/0.1/");
        $this->sparql->prefix("des", get_schema());
        $this->sparql->prefix("dbpprop", "http://dbpedia.org/property/");

        //Tripla quer será retornada - Está condição deve ser satisfeita para retornar um resultado
        
        /////////////////////////Alterado///////////////////////////////
        $this->sparql->new_ptrn("?recurso des:id $ID1");//$id
        
        foreach($fields as $key => $value){
            $this->sparql->select("?$value");
            $this->sparql->optional($this->sparql->new_ptrn("?recurso $key ?$value"));
        }

        //Ordena por nome
        $this->sparql->order("?nome");
        //processa a consulta
        $query = $this->sparql->query();

        //Carregando os dados para consulta no virtuoso
        /////////////////////////Alterado///////////////////////////////
        $dados = new Constant;
        $this->virtuoso_query->load_sparql_http(getProperty($dados->DB_HOST));//http://localhost:8890/sparql/
        //'http://localhost:10035/repositories/desaparecidos'
        $this->virtuoso_query->load_graph(get_graph());
        $this->virtuoso_query->load_query_sparql($query);
         ///////////////////////Alterado///////////////////////////////
        $this->virtuoso_query->load_format('application/sparql-results+json');//application/json
        
        
        //Executa a query SPARQL
        $this->virtuoso_query->execute();

        //Retorna o resultado no formato especificado
        //$obj_json = $this->virtuoso_query->get_result();

        //Retorna como um objeto mais simples
        
        ///////////////////////Alterado///////////////////////////////
        $retorno = $this->virtuoso_query->convert_json_to_simple_object();
        
        // -NOVO- NÃO EXIBE QUEM JÁ FOI ENCONTRADO //
	if($retorno[0]->status == "Encontrada") {
		$this->load->view('tema/pages/pessoa-nao-encontrada');	
	}
        
        $data['desaparecido'] = $retorno[0];

        
        if(sizeof($data['desaparecido']) != 0){
            $data['breadcrumbs'][] = array('title' => 'Página principal', 'link' => '');
            $data['breadcrumbs'][] = array('title' => 'Lista desaparecidos', 'link' => 'desaparecido/lista');
            $data['breadcrumbs'][] = array('title' => $data['desaparecido']->nome);
            $data['id'] = $id;
            $this->load->view('tema/pages/detalhe-desaparecido', $data);
        }else
            $this->load->view('tema/pages/pessoa-nao-encontrada');
    }

    public function rdf($id = -1){
        if($id == -1){
            redirect('desaparecido');
            exit;
        }
        
        ////////////////////////////Alterado///////////////////////
        $ID1 = '"'.$id.'"';
        
        //Carrega a classe de consulta no virtuoso
        $this->load->library('virtuoso_query');
        //Carrega a classe para gerar consultas sparql
        $this->load->library('sparql');
      
        //Montando a consulta SPARQL

        $fields =  array(
              'foaf:name'=>'nome',
              'foaf:nick'=>'apelido',
              'foaf:birthday'=>'data_nascimento',
              'foaf:gender'=>'sexo',
              'foaf:img'=>'imagem',
              'foaf:age'=>'idade',
              'des:cityDes'=>'cidade',
              'des:stateDes'=>'estado',
              'dbpprop:height'=>'altura',
              'dbpprop:weight'=>'peso',
              'des:skin'=>'pele',
              'dbpprop:hairColor'=>'cor_cabelo',
              'dbpprop:eyeColor'=>'cor_olho',
              'des:moreCharacteristics'=>'mais_caracteristicas',
              'des:disappearanceDate'=>'data_desaparecimento',
              'des:disappearancePlace'=>'local_desaparecimento',
              'des:circumstanceLocation'=>'circunstancia_desaparecimento',
              'des:dateLocation'=>'data_localizacao',
              'des:additionalData'=>'dados_adicionais',
              'des:status'=>'status',
              'des:source'=>'fonte'
        );

        //Defini os prefixos que serão usados
        $this->sparql->prefix("foaf", "http://xmlns.com/foaf/0.1/");
        $this->sparql->prefix("des", get_schema());
        $this->sparql->prefix("dbpprop", "http://dbpedia.org/property/");

        //Tripla quer será retornada - Está condição deve ser satisfeita para retornar um resultado
        $this->sparql->new_ptrn("?recurso des:id $ID1");
        
        foreach($fields as $key => $value){
            $this->sparql->select("?$value");
            $this->sparql->optional($this->sparql->new_ptrn("?recurso $key ?$value"));
        }

        //Ordena por nome
        $this->sparql->order("?nome");
        //processa a consulta
        $query = $this->sparql->query();

        //Carregando os dados para consulta no virtuoso
        /////////////////////////Alterado///////////////////////////////
        $dados = new Constant;
        $this->virtuoso_query->load_sparql_http(getProperty($dados->DB_HOST));//http://localhost:8890/sparql/
        //'http://localhost:10035/repositories/desaparecidos'
        $this->virtuoso_query->load_graph(get_graph());
        $this->virtuoso_query->load_query_sparql($query);
        
       ///////////////////////Alterado///////////////////////////////
        $this->virtuoso_query->load_format('application/sparql-results+json');//application/json
        
       
        //Executa a query SPARQL
        $this->virtuoso_query->execute();

        //Retorna o resultado no formato especificado
        //$obj_json = $this->virtuoso_query->get_result();

        //Retorna como um objeto mais simples
        ////////////////////Alterado//////////////////////////
        //$desaparecido = $this->virtuoso_query->convert_json_to_simple_object(0);
        $retorno[] = $this->virtuoso_query->convert_json_to_simple_object(0);
        $desaparecido = $retorno[0];
        
        if(sizeof($desaparecido) != 0){
            $rdf = '<?xml version="1.0"?>
<rdf:RDF
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:foaf="http://xmlns.com/foaf/0.1/" 
	xmlns:dbpprop="http://dbpedia.org/property/"
	xmlns:being="http://purl.org/ontomedia/ext/common/being#"
	xmlns:owl="http://www.w3.org/2002/07/owl#"
	xmlns:des="http://www.desaparecidos.com.br/rdf/">
	
	<rdf:description rdf:about="http://www.desaparecidos.ufjf.br/desaparecidos/' . $id . '">
		<foaf:name>' . ((!isset($desaparecido[0]->nome)) ? $desaparecido[0]->nome : "vazio"). '</foaf:name>
		<foaf:nick>' . ((isset($desaparecido[0]->apelido))?$desaparecido[0]->apelido:""). '</foaf:nick>
		<foaf:birthday>' .((isset($desaparecido[0]->data_nascimento))?$desaparecido[0]->data_nascimento:"") . '</foaf:birthday>
		<foaf:gender>' .((isset($desaparecido[0]->sexo))?$desaparecido[0]->sexo:""). '</foaf:gender>
		<foaf:img>' .((isset($desaparecido[0]->imagem))?$desaparecido[0]->imagem:""). '</foaf:img>
		<foaf:age>' .((isset($desaparecido[0]->idade))?$desaparecido[0]->idade:""). '</foaf:age>
		<des:cityDes>' .((isset($desaparecido[0]->cidade))?$desaparecido[0]->cidade:""). '</des:cityDes>
		<des:cityDes rdf:resource="http://rdf.freebase.com/ns/en.juiz_de_fora" />
		<des:cityDes rdf:resource="http://dbpedia.org/resource/Juiz_de_Fora" />
		<des:cityDes rdf:resource="" />
		<des:cityDes rdf:resource="" />
		<des:stateDes>' .((isset($desaparecido[0]->estado))?$desaparecido[0]->estado:"") . '</des:stateDes>
		<dbpprop:height>' .((isset($desaparecido[0]->altura))?$desaparecido[0]->altura:"") . '</dbpprop:height>
		<dbpprop:weight>' .((isset($desaparecido[0]->peso))?$desaparecido[0]->peso:""). '</dbpprop:weight>
		<des:skin>' .((isset($desaparecido[0]->pele))?$desaparecido[0]->pele:"") . '</des:skin>
		<dbpprop:hairColor>' .((isset($desaparecido[0]->cor_cabelo))?$desaparecido[0]->cor_cabelo:"") . '</dbpprop:hairColor>
		<dbpprop:eyeColor>' .((isset($desaparecido[0]->cor_olho))?$desaparecido[0]->cor_olho:""). '</dbpprop:eyeColor>
		<des:moreCharacteristics>' .((isset($desaparecido[0]->mais_caracteristicas))?$desaparecido[0]->mais_caracteristicas:"") . '</des:moreCharacteristics>
		<des:disappearanceDate>' .((isset($desaparecido[0]->data_desaparecimento))?$desaparecido[0]->data_desaparecimento:""). '</des:disappearanceDate>
		<des:disappearancePlace>' .((isset($desaparecido[0]->local_desaparecimento))?$desaparecido[0]->local_desaparecimento:"") . '</des:disappearancePlace>
		<des:circumstanceLocation>' .((isset($desaparecido[0]->circunstancia_desaparecimento))?$desaparecido[0]->circunstancia_desaparecimento:"") . '</des:circumstanceLocation>
		<des:dateLocation>' .((isset($desaparecido[0]->data_localizacao))?$desaparecido[0]->data_localizacao:""). '</des:dateLocation>
		<des:additionalData>' .((isset($desaparecido[0]->dados_adicionais))?$desaparecido[0]->dados_adicionais:""). '</des:additionalData>
		<des:status>' .((isset($desaparecido[0]->status))?$desaparecido[0]->status:""). '</des:status>
		<des:source>' .((isset($desaparecido[0]->fonte))?$desaparecido[0]->fonte:""). '</des:source>
	</rdf:description>
</rdf:RDF>';
            $this->load->helper('download');
            force_download('desaparecido-'.$id.'.rdf', $rdf);
        }else            
            $this->load->view('tema/pages/pessoa-nao-encontrada');
    }
    
    public function teste(){
        $result = new stdClass();  
        $result->error = 0;
        $texto = 'Leticia';
        //Carrega a classe de consulta no virtuoso
        $this->load->library('virtuoso_query');
        //Carrega a classe para gerar consultas sparql
        $this->load->library('sparql');

        //Montando a consulta SPARQL

        //Defini os prefixos que serão usados
        $this->sparql->prefix("foaf", "http://xmlns.com/foaf/0.1/");
        $this->sparql->prefix("des", get_schema());
        
        $fields =  array(
              'foaf:name'=>'nome',
              'foaf:nick'=>'apelido',
              'foaf:birthday'=>'data_nascimento',
              'foaf:gender'=>'sexo',
              'foaf:img'=>'imagem',
              'foaf:age'=>'idade',
              'des:cityDes'=>'cidade',
              'des:stateDes'=>'estado',
              'dbpprop:height'=>'altura',
              'dbpprop:weight'=>'peso',
              'des:skin'=>'pele',
              'dbpprop:hairColor'=>'cor_cabelo',
              'dbpprop:eyeColor'=>'cor_olho',
              'des:moreCharacteristics'=>'mais_caracteristicas',
              'des:disappearanceDate'=>'data_desaparecimento',
              'des:disappearancePlace'=>'local_desaparecimento',
              'des:circumstanceLocation'=>'circunstancia_desaparecimento',
              'des:dateLocation'=>'data_localizacao',
              'des:additionalData'=>'dados_adicionais',
              'des:status'=>'situacao',
              'des:source'=>'fonte'
        );
        
        //Defini os campos quer serão exibidos
        $this->sparql->select("?id");
        $this->sparql->select("?nome");        
        $this->sparql->select("?situacao");
        $this->sparql->select("?sexo");
        //Tripla quer será retornada - Está condição deve ser satisfeita para retornar um resultado
        $this->sparql->new_ptrn("?recurso des:id ?id");
        //Condições opcionais
        foreach($fields as $key => $value){            
            $this->sparql->optional($this->sparql->new_ptrn("?recurso $key ?$value"));
        }
        
        if($texto != ''){
            $this->sparql->new_ptrn('FILTER ( ' . $texto . ' ) ');
            //$this->sparql->new_ptrn('FILTER regex(?nome, "a", "i")');
        }
        
        
        
        //Ordena por nome
        $this->sparql->order("?nome");
        //processa a consulta
        echo $this->sparql->query();

    }
    
    

}

/* End of file desaparecido.php */
/* Location: ./application/controllers/desaparecido.php */
