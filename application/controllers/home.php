<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index(){
        $data['title'] = 'Página principal';
        $data['content'] = '<h3>Buscar desaparecido:</h3>';
        $data['content'] .= '<div>Nome: <br /><input type="text" /></div>';
        $data['content'] .= '<div>Sexo: <br /><select><option>Masculino</option><option>Feminino</option></select></div>';
        $data['content'] .= '<div>Idade: <br /><input type="text" /></div>';
        $data['content'] .= '<div>Data desaparecimento: <br /><input type="text" /></div><br /><br /><br /><br /><br /><br />';

        $this->load->view('tema/page', $data);
    }

    public function lista_desaparecidos(){
        $data['breadcrumbs'][] = array('title' => 'Página principal', 'link' => '');
        $data['breadcrumbs'][] = array('title' => 'Lista desaparecidos', 'link' => '');
        $data['title'] = 'Lista de desaparecidos';        
        //Criando a url para o aquivo json

        $query="
prefix foaf: <http://xmlns.com/foaf/0.1/>
select ?nome, ?idade from <http://desaparecidos.ice.ufjf.br:8890/DES#>
Where{
?recurso foaf:name ?nome.
?recurso foaf:age ?idade
}
";

$data=sparqlQuery($query, "http://localhost:10035/catalogs/repositories/desaparecidos");

print "Retrieved data:\n" . json_encode($data);

        $this->load->view('tema/page', $data);
    }

    public function buscar(){
        $url = url_virtuoso().'/sparql?default-graph-uri=http%3A%2F%2F192.168.56.101%3A8890%2FCSV%23&query=prefix+CSV%3A+%3Chttp%3A%2F%2F192.168.56.101%3A8890%2Fschemas%2FCSV%2F%3E%0D%0Aselect+*%0D%0Awhere{%0D%0A%3Fc+CSV%3Adadoscomplementares+%3Fdadoscomplementares.%0D%0A%3Fc+CSV%3Apeso+%3Fpeso.%0D%0A%3Fc+CSV%3Asexo+%3Fsexo.%0D%0A%3Fc+CSV%3Acidade+%3Fcidade.%0D%0A%3Fc+CSV%3Aestado+%3Festado.%0D%0A%3Fc+CSV%3Aaltura+%3Faltura.%0D%0A%3Fc+CSV%3Acorolhos+%3Fcorolhos.%0D%0A%3Fc+CSV%3Afonte+%3Ffonte.%0D%0A%3Fc+CSV%3Aidade+%3Fidade.%0D%0A%3Fc+CSV%3Adatadesaparecimento+%3FdataDesaparecimento.%0D%0A%3Fc+CSV%3Anome+%27'.urlencode("Leticia de Oliveira").'%27%0D%0A}&format=text%2Fxml&debug=on&timeout=';
        $str = file_get_contents($url);
        $xml = simplexml_load_string($str);
        $data['content'] = '<table class="tabela"><thead><tr><th>Nome</th><th>Data do Desaparecimento</th></tr></thead><tbody>';

        foreach ($xml->results->result as $value) {
            $data['content'] .= '<tr><td>'.$value->binding[0]->literal.'</td><td>'.$value->binding[1]->literal.'</td></tr>';
        }
        $data['content'] .= '</tbody></table>';


        $this->load->view('tema/page', $data);
    }
    
    public function detalhe($id = 1){
        //print_r($_SERVER);
        $data['content'] = '<div class="detalhe">';

        $data['breadcrumbs'][] = array('title' => 'Página principal', 'link' => '');
        $data['breadcrumbs'][] = array('title' => 'Lista desaparecidos', 'link' => 'lista_desaparecidos');

        $fields = array('nome', 'sexo', 'situacao', 'datadesaparecimento', 'fonte', 'estado', 'cidade');
        $query = 'prefix DES: <'.get_schema().'> select * where{ ?a DES:id "'.$id.'". ';
        foreach ($fields as $value){
            $query .= '?a DES:'.$value.' ?'.$value.'. ';
        }
        $query .= ' }';
        $url = url_virtuoso().'/sparql?default-graph-uri='.urlencode(get_graph()).'&query='.urlencode($query).'&'.urlencode('format=text/html').'&debug=on&timeout=';
        $url_rdf = url_virtuoso().'/sparql?default-graph-uri='.urlencode(get_graph()).'&query='.urlencode($query).'&'.urlencode('application/rdf+xml').'&debug=on&timeout=';
        $str = file_get_contents($url);
        $xml = simplexml_load_string($str);

        if(sizeof($xml->results->result) == 0){
            $data['title'] = 'Endereço inválido';
            $data['content'] .= 'Nenhum registro encontrado para esta identificação.';
        }

        foreach ($xml->results->result as $value) {
            $data['title'] = $value->binding[1]->literal;
            $data['content'] .= '<img class="img-desaparecido" src="'.base_url().'/images/img-desaparecido.png" />';
            $data['content'] .= '<a title="Download do RDF" href="'.$url_rdf.'"><img class="img-download-rdf" src="'.base_url().'/images/rdf_icon.gif" /></a>';
            $data['content'] .= '<div class="field"><label>Sexo: </label>'.$value->binding[2]->literal.'</div>';
            $data['content'] .= '<div class="field"><label>Situação: </label>'.$value->binding[3]->literal.'</div>';
            $data['content'] .= '<div class="field"><label>Data de desaparecimento: </label>'.$value->binding[4]->literal.'</div>';
            $data['content'] .= '<div class="field"><label>Estado: </label>'.$value->binding[6]->literal.'</div>';
            $data['content'] .= '<div class="field"><label>Cidade: </label>'.$value->binding[7]->literal.'</div>';
            $data['content'] .= '<div class="field"><label>Fonte: </label><a href="'.$value->binding[5]->literal.'">'.$value->binding[5]->literal.'</a></div>';
            
        }
        $data['content'] .= '</div>';
        $this->load->view('tema/page', $data);
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
