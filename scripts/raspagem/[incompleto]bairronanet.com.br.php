<?php

include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");


for($i = 1; $i <= 1; $i++){
    $page = "http://bairronanet.com.br/desaparecidos/pagina_principal_desaparecidos.php?sit=%&&sexo=%&&olhos=%&&oculos=%&&comp=%&&barba=%&&cabelo=%&&tipo=%&&pais=%&&estado=%&&cidade=%&&bairro=%&&nome=%&&pai=%&&mae=%&&pele=%&&marcas=&&img=&&np=12&&paginaatual=1#topodapesquisa";
    $html = file_get_html($page);
    $href = "http://bairronanet.com.br/desaparecidos/";

    foreach ($html -> find('li span.MarromNomeProduto12 text') as $people){
        $link = $href . "desaparecidos_mostra.php?cod={$people->_[4]}&linkdeacesso=pagina-pessoas-desaparecidas-btmaisinfo";
        $page_people = file_get_html($link);

        $data = array();
        $data["Fonte"] = $link;
//        $data["Nome"] = $page_people -> find('table[cellpadding=3] span.ClassMarromEscuro14', 0)->plaintext;
//        $data["Foto"] = $href . $page_people -> find('table[cellpadding=3] img', 0)->src;
//        $data["Contato"] = $html -> find('span.ClassMarromNormal16', 0)->plaintext;
//
        //}
        foreach ($page_people -> find('table[cellpadding=3]') as $inf){
            $info = str_get_html($inf);
            $data[$info -> find('span.ClassCorpoTextoNormal13pt text',0)->_[4]] = $info -> find('span.ClassMarromEscuro14 text',0)->_[4];
//            $data["Sitacao"] = $info->find('text',1)->_[4];
//            $data["Telefone"] = $info->find('text',2)->_[4];

//            foreach ($info->find('span.ClassMarromEscuro14 text') as $inf) {
//                $p = str_get_html($inf);
//                $data["Nome"] = $p->plaintext;
//                $data["Situacao"] = $p->plaintext;
//                $data["Telefone"] = $p->plaintext;
//                echo $inf->_[4] . "\n";
//            }

        }
    }
}

