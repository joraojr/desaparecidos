<html>
 <head>
  <meta  charset=utf-8 /> 
  <title> Raspagem do site policia civil go </title>
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
                        return ucwords(strtolower($dado[1]));
                    }
                }
                return null;
            }

            
            
            $urlBase = "http://www.policiacivil.go.gov.br/pessoas-desaparecidas/page/";
            $cont =0;
            
            for($i=1;$i<3;$i++){ //$i=1;$i<3;$i++
                
                //armazeno o html da pagina
                $html = file_get_html($urlBase.$i);
                
                // dentro do archiveposts tem o link pra pagina de cada pessoa separado
                $div = $html->find('div[id="archive-posts"]');
                
                //guardo o html q está dentro do archivepost q contem o link pr cada pagina 
                $html2 = str_get_html($div[0]);
                
                //echo $html2;
                
                //as tags a q tem bookmark contem o link
                foreach($html2->find('a[rel="bookmark"]') as $a){
                    //$i=0;
                    
                    // guarda a pagina de cada desaparecido
                    $html3 = file_get_html($a->href);
                    
                    //incremento contador de desaparecidos
                    $cont++;
                    
                    // pega a foto do desaparecido
                    //$img = $html3->find('img[width="160"]');
                    //echo "img: ".$img[0]->src."<br>";
                    $img = $html3->find('a img');
                    
                    
                    
                    
                    //crio a pessoa e seto a imagem
                    $p = new Pessoa();
                    $p->imagem = trim($img[8]->src);
                    
                    
                    $p->fonte = $a->href;
                    
                    
                    $auxNome = $html3->find('h3[class="widget-title"]');
                    $p->nome = html_entity_decode(trim($auxNome[0]->plaintext));
                    
                    
                    $k=0;
                    $dados = Array();
                    
                    //as h3 contem os dados da pessoa
                    foreach($html3->find('h3[class="titulo-pessoas-desaparecidas"]') as $h3){
                        //echo " ".$h3->plaintext."    "."tam:".  strlen($h3->plaintext)."<br>";
                        $dados[$k] = $h3->plaintext;
                        $k++;
                        //  $i++;
                    }
                    //echo "-------------"."<br>";
                    

                    // CASO PARTICULAR 1 ( PARTE DE BAIXO DO SITE)
                    if(strlen($dados[0]) < 7 ){
                        //echo "Esse ta vazio"."<br>";
                        
                        
                        $div2 = $html3->find('div[style="margin-left:5px; line-height:20px;#border-bottom: 1px dotted #b3b3b3; width:585px;  margin-bottom:7px; color:#333;"]');
                                    
                        $html4 = str_get_html($div2[0]);
                        //echo $html4;
            
                        
                        //echo "nome: ".$aux[0]->plaintext."<br></br>";
                        //echo $html4;
            
                        $pe = $html4->find('p');
            
                        $aux = $pe[1]->innertext;
                        $aus = str_replace("<strong>", "", $aux);
                        $aus = str_replace("</strong>", "", $aus);
            
                        //echo $aus;
            
                        $vet = explode("<br />", $aus);
                        /*
                        $p->nome = trim(certifica("Nome:",$vet));
                        if( strlen($p->nome) < 1 ){
                            $p->nome = trim(certifica("Pessoa desaparecida:",$vet));
                        }
                        if( strlen($p->nome) < 1 ){
                            $p->nome = trim(certifica("Pessoa Desaparecida:",$vet));
                        }
                        */
                        
                        $p->sexo = html_entity_decode(certifica("Sexo:",$vet));
                        
                        $p->datanasc = trim(certifica("Data de nascimento:",$vet));
                        if( strlen($p->datanasc) < 1){
                            $p->datanasc = trim(certifica("Data nascimento:",$vet));
                        }
                        
                        $p->data_desaparecimento = trim(certifica("Data do desaparecimento:",$vet));
                        if( strlen($p->data_desaparecimento) < 1){
                            $p->data_desaparecimento = trim(certifica("Data desaparecimento:",$vet));    
                        }
                        if( strlen($p->data_desaparecimento) < 1){
                            $p->data_desaparecimento = trim(certifica("Desaparecido:",$vet));    
                        }
                        
                        $naturalidade = certifica("Natural:",$vet);
                        $cidadeestado = explode("/", $naturalidade);
                        $p->cidade = html_entity_decode($cidadeestado[0]);
                        $p->estado = html_entity_decode(strtoupper($cidadeestado[1]));
                        $p->idade = certifica("Idade:",$vet);
                        /*
                        for($i=0;$i<15;$i++){
                            echo $i." ".$vet[$i]."<br>";
                        }
            
                        $p->nome = Tira2pts($vet[0]);
                        $p->sexo = Tira2pts($vet[1]);
                        $p->datanasc = Tira2pts($vet[2]);
                        $p->data_desaparecimento = Tira2pts($vet[3]);
            
                        $cidadeestado = Tira2pts($vet[5]);
                        $naturality = explode("/", $cidadeestado);
                        $p->cidade = $naturality[0];
                        $p->estado = $naturality[1];
            
                        */
                        //echoes($p);
                        
                        
                        
                        
                    } else {
                        // CASO PARTICULAR 2 ( PARTE DE CIMA DO SITE )
                        //$p->nome = certifica("Nome:",$dados);
                        $p->sexo = certifica("Sexo:",$dados);
                        $p->datanasc = certifica("Data de nascimento:",$dados);
                        $p->data_desaparecimento = certifica("Data do desaparecimento:",$dados);
                                                 //Naturalidade:
                        $naturalidade = certifica("Naturalidade:",$dados);
                        $cidadeestado = explode("/", $naturalidade);
                        $p->cidade = html_entity_decode($cidadeestado[0]);
                        $p->estado = html_entity_decode(strtoupper($cidadeestado[1]));
                        
                        /*
                        $p->nome = Tira2pts($dados[0]); // nome
                        $p->sexo = Tira2pts($dados[1]); // sexo
                        $p->datanasc = Tira2pts($dados[2]); // data de nascimento
                        $p->data_desaparecimento = Tira2pts($dados[3]); // data desaparecimento
                        
                        
                        $cityestado = Tira2pts($dados[5]); // cidade/estado
                        $naturalidade = explode("/", $cityestado ); // divide a cidade do estado
                        $p->cidade = $naturalidade[0];
                        $p->estado = $naturalidade[1];
                        */
                        //echoes($p);
                        
                    }
                    
                    $p->situacao = "Desaparecida";
                    echo $p->nome."<br>";
                    atualizacao_Principal($p);
                    echo "------------------------<br>";
                    //echoes($p);
                    //break;
                }
                //break;
            }
            
            echo "--------------<br>";
            echo "qtd Desaparecidos :".$cont;
                
                
            
        ?>
 </body>
</html>
