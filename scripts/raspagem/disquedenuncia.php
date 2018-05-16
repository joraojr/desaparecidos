<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");


for ($i = 1; $i <= 2; $i ++) {
    $url = "http://disquedenuncia.com/desaparecidos/page/$i";
    $html = file_get_html($url);
    foreach($html->find('div#quadro-tipo2 a div#individuo') as $people){
        $data = array();
        $html_people = file_get_html($people->parent->attr["href"]);
        $data['Fonte'] = $people->parent->attr["href"];
        $data['Foto'] = $html_people->find('div#individuo-destaque img',0)->src;
        $data['Nome'] = $html_people->find('div#individuo-legenda-destaque p text',0)->_[4];
    //    $data['Idade'] = $html_people->find('div#informacoes-individuo-destaque p text',0)->_;
    //    $data['Data de desaparecimento'] = $html_people->find('div#informacoes-individuo-destaque p text',1)->_;
    //    $data['Bairro'] = $html_people->find('div#informacoes-individuo-destaque p text',2)->_;
    //    $data['Cidade'] = $html_people->find('div#informacoes-individuo-destaque p text',3)->_;
    //    $data['Estado'] = $html_people->find('div#informacoes-individuo-destaque p text',4)->_;
        foreach($html_people->find('div#informacoes-individuo-destaque p') as $metadata){
            $metadata = explode(":", $metadata->find('text',0)->_[4]);
            $data[$metadata[0]] = $metadata[1];
        }
         //var_dump($data);
        $p = new Pessoa();
        $p->fonte = $data["Fonte"];
        $p->imagem = $data["Foto"];
        $p->nome = $data["Nome"];
        $p->idade = $data["Idade"];
        $p->data_desaparecimento = $data["Desaparecimento"];
        $p->local_desaparecimento = $data["Bairro"];
        $p->cidade = $data["Cidade"];
        $p->estado = $data["Estado"];

        atualizacao_Principal($p);

    }
}