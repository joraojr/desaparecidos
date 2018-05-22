<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Projeto Desaparecidos - UFJF <?php if(isset($title)) echo '| '.$title ?></title>
    <link href="<?php echo base_url(); ?>style.css?rand=<?php echo rand(100, 999) ?>" type="text/css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#search').click(function(){
                $('#result .alert').fadeIn('slow');
                $.ajax({
                type: 'POST',
                url: "<?php echo site_url('buscar/ajax_search') ?>",
                data: {nome:$('#nome').attr('value'), sexo:$('#sexo').attr('value'), situacao:$('#situacao').attr('value'), idade:$('#idade').attr('value')},
                success:function(data){
                    $('#result .alert').fadeIn('fast');
                    $('#result .content').html(data);                    
                    $('html,body').animate({scrollTop: $('#result .content').offset().top}, 1000);
                }
                });
            });
            
            $('.mais-result').live('click', function(){ 
                $.ajax({
                type: 'POST',
                url: "<?php echo site_url('buscar/ajax_search/') ?>" + "/" + $(this).attr('offset'),
                data: {nome:$('#nome').attr('value'), sexo:$('#sexo').attr('value'), situacao:$('#situacao').attr('value'), idade:$('#idade').attr('value')},
                success:function(data){
                    $('#result .alert').fadeIn('fast');
                    $('#result .content').html(data);                    
                    $('html,body').animate({scrollTop: $('#result .content').offset().top}, 1000);
                }
                });
            });
        });        
    </script>
</head>
<body>

<div id="header">
    <div class="top center-layout">
    
    </div>
    <div class="menu center-layout">
    <a title="Página principal" href="<?php echo site_url(); ?>">Página principal</a> |
    <a title="Sobre o projeto" href="<?php echo site_url(); ?>/sobre">Sobre o projeto</a> |
    <a title="Colaboradores" href="<?php echo site_url(); ?>/colaboradores">Colaboradores</a> |
    <a title="Fale conosco" href="<?php echo site_url(); ?>/fale_conosco">Fale conosco</a>
    </div>
</div>

<div id="wrap">
	
    <div id="body">

        <div class="box-content">            
                <?php
                    if(!empty($breadcrumbs)){
                        echo '<div class="breadcrumbs">Você está em: ';
                        $count = sizeof($breadcrumbs);
                        foreach ($breadcrumbs as $item) {
                            if($count != 1){
                                echo '<a title="'.$item["title"].'" href="'.site_url($item["link"]).'/">'.$item["title"].'</a> » ';
                            }else{
                                echo '<strong>'.$item["title"].'</strong>';
                            }
                            $count--;
                        }
                        echo '</div>';
                    }
                ?>
            
