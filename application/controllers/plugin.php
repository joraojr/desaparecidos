<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plugin extends CI_Controller {

    public function index(){
        $data['breadcrumbs'][] = array('title' => 'Página principal', 'link' => '');
        $data['breadcrumbs'][] = array('title' => 'Extesão para Firefox', 'link' => '');
        $data['title'] = 'Extesão para Firefox';
        $this->load->view('tema/pages/plugin', $data);
    }
 
}

/* End of file plugin.php */
/* Location: ./application/controllers/plugin.php */

