<html>
 <head>
  <meta  charset=utf-8 /> 
  <title> pm.sc.gov Raspagem </title>
 </head>
 <body>
    <?php
        // raspagem do site http://www.pm.sc.gov.br/desaparecidos/
        
        include("../simple_html_dom/simple_html_dom.php");
        include("atualizacaoPrincipal.php");
        
        $cont = 0;
        
        
        function Tira2pts($texto){
            $aux = explode(":", $texto);
            return $aux[1];
        }
        
        $urlBase = "http://www.pm.sc.gov.br/desaparecidos/consulta-desaparecidos.php?&p_init="; 
        // guardo a url da página
        for( $i=0; $i<=180; $i=$i+10){ // $i=0; $i<=90; $i=$i+10
            $html = file_get_html($urlBase.$i); // para cada página de desaparecidos guardo seu html
            foreach($html->find('div[class="item"]') as $value){
                $cont++;
                //pegar imagem
                $aux = $value->find('img[width="75px"]');
                $img = "http://www.pm.sc.gov.br".$aux[0]->src;
                //echo $img;
                
                $k = 0;
                $pessoa = array();
                foreach($value->find('div[class="item-info-detail"]') as $valor){
                    $pessoa[$k] = $valor->plaintext;
                    $k = $k+1;
                }
                $p = new Pessoa();
                
                
                $p->fonte = "http://www.pm.sc.gov.br/desaparecidos/consulta-desaparecidos.php?&p_init=$i";
                
                
                //$nome = explode(":", $pessoa[0]);
                //$p->nome = $nome[1];
                $p->nome = html_entity_decode(Tira2pts($pessoa[0]));
                
                
                
                //echo $nome[1];
                //$datanasc = explode(":", $pessoa[1]);
                $p->datanasc = Tira2pts($pessoa[1]);
                
                
                
                //$estado = explode(":", $pessoa[2]);
                $p->estado = html_entity_decode(Tira2pts($pessoa[2]));
                
                
                
                //$cidade = explode(":", $pessoa[3]);
                $p->cidade = html_entity_decode(Tira2pts($pessoa[3]));
                
                
                $p->data_desaparecimento = Tira2pts($pessoa[4]);
                
                
                
                $p->circunstancia_desaparecimento = html_entity_decode(Tira2pts($pessoa[5]));
                
                
                
                $p->imagem = $img;
                
                
                $p->situacao = "Desaparecida";
                
                
                
                
                /*
                echo $p->datanasc."<br>";
                echo $p->estado."<br>";
                echo $p->cidade."<br>";
                echo $p->data_desaparecimento."<br>";
                */
                if ( !isset($p->circunstancia_desaparecimento) ){
                    //echo $p->circunstancia_desaparecimento."<br>";
                    $p->circunstancia_desaparecimento = null;
                }
                /*
                echo $p->situacao."<br>";
                echo $p->fonte."<br>";
                
                echo "<br>";                
                */
               echoes($p);
               atualizacao_Principal($p);
               //break;
            }
            //break;
        }
        echo "N total: ". $cont;
    ?>
 </body>
</html>
