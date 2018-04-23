<?php
$string = 'Test download string';

header('Content-type: text/plain');
header( 'Content-Length: ' . strlen( $string ) ); 
header('Content-Disposition: attachment; filename="Teste.txt"');

echo $string;
?>
