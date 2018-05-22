<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("properties.php");

class Access extends CI_Controller {

    public function index(){
        $this->load->view('access');
    }    
        
    public function busca_nome($nome = ''){
        $nome = urldecode($nome);
//        $data['palavra'] = $nome;
//        $this->load->model('desaparecido_model');
//        $data['desaparecidos'] = $this->desaparecido_model->getLikeName($nome);
//        $this->load->view('addon/list', $data);
        
            
        //Carrega a classe de consulta no virtuoso
        $this->load->library('virtuoso_query');
        //Carrega a classe para gerar consultas sparql
        $this->load->library('sparql');

        //Montando a consulta SPARQL

        //Defini os prefixos que serão usados
        $this->sparql->prefix("foaf", "http://xmlns.com/foaf/0.1/");
        $this->sparql->prefix("des", get_schema());
        ///////////////////////Alterado////////////////////////////////
        $this->sparql->prefix("dbpprop", "http://dbpedia.org/property/");
        
        //Defini os campos quer serão exibidos
        $this->sparql->select("?id");
        $this->sparql->select("?nome");        
        $this->sparql->select("?situacao");
        $this->sparql->select("?sexo");
        //Tripla quer será retornada - Está condição deve ser satisfeita para retornar um resultado
        $this->sparql->new_ptrn("?recurso des:id ?id");
        $this->sparql->new_ptrn('FILTER regex(?nome, "'.$nome.'", "i")');
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
        //////////////////////////Alterado/////////////////////
        $this->virtuoso_query->load_format('application/sparql-results+json');//application/json
        
        //Executa a query SPARQL
        $this->virtuoso_query->execute();

        //Retorna o resultado no formato especificado
        //$obj_json = $this->virtuoso_query->get_result();

        //Retorna como um objeto mais simples        
        $data['desaparecidos'] = $this->virtuoso_query->convert_json_to_simple_object();
        
        $data['palavra'] = $nome;                 
        $this->load->view('addon/list', $data);
    }
    
    public function detalhe($id = 0, $busca = ''){
        
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
        $this->sparql->new_ptrn("?recurso des:id $id");
        
        foreach($fields as $key => $value){
            $this->sparql->select("?$value");
            $this->sparql->optional($this->sparql->new_ptrn("?recurso $key ?$value"));
        }

        //Ordena por nome
        $this->sparql->order("?nome");
        //processa a consulta
        $query = $this->sparql->query();

        //Carregando os dados para consulta no virtuoso
        //
        //////////////////////////Alterado/////////////////////
        $dados = new Constant;
        $this->virtuoso_query->load_sparql_http($dados->DB_HOST);//http://localhost:8890/sparql/
        //'http://172.18.40.9:10035/repositories/desaparecidos1'
        $this->virtuoso_query->load_graph(get_graph());
        $this->virtuoso_query->load_query_sparql($query);
         //////////////////////////Alterado/////////////////////
        $this->virtuoso_query->load_format('application/sparql-results+json');//application/json
        //Executa a query SPARQL
        $this->virtuoso_query->execute();

        //Retorna o resultado no formato especificado
        //$obj_json = $this->virtuoso_query->get_result();

        //Retorna como um objeto mais simples
        $data['id'] = trim($id);
        $data['link'] = site_url('access/busca_nome') . '/' . trim($busca);
        $data['desaparecido'] = $this->virtuoso_query->convert_json_to_simple_object(0);
        $this->load->view('addon/detalhe', $data);
    }
}

/* End of file access.php */
/* Location: ./application/controllers/access.php */

