<?php
/* Código para raspagem de dados => http://www.criancadesaparecida.org/
 */
 
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



    $urlBase = 'http://www.criancadesaparecida.org/desaparecidos/';
    $cont = 0;
    $html = file_get_html($urlBase);
    //echo $html;
    
    foreach( $html->find('li[class="crianca feminino"]') as $girl){ // para entrar nesse caso deve ser mnina e estar desaparecida
        //echo "ada<br>";
        
        $p = new Pessoa();       // li class="crianca feminino "
        $p->sexo = "Feminino";
        $p->situacao = "Desaparecida";
        
        // PEGANDO O NOME DA MENINA
        $nome = $girl->find('h6');
        $p->nome = html_entity_decode($nome[0]->plaintext);
        
        $img = $girl->find('img');
        $p->imagem = $img[0]->src;
        
        
        // CIDADE/ESTADO
        $cidadestado = $girl->find('small');
        $cityes = $cidadestado[0]->plaintext;
        
        $vet = explode("/", $cityes );
        
        $p->cidade = html_entity_decode($vet[0]);
        $p->estado = html_entity_decode($vet[1]);
        
        
        // ACESSANDO A PAGINA ESPECIFICA
        $html2 = file_get_html($urlBase.($girl->id));
        
        
        // PEGANDO A DATA DO DESAPARECIMENTO
        $h6 = $html2->find('h6');
        $obj = explode(" ",$h6[0]);
        
        $p->data_desaparecimento = $obj[2];
        
        
        //PEGANDO DADOS ADICIONAIS COMO IDADE, COR DO CABELO
        $dadosDesaparecido = array();
        $i =0;
        foreach( $html2->find('li') as $li){
            $dadosDesaparecido[$i] = $li->plaintext;
            $i++;
        }
        $p->idade = str_replace("Anos","",certifica("Idade:",$dadosDesaparecido));
        $p->pele = html_entity_decode(certifica("Pele:",$dadosDesaparecido));
        $p->altura = certifica("Altura:",$dadosDesaparecido);
        $p->cor_cabelo = certifica("Cabelo:",$dadosDesaparecido);
        
        
        // A FONTE É A PRÓPRIA PAGINA GERAL POIS NA ESPECIFICA NAO TEM IDENTIFICAÇÃO DE ENCONTRADA
        $p->fonte = $urlBase.($girl->id);
        $cont++;
        echo $p->nome."<br>";
        atualizacao_Principal($p);
        echo "-----------------------<br>";
        //break;
    }
 

    foreach( $html->find('li[class="crianca masculino"]') as $boy){ // para entrar nesse caso deve ser menino e estar desaparecida
        
        $p = new Pessoa();       
        $p->sexo = "Masculino";
        $p->situacao = "Desaparecida";
        
        // PEGANDO O NOME DO MENINO
        $nome = $boy->find('h6');
        $p->nome = html_entity_decode($nome[0]->plaintext);
        
        //IMAGEM
        $img = $boy->find('img');
        $p->imagem = $img[0]->src;
        
        // CIDADE/ESTADO
        $cidadestado = $boy->find('small');
        $cityes = $cidadestado[0]->plaintext;
        
        $vet = explode("/", $cityes );
        
        $p->cidade = html_entity_decode($vet[0]);
        $p->estado = html_entity_decode($vet[1]);
        
        
        // ACESSANDO A PAGINA ESPECIFICA
        $html2 = file_get_html($urlBase.($boy->id));
        
        
        // PEGANDO A DATA DO DESAPARECIMENTO
        $h6 = $html2->find('h6');
        $obj = explode(" ",$h6[0]);
        
        $p->data_desaparecimento = $obj[2];
        
        
        //PEGANDO DADOS ADICIONAIS COMO IDADE, COR DO CABELO
        $dadosDesaparecido = array();
        $i =0;
        foreach( $html2->find('li') as $li){
            $dadosDesaparecido[$i] = $li->plaintext;
            $i++;
        }
        $p->idade = str_replace("Anos","",certifica("Idade:",$dadosDesaparecido));
        $p->pele = certifica("Pele:",$dadosDesaparecido);
        $p->altura = certifica("Altura:",$dadosDesaparecido);
        $p->cor_cabelo = certifica("Cabelo:",$dadosDesaparecido);
        
        
    
        // A FONTE É A PRÓPRIA PAGINA GERAL POIS NA ESPECIFICA NAO TEM IDENTIFICAÇÃO DE ENCONTRADA
        $p->fonte = $urlBase.($boy->id);
        $cont++;
        echo $p->nome."<br>";
        atualizacao_Principal($p);
        echo "-----------------------<br>";
        //break;
    }



    foreach( $html->find('li[class="crianca masculino encontrada"]') as $boy){ // para entrar nesse caso deve ser menino e estar encontrado
        
        $p = new Pessoa();       
        $p->sexo = "Masculino";
        $p->situacao = "Encontrada";
        
        // PEGANDO O NOME DO MENINO
        $nome = $boy->find('h6');
        $p->nome = $nome[0]->plaintext;
        
        //IMAGEM
        $img = $boy->find('img');
        $p->imagem = $img[0]->src;
        
        // CIDADE/ESTADO
        $cidadestado = $boy->find('small');
        $cityes = $cidadestado[0]->plaintext;
        
        $vet = explode("/", $cityes );
        
        $p->cidade = $vet[0];
        $p->estado = $vet[1];
        
        
        // ACESSANDO A PAGINA ESPECIFICA
        $html2 = file_get_html($urlBase.($boy->id));
        
        
        // PEGANDO A DATA DO DESAPARECIMENTO
        $h6 = $html2->find('h6');
        $obj = explode(" ",$h6[0]);
        
        $p->data_desaparecimento = $obj[2];
        
        
        //PEGANDO DADOS ADICIONAIS COMO IDADE, COR DO CABELO
        $dadosDesaparecido = array();
        $i =0;
        foreach( $html2->find('li') as $li){
            $dadosDesaparecido[$i] = $li->plaintext;
            $i++;
        }
        $p->idade = str_replace("Anos","",certifica("Idade:",$dadosDesaparecido));
        $p->pele = certifica("Pele:",$dadosDesaparecido);
        $p->altura = certifica("Altura:",$dadosDesaparecido);
        $p->cor_cabelo = certifica("Cabelo:",$dadosDesaparecido);
        
        
        
        // A FONTE É A PRÓPRIA PAGINA GERAL POIS NA ESPECIFICA NAO TEM IDENTIFICAÇÃO DE ENCONTRADA
        $p->fonte = $urlBase.($boy->id);
        $cont++;
        echo $p->nome."<br>";
        atualizacao_Principal($p);
        echo "-----------------------<br>";
        //break;
    }


    foreach( $html->find('li[class="crianca feminino encontrada"]') as $girl){ // para entrar nesse caso deve ser menina e estar encontrada
        
        $p = new Pessoa();       
        $p->sexo = "Feminino";
        $p->situacao = "Encontrada";
        
        // PEGANDO O NOME DA MENINA
        $nome = $girl->find('h6');
        $p->nome = $nome[0]->plaintext;
        
        //IMAGEM
        $img = $girl->find('img');
        $p->imagem = $img[0]->src;
        
        // CIDADE/ESTADO
        $cidadestado = $girl->find('small');
        $cityes = $cidadestado[0]->plaintext;
        
        $vet = explode("/", $cityes );
        
        $p->cidade = $vet[0];
        $p->estado = $vet[1];
        
        
        // ACESSANDO A PAGINA ESPECIFICA
        $html2 = file_get_html($urlBase.($girl->id));
        
        
        // PEGANDO A DATA DO DESAPARECIMENTO
        $h6 = $html2->find('h6');
        $obj = explode(" ",$h6[0]);
        
        $p->data_desaparecimento = $obj[2];
        
        
        //PEGANDO DADOS ADICIONAIS COMO IDADE, COR DO CABELO
        $dadosDesaparecido = array();
        $i =0;
        foreach( $html2->find('li') as $li){
            $dadosDesaparecido[$i] = $li->plaintext;
            $i++;
        }
        $p->idade = str_replace("Anos","",certifica("Idade:",$dadosDesaparecido));
        $p->pele = certifica("Pele:",$dadosDesaparecido);
        $p->altura = certifica("Altura:",$dadosDesaparecido);
        $p->cor_cabelo = certifica("Cabelo:",$dadosDesaparecido);
        
        
        // A FONTE É A PRÓPRIA PAGINA GERAL POIS NA ESPECIFICA NAO TEM IDENTIFICAÇÃO DE ENCONTRADA
        $p->fonte = $urlBase.($girl->id);
        $cont++;    
            
        echo $p->nome."<br>";
        atualizacao_Principal($p);
        echo "-----------------------<br>";
        //break;
    }
    echo "<br>qtd pessoas : ". $cont;


?>
