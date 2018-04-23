<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sobre extends CI_Controller {

    public function index(){
        $data['breadcrumbs'][] = array('title' => 'Página principal', 'link' => '');
        $data['breadcrumbs'][] = array('title' => 'Sobre o projeto', 'link' => '');
        $data['title'] = 'Sobre o projeto';

        $this->load->view('tema/pages/sobre', $data);
    }
}

/* End of file sobre.php */
/* Location: ./application/controllers/sobre.php */