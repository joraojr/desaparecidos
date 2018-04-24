<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.

*/

require_once '../vendor/autoload.php';
use thiagoalessio\TesseractOCR\TesseractOCR;

$TC = new TesseractOCR('/home/joraojr/Documentos/jorao/ufjf/Artigo Desaparecidos/jose_joao-1.jpg');

$result = $TC->lang('por')->run();

print_r(explode("\n",$result ));