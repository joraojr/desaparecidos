<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");



for ($i = 1; $i <= 24; $i++) {
    $page = "http://www.policiacivil.am.gov.br/desaparecidos/pag/$i";
    $html = file_get_html($page);
    foreach ($html->find('div.grid-item a') as $people) {
        $html_people = file_get_html($people->href);
        $data = array();
        $data["Foto"] = $html_people->find('div.img-identifica img', 0)->src;
        $data["Fonte"] = $people->href;
        $data["Nome"] = trim(html_entity_decode($html_people->find('div.post-text text', 1)->_[4]));
        foreach ($html_people->find('div.post-text p') as $metadata) {
            if($metadata->find('text', 1)->_[4] == "")
                     break;
            $data[$metadata->find('text', 1)->_[4]] = trim($metadata->find('text', 2)->_[4]);
        }
        $detalhes = "";
        foreach ($html_people->find('div.post-text p[style=text-align: justify;]') as $metadata) {
            $detalhes.= trim(($metadata->find('text',0)->_[4]));
        }
        $data["Detalhes"] = html_entity_decode($detalhes);
        //var_dump($data);
        $p = new Pessoa();
        $p->nome = $data["Nome"];
        $p->imagem = $data["Foto"];
        $p->fonte = $data["Fonte"];
        $p->datanasc = $data["Data de Nascimento:"];
        $p->data_desaparecimento = $data["Desaparecimento:"];
        $p->local_desaparecimento = $data["Local:"];
        $p->mais_caracteristicas = $data["Detalhes"];
        $p->estado = "AM";

        atualizacao_Principal($p);
    }
}

