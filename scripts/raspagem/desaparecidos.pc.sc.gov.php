<?php

include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");

$url = "http://desaparecidos.pc.sc.gov.br/desaparecidosSite/#";

$html = file_get_html($url);

var_dump($html->find('td a',0));