<?php

include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");

function getPage($id,$bool){
    date_default_timezone_set('America/Sao_Paulo');
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
    $postData = array(
        'codigoDesaparecido' => '',
        'menor' => "$bool",
        'nome' => '',
        'municipio' => '',
        'ordenacao' => 3,
        'button' => 'Consultar',
        '_' => ''
        );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.desaparecidos.pr.gov.br/desaparecidos/desaparecidos.do?action=pesquisar&indice=$id"); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $page = curl_exec($ch); 
    curl_close($ch);
    return $page;
}

//http://www.desaparecidos.pr.gov.br/desaparecidos/desaparecidos.do?action=iniciarProcesso&m=false

function getStr($begin, $end, $x){
    $str ="";
    for($i = 0 ; $i < count_chars($x) ; $i ++){
        if($x[$i] == $begin){
            $i++;
            while($x[$i] != $end){
                $str.= $x[$i];
                 $i++;
            }
            break;
        }
    }
    return $str;
}

for($i = 1; $i <= 2 ; $i ++){
    $html = str_get_html(getPage($i,"true"));
    foreach ( $html->find('tr[onmouseover] div a[onclick]') as $id) {
            $source = 'http://www.desaparecidos.pr.gov.br/desaparecidos/desaparecidos.do?action=detalhesDesaparecido&c='. getStr('(',')',$id->onclick);
            $html_people = file_get_html($source);
            $data = array();
            $img = $html_people->find('span.form_value img', 0)->src;
            $img = str_replace((';'. getStr(";","?",$img)),"", $img);
            $data["Foto"] = "http://www.desaparecidos.pr.gov.br".$img;
            $data["Fonte"] = $source;
            foreach ($html_people->find('table.form_tabela') as $metadata) {
                foreach($metadata->find('tr') as $tr){
                        if($tr->find('td text',1)->_[4] == NULL)
                            break;
                        $data[$tr->find('td text',0)->_[4]] = $tr->find('td text',1)->_[4];
                }
            }
            if(count($data) >15)var_dump($data);
    }
    
}

for($i = 1; $i <= 98 ; $i ++){
    $html = str_get_html(getPage($i,"false"));
    foreach ( $html->find('tr[onmouseover] div a[onclick]') as $id) {
            $source = 'http://www.desaparecidos.pr.gov.br/desaparecidos/desaparecidos.do?action=detalhesDesaparecido&c='. getStr('(',')',$id->onclick);
            $html_people = file_get_html($source);
            $data = array();
            $img = $html_people->find('span.form_value img', 0)->src;
            $img = str_replace((';'. getStr(";","?",$img)),"", $img);
            $data["Foto"] = "http://www.desaparecidos.pr.gov.br".$img;
            $data["Fonte"] = $source;
            foreach ($html_people->find('table.form_tabela') as $metadata) {
                foreach($metadata->find('tr') as $tr){
                        if($tr->find('td text',1)->_[4] == NULL)
                            break;
                        $data[$tr->find('td text',0)->_[4]] = $tr->find('td text',1)->_[4];
                }
            }
            var_dump($data);
    }
    
}
