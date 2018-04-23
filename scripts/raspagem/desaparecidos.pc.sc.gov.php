<?php

include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");

$page = "http://desaparecidos.pc.sc.gov.br/desaparecidosSite/";

$dom = str_get_html($page);

$html = file_get_html($pagina);

