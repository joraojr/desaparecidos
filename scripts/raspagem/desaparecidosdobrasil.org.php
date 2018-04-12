<?php

include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");


//338 atualmente
for ($i = 1; $i <= 338; $i++) {
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
            $data[$metadata->find('text', 1)->_[4]] = html_entity_decode($metadata->find('text', 2)->_[4]);
        }
        print_r($data);
    }
}

