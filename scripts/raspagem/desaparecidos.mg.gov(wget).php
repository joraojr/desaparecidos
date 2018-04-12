<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include("../simple_html_dom/simple_html_dom.php");
include("atualizacaoPrincipal.php");

function Tira2pts($texto) {
    $aux = explode(":", $texto);
    return $aux[1];
}

function certifica($valor_de_procura, $vet) {
    $tam = count($vet);
    $size = strlen($valor_de_procura);
    for ($i = 0; $i < $tam; $i++) {
        if (similar_text($vet[$i], $valor_de_procura) == $size) {
            //echo "indice: ".$i."<br>";
            $dado = explode(":", $vet[$i]);
            //echo $dado[1];
            return $dado[1];
        }
    }
    return null;
    
}

function searchAndGet($pagina, $fonte) {

    $dom = str_get_html($pagina);

    $personalhtml = file_get_html($pagina);

    $p = new Pessoa();
    $p->fonte = "http://www.desaparecidos.mg.gov.br/$fonte";
    // nome
    $nome = $personalhtml->find('td[valign="middle"]');
    $p->nome = html_entity_decode(ucwords(strtolower($nome[0]->plaintext)));
    $p->nome = str_replace("Ã", "ã", $p->nome);
    $p->nome = str_replace("Ç", "ç", $p->nome);
    $p->nome = trim($p->nome);

    $tds = $personalhtml->find('td[valign="top"]');
    $age = $tds[0]->plaintext;
    $keys = array(" ", "Tem", "hoje", "aproximadamente", "ano(s)", "&nbsp;");
    $p->idade = html_entity_decode(trim(str_replace($keys, "", $age)));
    //echo $p->idade." ".strlen($p->idade)."<br>";
    //if (strlen($p->idade) > 5){
    //    $p->idade = null;
    //}
    $aux = $tds[2]->outertext;
    $c = str_replace("<br>", "|", $aux);
    $array = array('<td valign="top" align="left" class="txtdetalhe">', '</td>');
    $d = str_replace($array, "", $c);

    $dados = explode("|", $d);


    // todos os divulgados estão desaparecidos
    $p->situacao = "Desaparecida";

    $p->datanasc = html_entity_decode(trim(certifica("Data Nascimento", $dados)));
    $p->sexo = html_entity_decode(trim(certifica("Sexo", $dados)));

    $auxCity = certifica("Muni", $dados);
    if ($auxCity != null) {
        if (strpos($auxCity, '/') != false) {
            $cityes = explode("/", $auxCity);
            $p->cidade = ucwords(strtolower($cityes[0]));
            $p->cidade = str_replace("Ã", "ã", $p->cidade);
            $p->cidade = trim(str_replace("Ç", "ç", $p->cidade));
            $p->estado = strtoupper($cityes[1]);
        } else {
            $p->cidade = trim($auxCity);
        }
    }
    $p->data_desaparecimento = trim(certifica("Data Desaparecimento", $dados));
    $p->pele = html_entity_decode(trim(certifica("Cútis", $dados)));
    $p->altura = trim(certifica("Estatura", $dados));
    $p->cor_olho = trim(certifica("Olhos", $dados));
    $p->cor_cabelo = trim(certifica("Cabelo", $dados));
    $p->peso = trim(certifica("Compleição Física", $dados));
    $p->mais_caracteristicas = trim(certifica("Complemento Caracte", $dados));
    $p->dados_adicionais = trim(certifica("Vestimenta", $dados));

    $error = array('"', '/', '\'', "'");
    $p->nome = str_replace($error, "", $p->nome);
    $p->pele = str_replace($error, "", $p->pele);
    $p->altura = str_replace($error, "", $p->altura);
    $p->cor_olho = str_replace($error, "", $p->cor_olho);
    $p->cor_cabelo = str_replace($error, "", $p->cor_cabelo);
    ;
    $p->peso = str_replace($error, "", $p->peso);
    $p->mais_caracteristicas = str_replace($error, "", $p->mais_caracteristicas);
    $p->dados_adicionais = str_replace($error, "", $p->dados_adicionais);




    $img = $personalhtml->find('img[width="100"]');

    if (similar_text($img[0]->src, "SemFoto") != strlen("SemFoto")) {
        $p->imagem = "http://www.desaparecidos.mg.gov.br/" . str_replace("./", "", $img[0]->src);
    }

    //echoes($p);
    //break;
    //echo "-------------<br>";
    /*
      if (similar_text($p->nome, "Joao Batista Gontijo") == strlen("Joao Batista Gontijo")){
      echo "casou<br>";
      //echoes($p);
      atualizacao_Principal($p);
      } */
    echo "----------------------<br>";
//    print_r($p);
    atualizacao_Principal($p);
    //break;
}

$i = 1;
$url = "http://www.desaparecidos.mg.gov.br/album.asp?";
$temp_dir = __DIR__ . "/tmp";

//linux
if (is_dir($temp_dir)) {
    exec("rm -r $temp_dir");
} else {
    mkdir($temp_dir);
}

exec("wget -P $temp_dir -r -l 0 $url");

$files = scandir($temp_dir . "/www.desaparecidos.mg.gov.br/");

foreach ($files as $file) {
    if (count(explode("album_detalhe.", $file)) == 2) {
        searchAndGet($temp_dir . "/www.desaparecidos.mg.gov.br/" . $file, $file);
    }
}

exec("rm -r $temp_dir");



