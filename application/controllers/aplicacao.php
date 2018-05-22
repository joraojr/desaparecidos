<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aplicacao extends CI_Controller {

    public function index(){
        $data['breadcrumbs'][] = array('title' => 'Página principal', 'link' => '');
        $data['breadcrumbs'][] = array('title' => 'Aplicação Social', 'link' => '');
        $data['title'] = 'Aplicação Social';

        $this->load->view('tema/pages/aplicacao', $data);
    }
}

/* End of file aplicacao.php */
/* Location: ./application/controllers/aplicacao.php */