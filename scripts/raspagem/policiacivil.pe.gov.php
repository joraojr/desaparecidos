<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.

*/
//composer TesseractOCR + Imagick

require_once '../vendor/autoload.php';
use thiagoalessio\TesseractOCR\TesseractOCR;
include "../simple_html_dom/simple_html_dom.php";


$url = "http://www.policiacivil.pe.gov.br/";
$tmpfile = tempnam ("/tmp", "");
$tmpfile2 = tempnam ("/tmp", "");

$html = file_get_html($url."index.php/criancas-desaparecidas.html");
$table =$html->find('td[valign=top] table.contentpaneopen ',1);

foreach ($table->find('td[valign=top] table[style=width: 96%; border: 0px solid #000000;] a') as $people){

    $cmd = "wget -O $tmpfile " . '"' . $url . $people->href . '"';
    exec($cmd);
    if(filesize($tmpfile) != 0){
        $im = new Imagick();
        $im->setResolution(1000, 1000);
        $im->readImage($tmpfile);
        $im->setImageFormat('png');

        $im->writeImages($tmpfile2, false);
        $im->clear();
        $im->destroy();

        $TC = new TesseractOCR($tmpfile2);
        $result = $TC->lang('por')->run();
        print_r(array_filter(explode("\n", $result)));
    }

unlink($tmpfile);
unlink($tmpfile2);

}







