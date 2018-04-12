<?php

error_reporting(E_ALL);
include("atualizacaoPrincipal.php");
include("../simple_html_dom/simple_html_dom.php");



$total_cadastros = 0;
//$urlBase = 'http://www.desaparecidos.gov.br';
//$domMain = file_get_html($urlBase);
//foreach ($domMain->find("#mainmeu .menu .item-127 a") as $li) {
//    $d = $li->href;
//}
//$urlDesaparecido = $urlBase . $d;
//
//
////pagina do site onde se encontram as pessoas cadastradas
//$domDesaparecidos = file_get_html($urlDesaparecido);
//foreach ($domDesaparecidos->find(".paginacao a")as $page) {
//    $pages[] = $page->href;
//}
//
//$vetor = array();
//$i = 0; //paginas q nao aparecem no site
//for($i = 10 ; $i < 21 ; $i ++){
//     $pages[] = str_replace("0", $i, $pages[0]);
//}
$count = 0;

for ($i = 1994; $i <= 3500; $i++) {
    $urlPessoa = "http://www.desaparecidos.gov.br/desaparecidos/application/modulo/detalhes.php?id=$i";
    $domPessoa = file_get_html($urlPessoa);
    $situacao = $domPessoa->find(".desaparecido");
    if ($situacao == null) {
        $situacao = $domPessoa->find(".encontrado");
    }
    $infos = $domPessoa->find('.inf');

    $inf [] = explode("\n", $infos[0]->plaintext);
    $inf = $inf[0];
    //print_r($inf);
    //////////// Dados a serem guardados no vetor e em um arquivo txt no formato RDF//////////////////////////////////////////////

    $nomev = trim(str_replace("Nome do desaparecido: ", "", html_entity_decode($inf[0])));
    if ($nomev != "") {
        $dataNascim = trim(str_replace("Data de nascimento: ", "", html_entity_decode($inf[1])));
        $dt_desaparecimentov = trim(str_replace("Data do desaparecimento: ", "", html_entity_decode($inf[2])));
        $estadov = trim(str_replace("UF: ", "", html_entity_decode($inf[3])));
        $cidadev = trim(str_replace("Município: ", "", html_entity_decode($inf[4])));
        $situacaov = trim($situacao[0]->plaintext);
        if ($situacaov == "Desaparecido(a)") {
            $situacaov = "Desaparecida";
        } else {
            if ($situacaov == "Encontrado(a)") {
                $situacaov = "Encontrada";
            }
        }


        $p = new Pessoa();
        $p->nome = ucwords(strtolower($nomev));
        $p->cidade = ucwords(strtolower($cidadev));
        $p->estado = $estadov;
        $p->data_desaparecimento = $dt_desaparecimentov;
        $p->situacao = $situacaov;
        $p->fonte = $urlPessoa;
        $p->datanasc = $dataNascim;

        $count = $count + 1;
        echo "count :" . $count . "<br>";
        //       echo $p->nome . "<br>";
        //       echoes($p);
        atualizacao_Principal($p);
//        echo "------------------------<br>";
        //break;
    }
    unset($inf);
    echo $i;
} 

echo " total de pessoas eh: " . $count;
?>
