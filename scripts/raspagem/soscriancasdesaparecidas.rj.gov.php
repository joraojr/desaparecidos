<?php

include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");

function getPage($id,$type) {
    date_default_timezone_set('America/Sao_Paulo');
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
    $headers = array(
        'Accept' => 'application/json, text/javascript, */*; q=0.01',
        'Accept-Encoding' =>'gzip, deflate',
        'Accept-Language' => 'pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
        'Connection' => 'keep-alive',
        'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
        'Host' => 'www.soscriancasdesaparecidas.rj.gov.br',
        'Origin' => 'http://www.soscriancasdesaparecidas.rj.gov.br',
        'Referer' => 'http://www.soscriancasdesaparecidas.rj.gov.br/consulta_publica/consulta_publica.php',
        'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36',
        'X-Requested-With' => 'XMLHttpRequest'
    );
    if($type == 1) {
        $postData = array(
            'nome' => "",
            'idadeInicial' => "",
            'idadeFinal' => "",
            'sexo' => "",
            'pele' => "",
            'corOlhos' => "",
            'tipoCabelo' => "",
            'corCabelo' => "",
            'paginaAtual' => "$id",
            'situacao' => "1",//desaparecido
            'ordem' => "1"
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.soscriancasdesaparecidas.rj.gov.br/consulta_publica/corpo_consulta_publica.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookieDesaparecidos.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookieDesaparecidos.txt');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    }else{
        $idnum = "?idnum=$id";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://www.soscriancasdesaparecidas.rj.gov.br/consulta_publica/dados_consultapublica.php' . $idnum);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookieDesaparecidos.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookieDesaparecidos.txt');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    }

    $page = curl_exec($ch);
    

    curl_close($ch);

    return $page;
}

$total = json_decode(getPage(1,1))->total;

for ($i=1; $i <=ceil($total/12); $i++){
    $json = json_decode(getPage($i,1))->dados;
    foreach ($json as $people){
        $html = str_get_html(getPage($people->IDNUM,2));
        $data = $html->find('div.col-lg-6',0)->plaintext;
        $data = array_filter(explode("  			",$data));
        $p = new Pessoa();
        $p->fonte = "http://www.soscriancasdesaparecidas.rj.gov.br/consulta_publica/dados_consultapublica.php?idnum=$people->IDNUM";
        $p->imagem = "http://www.soscriancasdesaparecidas.rj.gov.br/". $html->find('p[align=center] img[oncontextmenu=return false]',0)->src;
        $p->nome =str_replace('	      	        &nbsp;              ',"",$data[0]);
        $p->dados_adicionais = str_replace('</br>',"",$data[1]." ".$data[2]." ".$data[3]);
        $p->datanasc = str_replace('</br>',"",str_replace('Data de Nascimento: ',"",$data[4]));
        $p->data_desaparecimento = str_replace('</br>',"",str_replace('Data de Desaparecimento: ',"",$data[5]));
        $p->pele = str_replace('</br>',"",str_replace('Cor da Pele:',"",$data[9]));
        $p->cor_cabelo = str_replace('</br>',"",str_replace('Cor do Cabelo:',"",$data[11]));
        $p->cor_olho = str_replace('</br>',"",str_replace('Cor dos Olhos:',"",$data[12]));
        $p->mais_caracteristicas = str_replace('</br>',"",$data[14]);
        $p->estado = "rj";
        $p->situacao = "Desaparecida";
        atualizacao_Principal($p);
    }
}

