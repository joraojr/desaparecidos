<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");


$url = "http://data.policiacivil.pa.gov.br";
$html = file_get_html($url);

while ($html->find('li.pager-next')) {
    foreach ($html->find('table tr td a') as $people) {
        $html_people = file_get_html($url . $people->href);
        $data = array();
        $data['Fonte'] = $url . $people->href;
        $data['Foto'] = $html_people->find('div.field-items a img', 0)->src;
        foreach ($html_people->find('div.field-item') as $metadata) {
            $d = trim($metadata->plaintext);
            if ($d === "")
                continue;
            $d = explode('&nbsp;', $d);
            if (count($d) == 1)
                $data['Circunstância do desaparecimento:'] = $d[0];
            else
                $data[$d[0]] = $d[1];
        }

        var_dump($data);
    }
    $html = file_get_html($url.$html->find('li.pager-next a',0)->href);
}