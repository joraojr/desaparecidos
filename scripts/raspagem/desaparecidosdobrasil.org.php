<?php

include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");


//341 atualmente
for ($i = 1; $i <= 341; $i++) {
    $page = "http://desaparecidosdobrasil.org.br/index.php?page=search&iPage=$i";
    $html = file_get_html($page);
    foreach ($html->find('div.listing-basicinfo a') as $people) {
        $html_people = file_get_html($people->href);
        $data = array();
        $data["Foto"] = $html_people->find('div.item-photos a', 0)->href;
        $data["Localizacao"] = $html_people->find('ul[id=item_location] li text', 1)->_[4];
        $data["Descricao"] = $html_people->find('div[id=description] p text', 0)->_[4];
        $data["Fonte"] = $people->href;
        foreach ($html_people->find('div.meta') as $metadata) {
            $data[$metadata->find('text', 1)->_[4]] = $metadata->find('text', 2)->_[4];
        }
        //if(count($data)> 14) var_dump($data);

        $p = new Pessoa();
        $p->imagem = $data["Foto"];
        $p->fonte = $data["Fonte"];
        $p->local_desaparecimento = $data["Localizacao"];
        $p->nome = $data["* Nome Completo da pessoa desaparecida:"];
        $p->datanasc  = $p->idade = $data["Data de Nascimento ou idade::"];
        $p->mais_caracteristicas = $data["Descricao"];
        $p->dados_adicionais = "Boletim de ocorrência:: " . $data["Boletim de ocorrência::"] . " Nr. do Boletim de Ocorrência (B.O.):" .
            $data["Nr. do Boletim de Ocorrência (B.O.):"];

        atualizacao_Principal($p);

    }
}

