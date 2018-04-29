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