<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.

*/
//composer TesseractOCR + IMAGICK

require_once '../vendor/autoload.php';
use thiagoalessio\TesseractOCR\TesseractOCR;



$tmpfile = tempnam ("/tmp", "");

$im = new Imagick();
$im->setResolution(150,150);
$im->readImage('/home/joraojr/Documentos/jorao/ufjf/Artigo Desaparecidos/jose_joao.pdf');
$im->setImageFormat('png');

$im->writeImages($tmpfile,false);
$im->clear();

$TC = new TesseractOCR($tmpfile);
$result = $TC->lang('por')->run();
print_r(array_filter(explode("\n",$result )));

unlink($tmpfile);



