<html>
 <head>
  <meta  charset=utf-8 /> 
  <title> Raspagem do site divulgando desaparecidos SEM foto  </title>
 </head>
 <body>
	<?php
        
            
            include("../simple_html_dom/simple_html_dom.php");
            include("atualizacaoPrincipal.php");
        


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




            $urlBase = "http://www.divulgandodesaparecidos.org/desaparecidos_sem_foto/";
            
            $html = file_get_html($urlBase);
            
            //$aux = 0;
            $cont =0;
            foreach($html->find('li a') as $a){
                //echo $a->href."<br>";
                $cont++;
                $html2 = file_get_html("http://www.divulgandodesaparecidos.org".$a->href);
                
                $dados = $html2->find('p[class="style12"]');
                
                $resposta = str_replace("<br />", "|", $dados[0]);
                $resposta = str_replace("<br>", "|", $resposta);
                
                //echo "RESPOSTA<br>".$resposta."<br>FIM DA RESPOSTA<br>";
                $datahtml = str_get_html($resposta);
                //echo $dados->plaintext."<br><br><br>";
                $dados = explode("|", $datahtml->plaintext);
                
                $p = new Pessoa();
                
                $p->nome = html_entity_decode(certifica("NOME DO DESAPARECIDO:", $dados));
                $p->apelido = certifica("APELIDO:", $dados);
                $p->sexo = certifica("SEXO:", $dados);
                $p->mais_caracteristicas = certifica("SINAIS PARTICULARES:", $dados);
                $p->altura = certifica("ALTURA:", $dados);
                $p->peso = certifica("PESO:", $dados);
                $p->cor_olho = certifica("COR DOS OLHOS:", $dados);
                $p->cor_cabelo = certifica("COR DOS CABELOS:", $dados);
                $p->pele = certifica("COR DA PELE:", $dados);
                $p->estado = html_entity_decode(certifica("ESTADO:", $dados));
                $p->cidade = html_entity_decode(certifica("MUNICÍPIO:", $dados));
                if ( $p->cidade == null){
                    $p->cidade = certifica("CIDADE:", $dados);
                }
                if ( $p->cidade == null){
                    $p->cidade = certifica("MUNIC&Iacute;PIO:", $dados);
                }
                $p->data_desaparecimento = certifica("DATA DO DESAPARECIMENTO:", $dados);
                $p->datanasc = certifica("DATA DO NASCIMENTO:", $dados);
                $p->situacao = "Desaparecida";
                $p->fonte = "http://www.divulgandodesaparecidos.org".$a->href;
                
                $p->circunstancia_desaparecimento = certifica("CIRCUSTÂNCIAS DO DESAPARECIMENTO:", $dados);//CIRCUNSTÂNCIAS DO DESAPARECIMENTO:
                if ( $p->circunstancia_desaparecimento == null){ //CIRCUNSTÂNCIAS DO DESAPARECIMENTO:
                    $p->circunstancia_desaparecimento = certifica("CIRCUNSTÂNCIAS DO DESAPARECIMENTO:",$dados);
                }
                if ( $p->circunstancia_desaparecimento == null){
                    $p->circunstancia_desaparecimento = certifica("CIRCUNST&Acirc;NCIAS DO DESAPARECIMENTO:",$dados);
                }
                $p->local_desaparecimento = certifica("LOCAL DO DESAPARECIMENTO:", $dados);
                //echoes($p);
                echo "------------<br>";
                echo $p->nome."<br>";
                atualizacao_Principal($p);    
            }
            echo "cont cadastrados : ". $cont;
        
        ?>
 </body>
</html>
