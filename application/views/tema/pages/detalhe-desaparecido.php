<?php $this->load->view('tema/header'); ?>

<?php
$fields =  array(
              'nome'=>'Nome completo',
              'apelido'=>'Apelido',
              'data_nascimento'=>'Data de Nascimento',
              'sexo'=>'Sexo',
              'idade'=>'Idade',
              'cidade'=>'Cidade',
              'estado'=>'Estado',
              'altura'=>'Altura',
              'peso'=>'Peso',
              'pele'=>'Pele',
              'cor_cabelo'=>'Cor do cabelo',
              'cor_olho'=>'Cor dos olhos',
              'mais_caracteristicas'=>'Outras características',
              'data_desaparecimento'=>'Data do desaparecimento',
              'local_desaparecimento'=>'Local do desaparecimento',
              'circunstancia_desaparecimento'=>'Circunstância do desaparecimento',
              'data_localizacao'=>'Data da localização',
              'dados_adicionais'=>'Informações adicionais',
              'status'=>'Situação',
              'fonte'=>'Fonte'
        );
?>

<h2><?php echo $desaparecido->nome; ?></h2>
<div class="detalhe">    
    <?php
        if(empty($desaparecido->imagem)) echo '<img class="img-desaparecido" src="'.base_url().'/images/img-desaparecido.png" />';
	else echo '<img class="img-desaparecido" height="130" width="130" src="'.$desaparecido->imagem.'"/>';
        echo '<a title="Download do RDF" href="'.site_url('desaparecido/rdf/'.$id).'"><img class="img-download-rdf" src="'.base_url().'/images/rdf_icon.gif" /></a>';
        foreach($desaparecido as $key => $value){
            if($key == 'imagem') continue;
            if($key == 'fonte'){
                echo '<div class="field"><label>'.$fields[$key].': </label><a target="_blank" href="'.$value.'">'.$value.'</a></div>';
            }else{
                if(!empty($value)) echo '<div class="field"><label>'.$fields[$key].': </label>'.$value.'</div>';
            }
        }
    ?>
</div>

<?php $this->load->view('tema/footer'); ?>
