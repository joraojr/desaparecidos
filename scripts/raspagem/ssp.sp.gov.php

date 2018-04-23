<?php

error_reporting(E_ALL);
include("atualizacaoPrincipal.php");
include("../simple_html_dom/simple_html_dom.php");

$url = "http://200.144.31.45/desaparecidos/";
$html = file_get_html($url);

for ($i = 1; $i <= 338; $i++) {
    $html_people = file_get_html($url);
    $data = array();
    $data["Foto"] = $url.$html->find('div.DivPanelDesaparecidoFoto img',0)->src;
    $data["Nome"] = $html->find('div.DivPanelDesaparecidoDados b i span text',0)->_[4];
      foreach($html->find('div.DivGeralDesaparecido')as $metadata){
          $x = $metadata->find('div.DivPanelDesaparecidoDados span',0)->id ;
          $x = str_replace("Nome", "Caracter", $x);
          $alt = $metadata->find("div.DivPanelDesaparecidoDados span[id=$x]",0)->plaintext;
          $alt = explode(":  ", $alt);
          $data[$alt[0]] = $alt[1];
          for($i = 0 ; $i<=6 ; $i ++){
              $data[$metadata->find('div.DivPanelDesaparecidoDados div.divPontilhada b label text',$i)->_[4]] = 
                      $metadata->find('div.DivPanelDesaparecidoDados div.divPontilhada span text',$i - 1)->_[4];
           
          }
    }
          
          
    
    print_r($data);
}
