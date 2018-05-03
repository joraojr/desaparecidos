<?php
//Ainda precisa criar a lógica para a paginação incluir novos registros
include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");


for($i = 1; $i <= 10; $i++) {
    $page = "http://www.desaparecidos.rs.gov.br/lista/505/desaparecidos-maiores-de-18-anos/$i";
    $href = "http://www.desaparecidos.rs.gov.br";
    $html = file_get_html($page);

    foreach ($html->find('hgroup h1 a') as $people) {

        $html_people = file_get_html($href . $people->href);


        $data = array();
        $data["Fonte"] = $href . $people->href;
        $data["Foto"] = $href . $html_people->find('figure.cArticleImagem a', 0)->href;
        $data["Nome"] = $html_people->find('header h1.cArticleTitulo text', 0)->_[4];
        $data["Informações"] = "";
        foreach ($html_people->find('div.cArticleTexto p text') as $p) {
            $data["Informações"] .= $p->_[4] . "\n";
        }
        var_dump($data);
    }
}