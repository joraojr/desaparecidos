<?php
$resultado = file_get_contents('http://172.18.40.9:10035/repositories/desaparecidos1/statements/query');
$resultado =  nl2br("$resultado");
$matriz = explode('
', $resultado, -1);
$tam = sizeof($matriz);
///////////////////////////////////////
/*
	// array novo
	$vetor[0] = $matriz[0];
	$i=1;
	$j=0;
	$count=1;
	while (i<$tam){
	vetor[j].=" ";
	vetor[j].= $matriz[i];
	for(int i=0; i<$tam; i++){
	
	}
*/
////////////////////////////////////////////

echo"Quantidade de desaparecidos cadastrados: $tam </br>";
echo"Primeira pessoa cadastrada: </br>";
for($i=0; $i<26; $i++){
echo"$matriz[$i] </br>";

/////IDEIAS
/*
 * Fazer consulta no allegro
 * guardar a consulta numa variavel srting
 * converter a string em Json object com  funcao json_encode();
 * decodificar o objeto json com a funçao json_decode()
 * e usar o resto do código do Adriano do "virtuoso_query"
 */
}
//200.131.219.27:10035/catalogs/system/repositories/desaparecidos?query=select+%3Fa+%7B%3Fa+%3Fb+%3Fc%7D+limit+10
?>

