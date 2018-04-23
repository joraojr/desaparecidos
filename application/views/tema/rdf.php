<?xml version="1.0" encoding="ISO-8859-1"?>
<rdf:RDF
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:foaf="http://xmlns.com/foaf/0.1/" 
	xmlns:dbpprop="http://dbpedia.org/property/"
	xmlns:being="http://purl.org/ontomedia/ext/common/being#"
	xmlns:owl="http://www.w3.org/2002/07/owl#"
	xmlns:des="http://www.desaparecidos.com.br/rdf/
        rdf/">
<?php	
    $nome = $desaparecido->nome;
    echo'$nome';
    ?>
	<rdf:description rdf:about="http://www.desaparecidos.ufjf.br/desaparecidos/3">
		<foaf:name><?php echo $desaparecido->nome ?></foaf:name>
		<foaf:nick><?php echo $desaparecido->apelido ?></foaf:nick>
		<foaf:birthday><?php echo $desaparecido->data_nascimento ?></foaf:birthday>
		<foaf:gender><?php echo $desaparecido->sexo ?></foaf:gender>
		<foaf:img><?php echo $desaparecido->imagem ?></foaf:img>
		<foaf:age><?php echo $desaparecido->idade ?></foaf:age>
		<des:cityDes><?php echo $desaparecido->cidade ?></des:cityDes>
		<des:cityDes rdf:resource="http://rdf.freebase.com/ns/en.juiz_de_fora" />
		<des:cityDes rdf:resource="http://dbpedia.org/resource/Juiz_de_Fora" />
		<des:cityDes rdf:resource="" />
		<des:cityDes rdf:resource="" />
		<des:stateDes><?php echo $desaparecido->estado ?></des:stateDes>
		<dbpprop:height><?php echo $desaparecido->altura ?></dbpprop:height>
		<dbpprop:weight><?php echo $desaparecido->peso ?></dbpprop:weight>
		<des:skin><?php echo $desaparecido->pele ?></des:skin>
		<dbpprop:hairColor><?php echo $desaparecido->cor_cabelo ?></dbpprop:hairColor>
		<dbpprop:eyeColor><?php echo $desaparecido->cor_olho ?></dbpprop:eyeColor>
		<des:moreCharacteristics><?php echo $desaparecido->mais_caracteristicas ?></des:moreCharacteristics>
		<des:disappearanceDate><?php echo $desaparecido->data_desaparecimento ?></des:disappearanceDate>
		<des:disappearancePlace><?php echo $desaparecido->local_desaparecimento ?></des:disappearancePlace>
		<des:circumstanceLocation><?php echo $desaparecido->circunstancia_desaparecimento ?></des:circumstanceLocation>
		<des:dateLocation><?php echo $desaparecido->data_localizacao ?></des:dateLocation>
		<des:additionalData><?php echo $desaparecido->dados_adicionais ?></des:additionalData>
		<des:status><?php echo $desaparecido->status ?></des:status>
		<des:source><?php echo $desaparecido->fonte ?></des:source>
	</rdf:description>
</rdf:RDF>