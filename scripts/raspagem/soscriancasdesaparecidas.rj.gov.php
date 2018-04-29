<?php

include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");

function getPage($id) {
    date_default_timezone_set('America/Sao_Paulo');
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
    $headers = array(
        'Accept: application/json, text/javascript, */*; q=0.01',
        'Accept-Encoding: gzip, deflate',
        'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
        'Connection: keep-alive',
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        'Host: www.soscriancasdesaparecidas.rj.gov.br',
        'Origin: http://www.soscriancasdesaparecidas.rj.gov.br',
        'Referer: http://www.soscriancasdesaparecidas.rj.gov.br/consulta_publica/consulta_publica.php',
        'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36',
        'X-Requested-With: XMLHttpRequest'
    );

    $postData = array(
        'nome' => "",
        'idadeInicial' => "",
        'idadeFinal' => "",
        'sexo' => "",
        'pele' => "",
        'corOlhos' => "",
        'tipoCabelo' => "",
        'corCabelo' => "",
        'paginaAtual' => "$id",
        'situacao' => "1",
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.soscriancasdesaparecidas.rj.gov.br/consulta_publica/consulta_publica.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookieDesaparecidos.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookieDesaparecidos.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $output = curl_exec($ch);
    
    curl_close($ch);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.soscriancasdesaparecidas.rj.gov.br/consulta_publica/corpo_consulta_publica.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookieDesaparecidos.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookieDesaparecidos.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    
    $page = curl_exec($ch);
    

    curl_close($ch);

    return $page;
}

echo(getPage(2));

