<?php
    $fields =  array(
            'nome'=>'Nome completo',
            'apelido'=>'Apelido',
            'data_nascimento'=>'Data de Nascimento',            
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/">
<head>
    <title>Desaparecidos</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <style type="text/css" media="screen">
        *{
            margin:0;padding:0;border:0;
        }
        
        body{
            font-size: 13px;
            font-family: Arial;
            color:#191919;
            margin:54px 0;
            background: #FFF;
        }
        
        #header{
            border-top: 3px solid #B70C12;
            background:#181818;
            padding:10px;
            color:#FFF;
            
            -moz-box-shadow:0px 3px 4px #888;
            box-shadow:0px 3px 4px #888;
            margin-bottom: 6px;
            position: fixed;
            top:0;
            left: 0;
            width: 100%;
            z-index:999;
        }
        
        #footer{
            color:#FFF;
            background: #771010;
            padding:10px;
            margin-top: 6px;
            text-align: center;
            position: fixed;
            bottom:0;
            left: 0;
            width: 100%;
        }
        
        table{
            width: 100%;
        }
        
        table tr td{            
            padding:6px;
        }
        
        table .one td{
            background:#E0E0E0;
        }
        
        table tr:hover td{
            background:#EDA600;
        }
        
        a{
            color:#8E0C0C;
            text-decoration: none;
        }
        
        .data-not-found{
            text-align: center;
        }
        
        h2{
            padding:6            
        }
        
        #body{
            padding:6px;
        }
        
        h3{
            padding:8px 6px 6px;
            font-size:20px;
            font-weight: bold;            
        }
        
        .img-desaparecido{
            float:left;
            margin-right: 6px;
            border: 1px solid #E0E0E0;
        }
        
        .rdf{
            position: absolute;
            top:67px;
            right:20px;
        }
        
        label{
            font-weight: bold;
        }
        
        .clear{clear:both;}
        
        .situacao{
            color: #440808;
            font-size: 16px;
            margin-bottom: 5px;
            padding-top: 15px;
        }
        
        .other-information{
            
        }
        
        .other-information div{
            padding:6px;
        }
        
        .other-information .one{
            background: #E0E0E0;
        }
        
        .other-information h4{
            margin-top: 6px;
            margin-bottom:6px;
            font-size: 18px;
        }
        .back{
            color:#FFF;
            font-size: 14px;
            float: right;
            text-decoration: none;   
            margin-top:5px;
            margin-right: 20px;
            display: block;
        }
    </style>

</head>
<body>
    <div id="header">
        <h2>PROJETO DESAPARECIDOS - UFJF<a href="<?php echo $link; ?>" class="back"><< Voltar</a></h2>
    </div>

    <div id="body">        
        <div class="detalhe">    
            <?php
                if(empty($desaparecido->imagem)) echo '<img class="img-desaparecido" src="'.base_url().'/images/img-desaparecido.png" />';
                echo '<div class="situacao"><label>Situação: </label> '.$desaparecido->status.'</div>';
                echo '<h3>' . $desaparecido->nome . '</h3>';
                echo '<a class="rdf" target="_blank" title="Download do RDF" href="'.site_url('desaparecido/rdf/'.$id).'"><img class="img-download-rdf" src="'.base_url().'/images/rdf_icon.gif" /></a>';
                
                if(isset($desaparecido->sexo) && ($desaparecido->sexo != '')){
                    echo '<div class="field"><label>Sexo: </label>'.$desaparecido->sexo.'</div>';
                }
                
                if(isset($desaparecido->idade) && ($desaparecido->idade != '')){
                    echo '<div class="field"><label>Idade: </label>'.$desaparecido->idade.'</div>';
                }
                echo '<div class="clear"></div>';
                echo '<div class="other-information">';
                echo '<h4>Informações adicionais</h4>';
                $control = 'one';
                foreach($desaparecido as $key => $value){
                    if($key == 'sexo') continue;
                    if($key == 'idade') continue;
                    if($key == 'nome') continue;
                    if($key == 'imagem') continue;
                    if(!empty($value)){ 
                        if($key == 'fonte'){
                            echo '<div class="field '.$control.'"><label>'.$fields[$key].': </label><a target="_blank" href="'.$value.'">'.$value.'</a></div>';
                        }else{
                            echo '<div class="field '.$control.'"><label>'.$fields[$key].': </label>'.$value.'</div>';
                        }
                        
                        if($control == 'one') $control = 'two'; else $control = 'one';
                    }
                    
                }
                echo '</div>';
            ?>
        </div>
    </div>

    <div id="footer">
        © Projeto Desaparecidos - UFJF
    </div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32689418-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>


