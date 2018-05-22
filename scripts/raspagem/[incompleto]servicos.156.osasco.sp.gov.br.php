<?php
/**
include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");

function getPage($id){
    date_default_timezone_set('America/Sao_Paulo');
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
    $postData = array(
        'pagina' => '',
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://servicos.156.osasco.sp.gov.br/desaparecidos/index.php?pagina=1");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $page = curl_exec($ch);
    curl_close($ch);
    return $page;
}



//$page = "http://servicos.156.osasco.sp.gov.br/desaparecidos/index.php?pagina=1";
$html = str_get_html(getPage(1));

print_r($html);
*/

/**
 * Created by PhpStorm.
 * User: ramon
 * Date: 24/04/18
 * Time: 13:29
 */



include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");

for($i = 1; $i <= 2; $i++) {
    $page = "http://servicos.156.osasco.sp.gov.br/desaparecidos/index.php?pagina=$i";
    $href = "http://servicos.156.osasco.sp.gov.br/desaparecidos/";
    $html = file_get_html($page);

    foreach ($html->find('div.caption div.text-center a') as $people) {

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