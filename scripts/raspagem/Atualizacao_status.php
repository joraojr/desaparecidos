
<html>
 <head>
  <meta  charset=utf-8 /> 
  <title> Atualiza Status </title>
 </head>
 <body>

<?php
    include("simple_html_dom/simple_html_dom.php");
    
    // colocar o login e senha do banco 
    $login = "admin:admin"; //login:senha

    // ATUALIZO O STATUS DA PESSOA NO BANCO PARA ENCONTRADA
    function setEncontrado($id){
        
        $format = 'application/sparql-results+json';
        
        $idA = '"'.$id.'"';
        $where = "WHERE {?s des:id ".$idA."};";
        
        $des = '"'."Desaparecida".'"';
        
        $endereco = "PREFIX foaf:<http://xmlns.com/foaf/0.1/>
                     PREFIX dbpprop:<http://dbpedia.org/property/>
                     PREFIX des:<http://www.desaparecidos.com.br/rdf/> 

                     DELETE { ?s des:status ".$des."}".$where;
        //echo $endereco;
    
        $url = urlencode($endereco);
		$sparqlURL = 'http://localhost:10035/repositories/desaparecidos3?query='.$url.'';

		// deleta o status "Desaparecida" do banco
		$curl = curl_init();
        curl_setopt($curl, CURLOPT_USERPWD, $GLOBALS['login']);	
        curl_setopt($curl, CURLOPT_URL, $sparqlURL);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); // Delete precisa ser feito por POST
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //Recebe o output da url como uma string
        curl_setopt($curl,CURLOPT_HTTPHEADER,array('Accept: '.$format ));
        $resposta = curl_exec( $curl );
		curl_close($curl);
    
        // AGORA VOU SETAR O STATUS DA PESSOA COMO ENCONTRADA
        
        $enc = '"'."Encontrada".'"';
        $endereco = "
            PREFIX foaf:<http://xmlns.com/foaf/0.1/>
            PREFIX dbpprop:<http://dbpedia.org/property/>
            PREFIX des:<http://www.desaparecidos.com.br/rdf/> 

            INSERT { ?s des:status ".$enc." }".$where;
        
        
        $url = urlencode($endereco);
        $sparqlURL = 'http://localhost:10035/repositories/desaparecidos3?query='.$url.'';
                        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_USERPWD, $GLOBALS['login']);	
        curl_setopt($curl, CURLOPT_URL, $sparqlURL);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //Recebe o output da url como uma string
        curl_setopt($curl,CURLOPT_HTTPHEADER,array('Accept: '.$format ));
        $resposta = curl_exec( $curl );
		curl_close($curl);
        //echo "Done";
    }

    
	
    // -- MONTANDO CONSULTA NO ALLEGRO --
    $format = 'application/sparql-results+json';

    $endereco = ' PREFIX des:<http://www.desaparecidos.com.br/rdf/> 
    select ?id ?fonte {?s des:id ?id.
                       ?s des:source ?fonte.
                       ?s des:status "Desaparecida"}';
    
    $url = urlencode($endereco);
    
    $sparqlURL = 'http://localhost:10035/repositories/desaparecidos3?query='.$url;
        
    $curl = curl_init();
	//curl_setopt($curl, CURLOPT_USERPWD, $GLOBALS['login']);	

    //definimos a URL a ser usada
    curl_setopt($curl, CURLOPT_URL, $sparqlURL);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); 
    // define que o conteúdo obtido deve ser retornado em vez de exibido
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //Recebe o output da url como uma string
	    	
    // define o formato
    curl_setopt($curl,CURLOPT_HTTPHEADER,array('Accept: '.$format ));
	    	
    // executo a consulta e gravo na variavel resposta a resposta em $format(json)
    $resposta = curl_exec( $curl );
                
    //fecho o curl
	curl_close($curl);
    //echo $resposta;
    
    //decodifico a resposta para reconhecer como json para q eu possa navegar nela
	$respostaNew = json_decode($resposta);
    

    



    $dados = $respostaNew->results;
    
    /* texto para casamento de padrão, identificar os desaparecidos que possuem
     * o site abaixo como fonte
     */
    $texto = "desaparecidos.mg.gov.br";
        

    $i = 0;
    // para cada id do banco que tem fonte e ainda esta desaparecido
    foreach( ($dados->bindings) as $field ){
        // guardo o id e a fonte
        $auxid = $field->id; 
        $auxsource = $field->fonte;
        //echo $auxid->value."  ";
        
	// se a fonte casar com o texto vou naquele site para olhar        
        if( similar_text($texto, $auxsource->value) == strlen($texto) ){
            $html2 = file_get_html($auxsource->value);
            $dados2 = $html2->find('td[class="txtdetalhe"]'); 


            if ( empty($dados2[0]) ){
                $i++;
		echo $auxsource->value."  ";
		echo "Cont: ".$i;
        	echo "<br>";                
		//echo " ENCONTRADO";
		setEncontrado($auxid->value);
            } else{
               // echo " CONTINUA DESAPARECIDO";
            }
        }
        //echo "------------------------------------- <br>";
	
        
    }
	//echo "Total de encontrados: ". $i;
?>

</body>
</html>

