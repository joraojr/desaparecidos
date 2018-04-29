<?php

include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");


for($i = 1; $i < 2; $i++) {
    $page = "http://www.desaparecidos.rs.gov.br/lista/504/desaparecidos-menores-de-18-anos/$i";
    $href = "http://www.desaparecidos.rs.gov.br";
    $html = file_get_html($page);

    foreach ($html->find('hgroup h1 a') as $people) {

        $html_people = file_get_html($href . $people->href);

        //var_dump($html_people);


        $data = array();
        $data["Fonte"] = $href . $people->href;
        $data["Foto"] = $href . $html_people->find('figure.cArticleImagem a', 0)->href;
        //foreach ($html_people->find('article#Article14') as $metadata) {
        $data["Nome"] = $html_people->find('header h1.cArticleTitulo text',0)->_[4];
        //    $data["Foto"] = $html_people->find('article#Article14 figure.cArticleImagem a')->href;
            $data["Informações"]="" ;
                foreach ($html_people->find('div.cArticleTexto p text') as $p){
                    $data["Informações"] .= $p->_[4]. "\n";
                }
        //}

        var_dump($data);


    }
}
