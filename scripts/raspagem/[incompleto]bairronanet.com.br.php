<?php
//Obs(1).: Acessando a pagina de detalhes com uma fun??o javascript



include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");


for($i = 1; $i <= 2; $i++){
    $page = "http://bairronanet.com.br/desaparecidos/pagina_principal_desaparecidos.php?sit=%&&sexo=%&&olhos=%&&oculos=%&&comp=%&&barba=%&&cabelo=%&&tipo=%&&pais=%&&estado=%&&cidade=%&&bairro=%&&nome=%&&pai=%&&mae=%&&pele=%&&marcas=&&img=&&np=12&&paginaatual=$i#topodapesquisa";
    $html = file_get_html($page);
    $href = "http://bairronanet.com.br/";

    foreach ($html -> find('div.style10 tr td a') as $people){
        if(html_entity_decode($people->title) == " Veja as informações completas dessa pessoa... ") {

            $onclick = $people->onclick;
            for($i = 0; $i < (strlen($onclick)); $i++){
                if($onclick[$i] == '\''){
                    $link[$i] = $onclick[$i];
                    print_r($link);
                }

            }
        }
    }

}