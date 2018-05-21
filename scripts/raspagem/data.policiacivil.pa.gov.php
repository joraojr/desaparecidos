<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");

$url ="http://data.policiacivil.pa.gov.br";
for($i=0 ; $i <= 5; $i ++){
    $html = file_get_html("http://data.policiacivil.pa.gov.br/?q=listadesaparecidos&page=$i");
    foreach ($html->find('table tr td a') as $people) {
        $html_people = file_get_html($url . $people->href);
        $data = array();
        $data['Fonte'] = $url . $people->href;
        $data['Foto'] = $html_people->find('div.field-items a img', 0)->src;
        $data['Nome'] = $html_people->find('h1.title text', 0)->_[4];
         foreach ($html_people->find('div.field-item') as $metadata) {
            $d = trim($metadata->plaintext);
            if ($d === "")
                continue;
            $d = explode('&nbsp;', $d);
            if (count($d) == 1)
                $data['Circunstância do desaparecimento:'] = $d[0];
            else
                $data[$d[0]] = $d[1];
        }

        $p = new Pessoa();
        $p->imagem = $data["Foto"];
        $p->fonte = $data["Fonte"];
        $p->sexo = $data["Sexo:"];
        $p->datanasc = $data["Data de nascimento:"];
        $p->data_desaparecimento = $data["Data do desaparecimento:"];
        $p->local_desaparecimento = $data["Local do desaparecimento:"];
        $p->altura = $data["Altura:"];
        $p->peso = $data["Peso:"];
        $p->cor_olho = $data["Cor do olhos:"];
        $p->cor_cabelo = $data["Cor do cabelo:"];
        $p->pele = $data["Raça:"];
        $p->circunstancia_desaparecimento = $data["Circunstância do desaparecimento:"];
        $p->situacao = "Desaparecida";
        $p->estado = "PA";
        $p->nome = $data["Nome"];
        $p->dados_adicionais = "Nome do Contato: " . trim($data["Nome do Contato:"]) . " Telefone para contato: ".
            trim($data["Telefone para contato:"]) . " E-mail para contato: ". trim($data["E-mail para contato:"]) ;

        atualizacao_Principal($p);
   }

}