<html>
    <head>
        <meta  charset=utf-8 /> 
        <title> Raspagem do site divulgando desaparecidos nova </title>
    </head>
    <body>
        <?php
        // Raspagem http://www.divulgandodesaparecidos.org/desaparecidos_com_foto/

        include("../simple_html_dom/simple_html_dom.php");
        include("atualizacaoPrincipal.php");

        function certifica($valor_de_procura, $vet) {
            $tam = count($vet);
            $size = strlen($valor_de_procura);
            for ($i = 0; $i < $tam; $i++) {
                if (similar_text($vet[$i], $valor_de_procura) == $size) {
                    //echo "indice: ".$i."<br>";
                    $dado = explode(":", $vet[$i]);
                    //echo $dado[1];
                    return ucwords(strtolower($dado[1]));
                }
            }
            return null;
        }

        function achaEatualiza($vet, $img, $fonte) {
            $p = new Pessoa();

            $p->nome = html_entity_decode(certifica("NOME DO DESAPARECIDO", $vet));
            $p->apelido = certifica("APELIDO", $vet);
            $p->datanasc = certifica("DATA DO NASCIMENTO", $vet);
            $p->sexo = certifica("SEXO", $vet);
            $p->imagem = $img;
            //$p->idade = certifica("IDADE",$vet);
            $p->cidade = html_entity_decode(certifica("CIDADE", $vet));
            if ($p->cidade == null) {
                $p->cidade = certifica("MUNICÍPIO", $vet);
            }
            $p->estado = html_entity_decode(certifica("ESTADO", $vet));
            $p->altura = certifica("ALTURA", $vet);
            $p->peso = certifica("PESO", $vet);
            $p->pele = certifica("COR DA PELE", $vet);
            $p->cor_cabelo = certifica("COR DOS CABELOS", $vet);
            if ($p->cor_cabelo == null) {
                $p->cor_cabelo = certifica("COR DO CABELO", $vet);
            }
            $p->cor_olho = certifica("COR DOS OLHOS", $vet);
            $p->mais_caracteristicas = certifica("SINAIS PARTICULARES", $vet);
            $p->data_desaparecimento = certifica("DATA DO DESAPARECIMENTO", $vet);
            $p->local_desaparecimento = certifica("LOCAL DO DESAPARECIMENTO", $vet);
            $p->circunstancia_desaparecimento = html_entity_decode(certifica("CIRCUNSTÂNCIAS DO DESAPARECIMENTO", $vet));
            $p->dados_adicionais = certifica("TIPO DE DESAPARECIMENTO", $vet);
            $p->situacao = "Desaparecida";
            $p->fonte = $fonte;

            echo "------------------------<br>";
            echo $p->nome . "<br>";
            atualizacao_Principal($p);
            //echoes($p);
        }

        $urlBase = "http://www.divulgandodesaparecidos.org/desaparecidos_com_foto/";

        $html = file_get_html($urlBase);

        $cont = 0;
        $cont1 = 0;
        $url = "http://www.divulgandodesaparecidos.org";

        $objinteresse = $html->find('ul[id="ul-fotos-desaparecidos"]');
        foreach ($objinteresse[0]->find('li') as $li) {
            $cont1++;
            $tagimg = $li->find('img');
            //$img = $urlBase.str_replace("/desaparecidos_com_foto/","",$tagimg[0]->src); // guardo a imagem de cada desaparecido
            $str = $tagimg[0]->src;
            if ($str{0} == "/") {
                $img = $url . $tagimg[0]->src;
            } else {
                $img = $url . "/desaparecidos_com_foto/" . $tagimg[0]->src;
            }
            $a = $li->find('a');

                    $Newurl = str_replace("�", "ç",$url.$a[0]->href);
                                        
                $newhtml = file_get_html($Newurl);
            //echo $Newurl.$a->href."<br>";
            
                $teste = $newhtml->find('span');
            $p = new Pessoa();

            if (count($teste) > 45) {
                $i = 0;
                $dadosDesaparecido = array();
                // Primeiro foreach para pegar o tipo do item
                foreach ($newhtml->find('span[class="nome_informacao"]') as $dados) {
                    $dadosDesaparecido[$i] = $dados->plaintext;
                    $i++;
                }
                // Concateno o tipo do item cmo o proprio item para poder executar a busca depois
                $i = 0;
                foreach ($newhtml->find('span[class="informacao"]') as $dados) {
                    $dadosDesaparecido[$i] = $dadosDesaparecido[$i] . ":" . $dados->plaintext;
                    //echo $dadosDesaparecido[$i]."<br>";
                    $i++;
                }
                //echo "------------------------<br>";

                achaEatualiza($dadosDesaparecido, $img, $Newurl);
                //$p->nome = certifica("NOME DO DESAPARECIDO",$dadosDesaparecido);
                //$x = $p->nome;
                //echo "<br>NOME caso geral: ".$p->nome;
                $cont++;
            } else {
                // caso Orlando Klettemberg
                $teste = $newhtml->find('span[class="style12"]');
                if (strlen($teste[0]) > 0) {
                    $data = str_replace("<br />", "|", $teste[0]->innertext);
                    $dadosDesaparecido = explode("|", $data);
                    //$p->nome = certifica("NOME DO DESAPARECIDO",$dadosDesaparecido);
                    //echo "<br>Nome caso2 casospanclass12 : ".$p->nome;
                    achaEatualiza($dadosDesaparecido, $img, $Newurl);
                    $cont++;
                    //break;
                } else {
                    // caso Erica Ribeiro Maroquio Ramos e semelhantes
                    $teste = $newhtml->find('span[class="style2"]');
                    if (strlen($teste[0]) > 0) {
                        $data = str_replace("<br />", "|", $teste[0]->innertext);
                        $datahtml = str_get_html($data);
                        $data = $datahtml->plaintext;
                        $dadosDesaparecido = explode("|", $data);
                        //$p->nome = certifica("NOME DO DESAPARECIDO",$dadosDesaparecido);
                        //echo "<br>Nome caso3 casospanclass2 : ". $p->nome;
                        achaEatualiza($dadosDesaparecido, $img, $Newurl);
                        $cont++;
                    } else {
                        // caso Carolina Coelho do Nascimento && Rodrigo Vigil Vieira
                        // o primeiro a aparecer assim é Rogério Antônio Felisberto
                        $teste = str_replace('<div align="justify" class="style12"></div>', "", $newhtml);
                        $teste = str_replace('<div align="justify"></div>', "", $teste);
                        $teste = str_get_html($teste);
                        $teste = $teste->find('div[align="justify"]');
                        if (strlen($teste[0]) > 0) {
                            $data = str_replace("<br />", "|", $teste[0]->innertext);
                            $datahtml = str_get_html($data);
                            $data = $datahtml->plaintext;
                            $dadosDesaparecido = explode("|", $data);
                            //$p->nome = certifica("NOME DO DESAPARECIDO",$dadosDesaparecido);
                            //echo "<br>Nome caso4 casodiv : ". $p->nome;
                            //break;
                            achaEatualiza($dadosDesaparecido, $img, $Newurl);
                            $cont++;
                        } else {
                            // caso small e big Luis Mario Gonçalves
                            $teste = $newhtml->find('small');
                            if (strlen($teste[0]) > 0) {
                                $i = 0;
                                $dadosDesaparecido = array();
                                // Primeiro foreach para pegar o tipo do item
                                foreach ($newhtml->find('small') as $dados) {
                                    $dadosDesaparecido[$i] = $dados->plaintext;
                                    $i++;
                                }
                                // Concateno o tipo do item cmo o proprio item para poder executar a busca depois
                                $i = 0;
                                foreach ($newhtml->find('big') as $dados) {
                                    $dadosDesaparecido[$i] = $dadosDesaparecido[$i] . ":" . $dados->plaintext;
                                    //echo $dadosDesaparecido[$i]."<br>";
                                    $i++;
                                }
                                $cont++;
                                //$p->nome = certifica("NOME DO DESAPARECIDO",$dadosDesaparecido);
                                //echo "<br>NOME caso smallbig: ".$p->nome;
                                achaEatualiza($dadosDesaparecido, $img, $Newurl);
                            } else {

                                // caso Marcones Cordeiro de Souza 
                                // tenho que substituir o <br /> e se tiver <br>
                                // 1 caso especial
                                $filtro = str_replace('<p class="centro"><a href="/desaparecidos_com_foto/"><img src="/bt_voltar.gif" width="58" height="20" border="0" /></a></p>', '', $newhtml);
                                $filtro = str_replace('<p class="centro"><img src="/desaparecidos_com_foto/maura-kihara-333x344.jpg" width="225" height="232" /></p>', '', $filtro);
                                $newhtml2 = str_get_html($filtro);
                                // ----
                                $teste = $newhtml2->find('p');
                                if (strlen($teste[0]) > 0) {
                                    //$count = $teste->find('br');
                                    $data = str_replace("<br />", "|", $teste[0]->innertext);
                                    $data = str_replace("<br>", "|", $data);
                                    $datahtml = str_get_html($data);
                                    $data = $datahtml->plaintext;
                                    $dadosDesaparecido = explode("|", $data);
                                    //$p->nome = certifica("NOME DO DESAPARECIDO",$dadosDesaparecido);
                                    //echo "<br>Nome caso5 de br e br/ : ". $p->nome;
                                    achaEatualiza($dadosDesaparecido, $img, $Newurl);
                                    $cont++;
                                } else {
                                    // caso Antonio Manoel dos Santos
                                    $teste = $newhtml->find('div[align="left"]');
                                    if (strlen($teste[0]) > 0) {
                                        $data = str_replace("<>", "", $teste[0]->innertext);
                                        $data = str_replace("<br />", "|", $data);

                                        $datahtml = str_get_html($data);
                                        $data = $datahtml->plaintext;
                                        $dadosDesaparecido = explode("|", $data);
                                        achaEatualiza($dadosDesaparecido, $img, $Newurl);
                                        //$p->nome = certifica("NOME DO DESAPARECIDO",$dadosDesaparecido);
                                        //echo "<br>Nome caso6 divleft : ". $p->nome;
                                        $cont++;
                                    } else {
                                        // caso sueila maria das graças
                                        $teste = $newhtml->find('td[bgcolor="#DBDBDB"]');
                                        if (strlen($teste[0]) > 0) {
                                            $data = str_replace("<br />", "|", $teste[0]->innertext);

                                            $datahtml = str_get_html($data);
                                            $data = $datahtml->plaintext;
                                            $dadosDesaparecido = explode("|", $data);
                                            achaEatualiza($dadosDesaparecido, $img, $Newurl);
                                            //$p->nome = certifica("NOME DO DESAPARECIDO",$dadosDesaparecido);
                                            //echo "<br>Nome caso7 tdbgcolor : ". $p->nome;
                                            $cont++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        //echo "<br>Num visitados : ".$cont1;
        //echo "<br>Num aprovados : ".$cont;
        //echo "<br> Ultimo visitado: ".$x;
        ?>
    </body>
</html>
