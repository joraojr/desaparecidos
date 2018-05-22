<?php

include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");


for($k = 1; $k <= 5; $k++){
    $page = "http://bairronanet.com.br/desaparecidos/pagina_principal_desaparecidos.php?sit=%&&sexo=%&&olhos=%&&oculos=%&&comp=%&&barba=%&&cabelo=%&&tipo=%&&pais=%&&estado=%&&cidade=%&&bairro=%&&nome=%&&pai=%&&mae=%&&pele=%&&marcas=&&img=&&np=12&&paginaatual=$k#topodapesquisa";
    $html = file_get_html($page);
    $href = "http://bairronanet.com.br/desaparecidos/";

    foreach ($html -> find('li span.MarromNomeProduto12 text') as $people) {
        $link = $href . "desaparecidos_mostra.php?cod={$people->_[4]}&linkdeacesso=pagina-pessoas-desaparecidas-btmaisinfo";
        $page_people = file_get_html($link);


        $data = array();
        $data["Fonte"] = $link;
        $data["Foto"] = $href . $page_people->find('table[cellpadding=3] img', 0)->src;

        $data["Nome"] = $page_people->find('table[cellpadding=3] span.ClassMarromEscuro14', 0)->plaintext;
        $data["Situacao"] = trim($page_people->find('table[cellpadding=3] span.ClassMarromEscuro14', 1)->plaintext);
        $data["Contato"] = trim($page_people->find('table[cellpadding=3] span.ClassMarromEscuro14', 2)->plaintext);

        for ($i = 0, $j = 0; $j<31, $i<32; $j++, $i++) {
            if($i == 1) {
                $i = $i+1;
                $data[trim($page_people->find('tr td.ClassCorpoTextoNormal13pt', $i)->plaintext)] = trim($page_people->find('tr td div[align="justify"]', $j)->plaintext);
                continue;
            }
            $data[trim($page_people->find('tr td.ClassCorpoTextoNormal13pt', $i)->plaintext)] = trim($page_people->find('tr td div[align="justify"]', $j)->plaintext);
        }
        print_r($data);
    }
}

