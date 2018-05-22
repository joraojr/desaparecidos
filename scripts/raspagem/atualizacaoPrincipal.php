<?php
error_reporting(E_ALL);
//inserir login e senha do banco de dados
$login = "admin:admin"; // login:senha
$BD = "http://localhost:10035/repositories/desaparecidos3";
    class Pessoa{
            public $nome; 
            public $apelido;
            public $datanasc;
            public $sexo;
            public $imagem;
            public $idade;
            public $cidade;
            public $estado;
            public $altura;
            public $peso;
            public $pele;
            public $cor_cabelo;
            public $cor_olho;
            public $mais_caracteristicas;
            public $data_desaparecimento;
            public $local_desaparecimento;
            public $circunstancia_desaparecimento;
            public $data_localizacao;
            public $dados_adicionais;
            public $situacao;
            public $fonte;
        }
        
        function echoes(Pessoa $p){
                        echo "Imagem: |".$p->imagem."|<br>";
                        echo "Situacao: |".$p->situacao."|<br>";
                        echo "Nome: |".$p->nome."|<br>";
                        echo "Apelido: |".$p->apelido."|<br>";
                        echo "Idade: |". $p->idade."|<br>";
                        echo "dataNasc: |".$p->datanasc."|<br>";
                        echo "sexo: |".$p->sexo."|<br>";
                        echo "mais carac: |".$p->mais_caracteristicas."|<br>";
                        echo "altura: |".$p->altura."|<br>";
                        echo "peso: |".$p->peso."|<br>";
                        echo "cor_olho: |".$p->cor_olho."|<br>";
                        echo "cor_cabelo: |".$p->cor_cabelo."|<br>";
                        echo "cor_pele: |".$p->pele."|<br>";
                        echo "estado: |".$p->estado."|<br>";
                        echo "cidade: |".$p->cidade."|<br>";
                        echo "data_des: |".$p->data_desaparecimento."|<br>";
                        echo "local_des: |".$p->local_desaparecimento."|<br>";
                        echo "dados adiconais: |".$p->dados_adicionais."|<br>";
                        echo "data_localizacao: |".$p->data_localizacao."|<br>";
                        echo "circunstancia_des: |".$p->circunstancia_desaparecimento."|<br>";
                        echo "fonte: |".$p->fonte."|<br>";
                        echo "-----------------------------------------------"."<br>";
            }
        
	// returna o id do desaparecido se o mesmo existir senao retorna -1
	function existeDesaparecido($nome, $data, $cidade){
	$format = "application/sparql-results+json";
	$aux = '"';
        $nome = $aux."^".$nome."$".$aux;
        /*      $data = $aux.$data.$aux;
              $cidade = $aux.$cidade.$aux;*/
       // $idade = $aux.$idade.$aux;
        $i = $aux."i".$aux;
        /* select ?id {?id foaf:name ?name.
		  ?id des:disappearanceDate ?disappearanceDate.
		  ?id des:cityDes ?city.
	          OPTIONAL {?id foaf:birthday ""}.
                  OPTIONAL {?id foaf:age "14"}.
                  FILTER regex(?name, "Daniela de Jesus Souza Malta" , "i").
                  FILTER regex(?disappearanceDate, "25/09/2012", "i").
	          FILTER regex(?city, "Joinville" , "i").
        */
	$endereco = " PREFIX des:<http://www.desaparecidos.com.br/rdf/>
					select ?id {?id foaf:name ?name.";
    if(!empty($data) && !is_null($data) ) $endereco .= '?id des:disappearanceDate ?disappearanceDate.';
    if(!empty($cidade) && !is_null($cidade)) $endereco.= '?id des:cityDes ?city.';
    $endereco .= "FILTER regex(?name, ".$nome." , ".$i.").";
    if(!empty($data) && !is_null($data)) $endereco.="FILTER regex(?disappearanceDate, ".$aux.$data.$aux.", ".$i.")";
	if(!empty($cidade) && !is_null($cidade)) $endereco.="FILTER regex(?city, ".$aux.$cidade.$aux." , ".$i.").";
    $endereco.= '}';

    echo $endereco;

    $url = urlencode($endereco);
        	$sparqlURL = $GLOBALS['BD'].'?query='.$url.'+limit+1';

                $curl = curl_init();
                //curl_setopt($curl, CURLOPT_USERPWD, $GLOBALS['login']);
                
                //definimos a URL a ser usada
	    	curl_setopt($curl, CURLOPT_URL, $sparqlURL);
                
                curl_setopt($curl, CURLOPT_USERPWD, $GLOBALS['login']);
                
                // define que o conteúdo obtido deve ser retornado em vez de exibido
	    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //Recebe o output da url como uma string
	    	
                
                curl_setopt($curl,CURLOPT_HTTPHEADER,array("Accept: ".$format ));
	    	$resposta = curl_exec( $curl );
	    	curl_close($curl);
	        //echo $resposta;
	        $resposta =  str_replace("http://www.desaparecidos.ufjf.br/desaparecidos/","", $resposta);		
		//echo "tipo da resposta: ".gettype($resposta)."<br>";
                //echo "Resposta: ".$resposta."<br>";
	
                $aux = json_decode($resposta);
                    $t2 = $aux->results;
                    $t2 = $t2->bindings[0];
                    
                    
                
                if($t2 == null){
                    return -1;
                } else {
                    //echo $t2->value;
		    // return ID
                    $t2 = $t2->id;
                    return $t2->value;
                }
	}

        
        function getMaiorId(){
                $format = "application/sparql-results+json";
                // retorna o maior id do banco para fazer a inserção dps dele
                $consulta = "PREFIX foaf:<http://xmlns.com/foaf/0.1/>
                             PREFIX des:<http://www.desaparecidos.com.br/rdf/>  
			     PREFIX dbpprop:<http://dbpedia.org/property/>
                             select ?x where{ ?id des:id ?x} order by desc(xsd:int(?x)) limit 1";
                $url = urlencode($consulta);
                $sparqlURL = $GLOBALS['BD'].'?query='.$url;//.'+limit+1';
                
                $curl = curl_init();
		//curl_setopt($curl, CURLOPT_USERPWD, $GLOBALS['login']);	
		
                //definimos a URL a ser usada
                curl_setopt($curl, CURLOPT_URL, $sparqlURL);
	    	
                // define que o conteúdo obtido deve ser retornado em vez de exibido
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //Recebe o output da url como uma string
	    	
                curl_setopt($curl, CURLOPT_USERPWD, $GLOBALS['login']);
                
                // define o formato
                curl_setopt($curl,CURLOPT_HTTPHEADER,array('Accept: '.$format ));
	    	
                // executo a consulta e gravo na variavel resposta a resposta em $format(json)
                $resposta = curl_exec( $curl );
                
                //fecho o curl
	    	    curl_close($curl);
                //echo $resposta;
                
                 
                //var_dump($resposta);
                
                $jsonfile = json_decode($resposta);
                $jsonfile = $jsonfile->results;
                $jsonfile = $jsonfile->bindings[0];
                $jsonfile = $jsonfile->x;
                $jsonfile = $jsonfile->value;
                
                $id = (int)$jsonfile;
                return $id;
                
                //fim da getMaiorID
        }
        
        
        //comparo o dado que veio da raspagem com o que está no banco, dou preferencia pro banco
        function AtualizaDado($atributoPessoaDoBanco,$atributoPessoaDaRaspagem){
            //echo "-----------------<br>";
            if( strlen($atributoPessoaDoBanco) > 0 ){
                    //echo $atributoPessoaDoBanco."<br>";
                    return $atributoPessoaDoBanco;
                } else {
                    //echo $atributoPessoaDaRaspagem."<br>";
                    return $atributoPessoaDaRaspagem;
                }
        }


        
        function atualizacao_Principal(Pessoa $p){
                
            $format = 'application/sparql-results+json';



            foreach ($p as &$item) {
                if ($p->fonte == $item || $p->imagem == $item)
                    continue;
                $item = html_entity_decode(trim(strtolower($item)));
            }
         
            
            $id = existeDesaparecido($p->nome, $p->data_desaparecimento, $p->cidade);
            //echo "ID ou -1: ".$id."<br>";
            
            if( $id == -1){
                // pessoa não consta no banco, fazer o cadastro
		
                
		
                $Newid = getMaiorId();
                $Newid++;
                
                
                $prefix = "<http://www.desaparecidos.ufjf.br/desaparecidos/".$Newid.">";
                $endereco = "PREFIX foaf:<http://xmlns.com/foaf/0.1/>
					 PREFIX des:<http://www.desaparecidos.com.br/rdf/>
					 PREFIX dbpprop:<http://dbpedia.org/property/> 
					 INSERT DATA {".$prefix." des:id \"".$Newid."\".
                                  ".$prefix." foaf:name \"".$p->nome."\".";
                
                        if ( strlen($p->apelido) > 0 ){  $endereco = $endereco .$prefix." foaf:nick \"".$p->apelido."\".";  }
			if ( strlen($p->datanasc) > 0 ){  $endereco = $endereco .$prefix." foaf:birthday \"".$p->datanasc."\".";  }
			if ( strlen($p->sexo) > 0 ){  $endereco = $endereco .$prefix." foaf:gender \"".$p->sexo."\".";  }
			if ( strlen($p->imagem) > 0 ){  $endereco = $endereco .$prefix." foaf:img \"".$p->imagem."\".";  }
			if ( strlen($p->idade) > 0 ){  $endereco = $endereco .$prefix." foaf:age \"".$p->idade."\".";  }
			if ( strlen($p->cidade) > 0 ){  $endereco = $endereco .$prefix." des:cityDes \"".$p->cidade."\".";  }
			if ( strlen($p->estado) > 0 ){  $endereco = $endereco .$prefix." des:stateDes \"".$p->estado."\".";  }
			if ( strlen($p->altura) > 0 ){  $endereco = $endereco .$prefix." dbpprop:height \"".$p->altura."\".";  }
			if ( strlen($p->peso) > 0 ){  $endereco = $endereco .$prefix." dbpprop:weight \"".$p->peso."\".";  }
			if ( strlen($p->pele) > 0 ){  $endereco = $endereco .$prefix." des:skin \"".$p->pele."\".";  }
			if ( strlen($p->cor_cabelo) > 0 ){  $endereco = $endereco .$prefix." dbpprop:hairColor \"".$p->cor_cabelo."\".";  }
			if ( strlen($p->cor_olho) > 0 ){  $endereco = $endereco .$prefix." dbpprop:eyeColor \"".$p->cor_olho."\".";  }
			if ( strlen($p->mais_caracteristicas) > 0 ){  $endereco = $endereco .$prefix." des:moreCharacteristics \"".$p->mais_caracteristicas."\".";  }
			if ( strlen($p->data_desaparecimento) > 0 ){  $endereco = $endereco .$prefix." des:disappearanceDate \"".$p->data_desaparecimento."\".";  }
                        if ( strlen($p->local_desaparecimento) > 0 ){  $endereco = $endereco .$prefix." des:disappearancePlace \"".$p->local_desaparecimento."\".";  }
                        if ( strlen($p->circunstancia_desaparecimento) > 0 ){  $endereco = $endereco .$prefix." des:circumstanceLocation \"".$p->circunstancia_desaparecimento."\".";  }
                        if ( strlen($p->data_localizacao) > 0 ){  $endereco = $endereco .$prefix." des:dateLocation \"".$p->data_localizacao."\".";  }
                        if ( strlen($p->dados_adicionais) > 0 ){  $endereco = $endereco .$prefix." des:additionalData \"".$p->dados_adicionais."\".";  }
                        if ( strlen($p->situacao) > 0 ){  $endereco = $endereco .$prefix." des:status \"".$p->situacao."\".";  }                                             
                          $endereco = $endereco.$prefix." des:source \"".$p->fonte."\". }";
            
                        //echo "<br>".$endereco."<br>";
                        //echo $endereco."<br><br>";
                        $url = urlencode($endereco);
                        //echo $url."<br><br>";
                        $sparqlURL = $GLOBALS['BD'].'?query='.$url.'';
                        //echo "teste ok, nome : ". $p->nome;
                        
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_USERPWD, $GLOBALS['login']);	
		    	curl_setopt($curl, CURLOPT_URL, $sparqlURL);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); 
		    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //Recebe o output da url como uma string
		    	curl_setopt($curl,CURLOPT_HTTPHEADER,array('Accept: '.$format ));
		    	$resposta = curl_exec( $curl );
                        
		    	curl_close($curl);
                        echo "resposta insert caso -1: ".$resposta."<br>";
                        // fim da inserçao de um novo desaparecido */
                }

	    // pessoa cadastrada, atualizar dados
            else{
                 
                $id = '"'.$id.'"';
		
                $endereco = "PREFIX foaf:<http://xmlns.com/foaf/0.1/>
					 PREFIX des:<http://www.desaparecidos.com.br/rdf/>  
					 PREFIX dbpprop:<http://dbpedia.org/property/>
					 SELECT  ?nome ?apelido ?data_nascimento ?sexo ?imagem ?idade ?cidade ?estado ?altura ?peso ?pele ?cor_cabelo ?cor_olho ?mais_caracteristicas 
					 ?data_desaparecimento ?local_desaparecimento ?circunstancia_desaparecimento ?data_localizacao ?dados_adicionais ?status ?fonte 
					 WHERE {?recurso des:id ".$id." 
					 OPTIONAL {?recurso foaf:name ?nome}.
					 OPTIONAL {?recurso foaf:nick ?apelido}.
					 OPTIONAL {?recurso foaf:birthday ?data_nascimento}.
					 OPTIONAL {?recurso foaf:gender ?sexo}.
					 OPTIONAL {?recurso foaf:img ?imagem}.
					 OPTIONAL {?recurso foaf:age ?idade}.
					 OPTIONAL {?recurso des:cityDes ?cidade}.
					 OPTIONAL {?recurso des:stateDes ?estado}.
					 OPTIONAL {?recurso dbpprop:height ?altura}.
					 OPTIONAL {?recurso dbpprop:weight ?peso}.
					 OPTIONAL {?recurso des:skin ?pele}.
					 OPTIONAL {?recurso dbpprop:hairColor ?cor_cabelo}.
					 OPTIONAL {?recurso dbpprop:eyeColor ?cor_olho}.
					 OPTIONAL {?recurso des:moreCharacteristics ?mais_caracteristicas}.
					 OPTIONAL {?recurso des:disappearanceDate ?data_desaparecimento}.
					 OPTIONAL {?recurso des:disappearancePlace ?local_desaparecimento}.
					 OPTIONAL {?recurso des:circumstanceLocation ?circunstancia_desaparecimento}.
					 OPTIONAL {?recurso des:dateLocation ?data_localizacao}.
					 OPTIONAL {?recurso des:additionalData ?dados_adicionais}.
					 OPTIONAL {?recurso des:status ?status}.
					 OPTIONAL {?recurso des:source ?fonte}.
					} ";
					
		$url = urlencode($endereco);
		$sparqlURL = $GLOBALS['BD'].'?query='.$url.'+limit+1';

		
		$curl = curl_init();
		//curl_setopt($curl, CURLOPT_USERPWD, $GLOBALS['login']);	
		
                //definimos a URL a ser usada
                curl_setopt($curl, CURLOPT_URL, $sparqlURL);
	    	
                curl_setopt($curl, CURLOPT_USERPWD, $GLOBALS['login']);	
                
                // define que o conteúdo obtido deve ser retornado em vez de exibido
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //Recebe o output da url como uma string
	    	
                // define o formato
                curl_setopt($curl,CURLOPT_HTTPHEADER,array('Accept: '.$format ));
	    	
                // executo a consulta e gravo na variavel resposta a resposta em $format(json)
                $resposta = curl_exec( $curl );
                
                //fecho o curl
	    	curl_close($curl);

                //decodifico a resposta para reconhecer como json para q eu possa navegar nela
		$resposta = json_decode($resposta);
		$resposta = $resposta->results;
                $resposta = $resposta->bindings[0]; 
                // resposta agora guarda o objeto q contem os dados do desaparecido
                
		$auxPessoa = new Pessoa; //vai armazenar os dados da pessoa q estão contidos no allegro
		
		$auxPessoa->nome = $resposta->nome->value ; //no
                $auxPessoa->apelido = $resposta->apelido->value; //yes OK
                $auxPessoa->datanasc = $resposta->data_nascimento->value; //yes OK
                $auxPessoa->sexo = $resposta->sexo->value; //yes OK
                $auxPessoa->imagem = $resposta->imagem->value; //yes OK
                $auxPessoa->idade = $resposta->idade->value; //yes OK
                $auxPessoa->cidade = $resposta->cidade->value; //no
                $auxPessoa->estado = $resposta->estado->value;//yes OK
                $auxPessoa->altura = $resposta->altura->value;//yes OK
                $auxPessoa->peso = $resposta->peso->value;//yes OK
	        $auxPessoa->pele = $resposta->pele->value;//yes OK
                $auxPessoa->cor_cabelo = $resposta->cor_cabelo->value;//yes OK
                $auxPessoa->cor_olho = $resposta->cor_olho->value; //yes OK
	        $auxPessoa->mais_caracteristicas = $resposta->mais_caracteristicas->value; //yes OK
                $auxPessoa->data_desaparecimento = $resposta->data_desaparecimento->value; //no
                $auxPessoa->local_desaparecimento = $resposta->local_desaparecimento->value; //yes OK 
	        $auxPessoa->circunstancia_desaparecimento = $resposta->circunstancia_desaparecimento->value; //yOK
                $auxPessoa->data_localizacao = $resposta->data_localizacao->value; //yes OK
                $auxPessoa->dados_adicionais = $resposta->dados_adicionais->value; // yes OK
	        $auxPessoa->situacao = $resposta->status->value; //yes OK
            	$auxPessoa->fonte = $resposta->fonte->value; // yes OK

                // nome, data_des, cidade
                //echoes($auxPessoa);
                $NewPessoa = new Pessoa;
                
                /*p é a pessoa da raspagem, auxPessoa é a pessoa que estava no banco,
                  newPessoa é a que vai assumir o seu lugar 
                */
                $NewPessoa->nome = $auxPessoa->nome;
                $NewPessoa->cidade = $auxPessoa->cidade;
                $NewPessoa->data_desaparecimento = $auxPessoa->data_desaparecimento;
                $NewPessoa->datanasc = AtualizaDado($auxPessoa->datanasc, $p->datanasc);
                $NewPessoa->apelido = AtualizaDado($auxPessoa->apelido, $p->apelido);
                $NewPessoa->sexo = AtualizaDado($auxPessoa->sexo, $p->sexo);
                $NewPessoa->imagem = AtualizaDado($auxPessoa->imagem, $p->imagem);
                $NewPessoa->idade = AtualizaDado($auxPessoa->idade, $p->idade);
                $NewPessoa->estado = AtualizaDado($auxPessoa->estado, $p->estado);
                $NewPessoa->altura = AtualizaDado($auxPessoa->altura, $p->altura);
                $NewPessoa->peso = AtualizaDado($auxPessoa->peso, $p->peso);
                $NewPessoa->pele = AtualizaDado($auxPessoa->pele, $p->pele);
                $NewPessoa->cor_cabelo = AtualizaDado($auxPessoa->cor_cabelo, $p->cor_cabelo);
                $NewPessoa->cor_olho = AtualizaDado($auxPessoa->cor_olho, $p->cor_olho);
                $NewPessoa->mais_caracteristicas = AtualizaDado($auxPessoa->mais_caracteristicas, $p->mais_caracteristicas);
                $NewPessoa->circunstancia_desaparecimento = AtualizaDado($auxPessoa->circunstancia_desaparecimento, $p->circunstancia_desaparecimento);
                $NewPessoa->data_localizacao = AtualizaDado($auxPessoa->data_localizacao, $p->data_localizacao);
                $NewPessoa->dados_adicionais = AtualizaDado($auxPessoa->dados_adicionais, $p->dados_adicionais);
                $NewPessoa->local_desaparecimento = AtualizaDado($auxPessoa->local_desaparecimento, $p->local_desaparecimento);
                
                if(( $p->situacao == "Encontrada") || ($p->situacao == "Encontrado") ){
                    $NewPessoa->situacao = "Encontrada";
                } else {
                    $NewPessoa->situacao = "Desaparecida";
                }
                $NewPessoa->fonte = $p->fonte; // GUARDO A NOVA FONTE, PARA FINS DE ATUALIZAÇÃO
                //echo "-----------------<br>";
                //echoes ($NewPessoa);
                $where = "WHERE {?s des:id ".$id."};";			
                        echo $where."<br>";
			$endereco = "PREFIX foaf:<http://xmlns.com/foaf/0.1/>
                                        PREFIX dbpprop:<http://dbpedia.org/property/>
						 PREFIX des:<http://www.desaparecidos.com.br/rdf/> 
						 DELETE { ?s foaf:name \"".$auxPessoa->nome."\"} ".$where.
						"DELETE { ?s foaf:nick \"".$auxPessoa->apelido."\"}". $where.
						"DELETE { ?s foaf:birthday \"".$auxPessoa->datanasc."\"}".$where.
						"DELETE { ?s foaf:gender \"".$auxPessoa->sexo."\"}".$where.
						"DELETE { ?s foaf:img \"".$auxPessoa->imagem."\"}". $where.
						"DELETE { ?s foaf:age \"".$auxPessoa->idade."\"}".$where.
						"DELETE { ?s des:cityDes \"".$auxPessoa->cidade."\"}" .$where.
						"DELETE { ?s des:stateDes \"".$auxPessoa->estado."\"} ".$where.
						"DELETE { ?s dbpprop:height \"".$auxPessoa->altura."\"}" .$where.
						"DELETE { ?s dbpprop:weight \"".$auxPessoa->peso."\"}".$where.
						"DELETE { ?s des:skin \"".$auxPessoa->pele."\"}". $where.
						"DELETE { ?s dbpprop:hairColor \"".$auxPessoa->cor_cabelo."\"}".$where.
						"DELETE { ?s dbpprop:eyeColor \"".$auxPessoa->cor_olho."\"}". $where.
						"DELETE { ?s des:moreCharacteristics \"".$auxPessoa->mais_caracteristicas."\"}" .$where.
						"DELETE { ?s des:disappearanceDate \"".$auxPessoa->data_desaparecimento."\"}" .$where.
						"DELETE { ?s des:disappearancePlace \"".$auxPessoa->local_desaparecimento."\"}" .$where.
						"DELETE { ?s des:circumstanceLocation \"".$auxPessoa->circunstancia_desaparecimento."\"}".$where.
						"DELETE { ?s des:dateLocation \"".$auxPessoa->data_localizacao."\"}" .$where.
						"DELETE { ?s des:additionalData \"".$auxPessoa->dados_adicionais."\"}" .$where.
						"DELETE { ?s des:status \"".$auxPessoa->situacao."\"}" .$where.
						"DELETE { ?s des:source \"".$auxPessoa->fonte."\"}".$where
						;
                        //echo $endereco."<br>"."<br>"."<br>";
                        $url = urlencode($endereco);
			$sparqlURL = $GLOBALS['BD'].'?query='.$url.'';

			// deleta o desaparecido do banco
			$curl = curl_init();
                            curl_setopt($curl, CURLOPT_USERPWD, $GLOBALS['login']);	
                            curl_setopt($curl, CURLOPT_URL, $sparqlURL);
			    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); // Delete precisa ser feito por POST
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //Recebe o output da url como uma string
                            curl_setopt($curl,CURLOPT_HTTPHEADER,array('Accept: '.$format ));
                            $resposta = curl_exec( $curl );
		    	curl_close($curl);
                        echo "Resposta delete: ".$resposta."<br><br><br>";
                       
                        $endereco = "PREFIX foaf:<http://xmlns.com/foaf/0.1/>
                                                PREFIX dbpprop:<http://dbpedia.org/property/>
						 PREFIX des:<http://www.desaparecidos.com.br/rdf/> 
						 INSERT{
							 ?s foaf:name \"".$NewPessoa->nome."\".";
							 
                             if ( strlen($NewPessoa->apelido) > 0 ){ $endereco = $endereco. "?s foaf:nick \"".$NewPessoa->apelido."\"."; }
                             if ( strlen($NewPessoa->datanasc) > 0 ){ $endereco = $endereco. "?s foaf:birthday \"".$NewPessoa->datanasc."\"."; }
                             if ( strlen($NewPessoa->sexo) > 0 ){ $endereco = $endereco. "?s foaf:gender \"".$NewPessoa->sexo."\"."; }
                             if ( strlen($NewPessoa->imagem) > 0 ){ $endereco = $endereco. "?s foaf:img \"".$NewPessoa->imagem."\"."; }
                             if ( strlen($NewPessoa->idade) > 0 ){ $endereco = $endereco. "?s foaf:age \"".$NewPessoa->idade."\"."; }
                             if ( strlen($NewPessoa->cidade) > 0 ){ $endereco = $endereco. "?s des:cityDes \"".$NewPessoa->cidade."\"."; }
                             if ( strlen($NewPessoa->estado) > 0 ){ $endereco = $endereco. "?s des:stateDes \"".$NewPessoa->estado."\"."; }
                             if ( strlen($NewPessoa->altura) > 0 ){ $endereco = $endereco. "?s dbpprop:height \"".$NewPessoa->altura."\"."; }
                             if ( strlen($NewPessoa->peso) > 0 ){ $endereco = $endereco. "?s dbpprop:weight \"".$NewPessoa->peso."\"."; }
                             if ( strlen($NewPessoa->pele) > 0 ){ $endereco = $endereco. "?s des:skin \"".$NewPessoa->pele."\"."; }
                             if ( strlen($NewPessoa->cor_cabelo) > 0 ){ $endereco = $endereco. "?s dbpprop:hairColor \"".$NewPessoa->cor_cabelo."\"."; }    
                             if ( strlen($NewPessoa->cor_olho) > 0 ){ $endereco = $endereco. "?s dbpprop:eyeColor \"".$NewPessoa->cor_olho."\"."; }                                if ( strlen($NewPessoa->mais_caracteristicas) > 0 ){ $endereco = $endereco. "?s des:moreCharacteristics \"".$NewPessoa->mais_caracteristicas."\"."; }                      
                             if ( strlen($NewPessoa->data_desaparecimento) > 0 ){ $endereco = $endereco. "?s des:disappearanceDate \"".$NewPessoa->data_desaparecimento."\"."; }
                             if ( strlen($NewPessoa->local_desaparecimento) > 0 ){ $endereco = $endereco. "?s des:disappearancePlace \"".$NewPessoa->local_desaparecimento."\"."; }
                             if ( strlen($NewPessoa->circunstancia_desaparecimento) > 0 ){ $endereco = $endereco. "?s des:circumstanceLocation \"".$NewPessoa->circunstancia_desaparecimento."\"."; }
                             if ( strlen($NewPessoa->data_localizacao) > 0 ){ $endereco = $endereco. "?s des:dateLocation \"".$NewPessoa->data_localizacao."\"."; }
                             if ( strlen($NewPessoa->dados_adicionais) > 0 ){ $endereco = $endereco. "?s des:additionalData \"".$NewPessoa->dados_adicionais."\"."; }
                             if ( strlen($NewPessoa->situacao) > 0 ){ $endereco = $endereco. "?s des:status \"".$NewPessoa->situacao."\"."; }
                             $endereco = $endereco. " ?s des:source \"".$NewPessoa->fonte."\". }".$where;
                        
                        //echo $endereco."<br>";
                        $url = urlencode($endereco);
			$sparqlURL = $GLOBALS['BD'].'?query='.$url.'';
                        
                        $curl = curl_init();
                            curl_setopt($curl, CURLOPT_USERPWD, $GLOBALS['login']);	
                            curl_setopt($curl, CURLOPT_URL, $sparqlURL);
			    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); 
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //Recebe o output da url como uma string
                            curl_setopt($curl,CURLOPT_HTTPHEADER,array('Accept: '.$format ));
                            $resposta = curl_exec( $curl );
		    	curl_close($curl);
                        echo "Resposta insert: ".$resposta."<br><br><br>";        
            }    
           
        }

?>