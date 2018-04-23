<html>
 <head>
  <meta charset="UTF-8"/> 
  <title> Raspagem do site www.desaparecidos.mg.gov </title>
 </head>
 <body>
	<?php
            
            include("../simple_html_dom/simple_html_dom.php");
            include("atualizacaoPrincipal.php");
        
            

            function Tira2pts($texto){
                $aux = explode(":", $texto);
                return $aux[1];
            }

                                                            
            function certifica($valor_de_procura, $vet){
                $tam = count($vet);
                $size = strlen($valor_de_procura);
                for($i=0;$i<$tam;$i++){
                    if(similar_text($vet[$i],$valor_de_procura ) == $size ){
                        //echo "indice: ".$i."<br>";
                        $dado = explode(":", $vet[$i]);
                        //echo $dado[1];
                        return $dado[1];
                    }
                }
                return null;
            }

            // pega o html em string, usa o dom pra pegar a pagina de cada um dos desaparecidos e pegar os dados
            function searchAndGet($pagina,$idPagina){
                
                $dom = str_get_html($pagina);
                
                foreach( $dom->find('a[class="txtalbum1"]') as $a){
                    $personalhtml = file_get_html('http://www.desaparecidos.mg.gov.br/'.$a->href);
                    
                    $p = new Pessoa();
                    $p->fonte = 'http://www.desaparecidos.mg.gov.br/'.$a->href;
                    // nome
                    $nome = $personalhtml->find('td[valign="middle"]');
                    $p->nome =  ucwords(strtolower($nome[0]->plaintext));
                    $p->nome = str_replace("Ã","ã",$p->nome);
                    $p->nome = str_replace("Ç","ç",$p->nome);
                    $p->nome = trim($p->nome);
                    
                    $tds = $personalhtml->find('td[valign="top"]');
                    $age = $tds[0]->plaintext;
                    $keys = array(" ","Tem","hoje","aproximadamente","ano(s)","&nbsp;");
                    $p->idade = trim(str_replace($keys, "", $age));
                    //echo $p->idade." ".strlen($p->idade)."<br>";
                    //if (strlen($p->idade) > 5){
                    //    $p->idade = null;
                    //}
                    $aux = $tds[2]->outertext;
                    $c = str_replace("<br>", "|", $aux);
                    $array = array('<td valign="top" align="left" class="txtdetalhe">','</td>');
                    $d = str_replace($array,"",$c);
                    
                    $dados = explode("|", $d);
                    
                    
                    // todos os divulgados estão desaparecidos
                    $p->situacao = "Desaparecida";
                    
                    $p->datanasc = trim(certifica("Data Nascimento",$dados));
                    $p->sexo = trim(certifica("Sexo",$dados));
                    
                    $auxCity = certifica("Muni",$dados);
                    if( $auxCity != null ){
                        if (strpos($auxCity,'/') != false) {
                            $cityes = explode("/", $auxCity);
                            $p->cidade = ucwords(strtolower($cityes[0]));
                            $p->cidade = str_replace("Ã","ã",$p->cidade);
                            $p->cidade = trim(str_replace("Ç","ç",$p->cidade));
                            $p->estado = strtoupper($cityes[1]);    
                        } 
                        else {
                            $p->cidade = trim($auxCity);
                        }
                    }
                    $p->data_desaparecimento = trim(certifica("Data Desaparecimento",$dados));
                    $p->pele = trim(certifica("Cútis",$dados));
                    $p->altura = trim(certifica("Estatura",$dados));
                    $p->cor_olho = trim(certifica("Olhos",$dados));
                    $p->cor_cabelo = trim(certifica("Cabelo",$dados));
                    $p->peso = trim(certifica("Compleição Física",$dados));
                    $p->mais_caracteristicas = trim(certifica("Complemento Caracte",$dados));
                    $p->dados_adicionais = trim(certifica("Vestimenta",$dados));
                    
                    $error = array('"','/','\'',"'");
                    $p->nome = str_replace($error, "", $p->nome);
                    $p->pele = str_replace($error, "", $p->pele);
                    $p->altura = str_replace($error, "", $p->altura);
                    $p->cor_olho = str_replace($error, "", $p->cor_olho);
                    $p->cor_cabelo = str_replace($error, "", $p->cor_cabelo);;
                    $p->peso = str_replace($error, "", $p->peso);
                    $p->mais_caracteristicas = str_replace($error, "", $p->mais_caracteristicas);
                    $p->dados_adicionais = str_replace($error, "", $p->dados_adicionais);
                    
                    
                    
                    
                    $img = $personalhtml->find('img[width="100"]');
                    
                    if ( similar_text($img[0]->src,"SemFoto") != strlen("SemFoto") ){
                        $p->imagem = "http://www.desaparecidos.mg.gov.br/".str_replace("./", "", $img[0]->src);    
                    }
                     
                    //echoes($p);
                    
                    //break;
                    //echo "-------------<br>";
                    /*
                    if (similar_text($p->nome, "Joao Batista Gontijo") == strlen("Joao Batista Gontijo")){
                        echo "casou<br>";
                        //echoes($p);
                        atualizacao_Principal($p);
                    }*/
                    echo "----------------------<br>";
                    echo $p->nome."<br>";
                    atualizacao_Principal($p);
                    //break;
                    
                }
            }

            
                $headers = array(
                'Accept-Encoding: gzip, deflate',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:32.0) Gecko/20100101 Firefox/32.0',
                'Accept-Language: pt-br',
                'Cache-Control: max-age=0',
                'Connection: keep-alive',
                'Referer: http://www.desaparecidos.mg.gov.br/album.asp?pg=1'
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'http://www.desaparecidos.mg.gov.br/album.asp?' );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $cookie_file = tempnam (realpath(sys_get_temp_dir()), "CURLCOOKIE");

                curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie_file);
                curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookie_file);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                
                $page = array();
                
                $page[1] = curl_exec($ch);
                curl_close($ch);
                
                //--------------
                // após o primeiro acesso, faz uso do cookie para pegar as próximas páginas
                
                for( $i=2; $i<178;$i++){ // $i=2; $i<177; $i++
                    $ch = curl_init();
                    $newUrl = 'http://www.desaparecidos.mg.gov.br/album.asp?pg='.$i;
                    curl_setopt($ch, CURLOPT_URL, $newUrl );
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie_file);
                    curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookie_file);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $page[$i] = curl_exec($ch);
                    curl_close($ch);
                }
                for( $j=177; $j<$i; $j++){
                    echo "----- BEGIN PAGINA ".$j." -----<br>";
                    searchAndGet($page[$j],$j);
                    echo " ----- END PAGINA ".$j." -----<br>";
                }
                
            
    ?>
    </body>
</html>
