<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Colaboradores extends CI_Controller {

    public function index(){
        $data['breadcrumbs'][] = array('title' => 'Página principal', 'link' => '');
        $data['breadcrumbs'][] = array('title' => 'Colaboradores', 'link' => '');
        $data['title'] = 'Colaboradores';

        $this->load->view('tema/pages/colaboradores', $data);
    }
}

/* End of file colaboradores.php */
/* Location: ./application/controllers/colaboradores.php */