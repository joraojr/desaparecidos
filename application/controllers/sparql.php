<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sparql extends CI_Controller {

    public function index(){
        $data['breadcrumbs'][] = array('title' => 'Página principal', 'link' => '');
        $data['breadcrumbs'][] = array('title' => 'Sparql', 'link' => '');
        $data['title'] = 'Consulta Sparql';        

        $this->load->view('tema/pages/sparql', $data);
    }
}

/* End of file sparql.php */
/* Location: ./application/controllers/sparql.php */