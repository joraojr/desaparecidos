<?php

class Desaparecido_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function getAll(){
       $query = $this->db->get('pessoa_desaparecida');       
       return $query->result();
    }

    function getById($id = -1){
        $query = $this->db->get_where('pessoa_desaparecida', array('id' => $id));
        return $query->row();
    }

    function getWhere($arr){
        foreach ($arr as $key => $value) {
            $this->db->getwhere('pessoa_desaparecida', array($key => $value));
        }
        return $query->result();
    }
    
    function getLikeName($name){
        $this->db->like('nome', $name); 
        $query = $this->db->get('pessoa_desaparecida');
        return $query->result();
    }

    function countAll(){
         return $this->db->count_all('pessoa_desaparecida');
    }

    function personExist($id = -1){
        $query = $this->db->get_where('pessoa_desaparecida', array('id' => $id));
        $result = $query->result();
        if(sizeof($result) != 0)
            return true;
        else
            return false;
    }
}

?>
