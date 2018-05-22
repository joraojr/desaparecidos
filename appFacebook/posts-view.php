<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Projeto Desaparecidos - UFJF</title>
    <link href="http://desaparecidos.ice.ufjf.br/style.css" type="text/css" rel="stylesheet" media="screen">
    <link href="style-page.css" type="text/css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
           $('#mural .item').mouseenter(function(){
               $(this).find('.ajude').fadeIn('fast');
           });
           
           $('#mural .item').mouseleave(function(){
               $(this).find('.ajude').fadeOut('fast');
           });
        });        
    </script>
</head>
<body>

<div id="header">
    <div class="top center-layout">
    
    </div>
    <div class="menu center-layout">
    <a title="Página principal" href="http://desaparecidos.ice.ufjf.br/index.php">Página principal</a> |
    <a title="Sobre o projeto" href="http://desaparecidos.ice.ufjf.br/index.php/sobre">Sobre o projeto</a> |
    <a title="Colaboradores" href="http://desaparecidos.ice.ufjf.br/index.php/colaboradores">Colaboradores</a> |
    <a title="Fale conosco" href="http://desaparecidos.ice.ufjf.br/index.php/fale_conosco">Fale conosco</a>
    </div>
</div>

<div id="wrap">
	
    <div id="body">

    <div class="box-content">            
    <h2>Mensagens de usuários do Facebook</h2>
        <?php

            if($_POST && $_POST['login'] && $_POST['login'] == 'computacao'){
                $_SESSION['logged'] = true;    
            }

            if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
                $username = "rooke670_delvoux";
                $password = "my20237264";
                $hostname = "localhost"; 

                //connection to the database
                $conexao = @mysql_connect($hostname, $username, $password);
                $db = mysql_select_db("rooke670_comercioeletronico",$conexao);                    

                //VERIFICA SE O POST JÁ ESTÁ CADASTRADO
                $result = mysql_query('SELECT * FROM des_postagem ORDER BY data_cadastro DESC');
                echo '<div id="mural">';
                while($row = mysql_fetch_array($result)){            
                    $post = json_decode($row['post']);                    
                    ?>
<div id="" class="item">
<img width="45" class="picture" src="http://graph.facebook.com.br/<?php echo $post->from->id; ?>/picture" />
<?php
    if($post->icon){
        echo '<img class="icon" src="' . $post->icon . '" />';
    }
?>
<a class="name" target="_blank" href="http://www.facebook.com.br/<?php echo $post->from->id ?>"><?php echo $post->from->name; ?></a><br />
<label class="date"><?php echo $post->created_time; ?></label>
<p class="clear"></p>
<?php
    $picture = '';
    if($post->picture){
        $picture = '<a class="msg-picture" target="_blank" href="' . $post->link . '"><img width="60" src="' . $post->picture . '" /></a>';
    }
    if($post->message){
        echo '<p class="story">' . $picture . $post->message . '<div class="clear"></div></p>';                        
    }else{
        if($post->story){
            echo '<p class="story">' . $picture . $post->story . '<div class="clear"></div></p>';                        
        }
    }
    
    if($row['status'] == 0){
        echo '<span class="status-sem-informacao">Nenhuma informação sobre esta postagem</span>';
    }elseif($row['status'] == 1){
        echo '<span class="status-nao-encontrada">Esta pessoa ainda não foi encontrada</span>';
    ?>
    <div class="ajude" style="display:none;">
        <div class="box">
            <h3>Ajude a encontrar esta pessoa</h3>
            <p>Caso você tenha alguma informação que ajude a encontrar esta pessoa <a href="#">clique aqui</a>.</p>
            <p>Se esta pessoa já foi encontrada <a href="#">clique aqui</a> e ajude a manter as informações deste site atualizadas.</p>
            <p>Para mais informações acesse a página <a href="#">fale conosco</a>.</p>
        </div>
    </div>
    <?php
    }elseif($row['status'] == 2){
        echo '<span class="status-encontrada">Esta pessoa já foi encontrada</span>';
    }else{
        
    }
?>
</div>        
        
<?php
    }  
    echo '</div><!-- End mural -->';
}else echo '<form method="post"><input type="password" name="login"  /><input type="submit"></form>';
?>

    </div><!-- END box-content -->
    <div class="menu-lat">
        <h3>» Menu</h3>
        <ul>
            <li><a title="Lista de desaparecidos" href="http://desaparecidos.ice.ufjf.br/index.php">Buscar desaparecidos</a></li>
            <li><a title="Lista de desaparecidos" href="http://desaparecidos.ice.ufjf.br/index.php/desaparecido/lista">Lista de desaparecidos</a></li>
            <li><a title="Extesão para Firefox" href="http://desaparecidos.ice.ufjf.br/index.php/plugin">Extesão para Firefox</a></li>
            <li><a title="Consulta Sparql" href="http://desaparecidos.ice.ufjf.br/index.php/sparql">Consulta Sparql</a></li>
        </ul>
        <h3>» Links úteis</h3>
        <ul>
            <li><a title="Virtuoso Opensource" target="_blank" href="http://virtuoso.openlinksw.com/">Virtuoso Opensource</a></li>
        </ul>
    </div>
    </div>
    <div class="clear auto-heigh"></div>
</div>

<div id="footer">
	<div class="box">
    	<div class="center-layout">
            <div class="menu-bottom">
                <a title="Página principal" href="http://desaparecidos.ice.ufjf.br/index.php">Página principal</a> |
                <a title="Sobre o projeto" href="http://desaparecidos.ice.ufjf.br/index.php/sobre">Sobre o projeto</a> |
                <a title="Colaboradores" href="http://desaparecidos.ice.ufjf.br/index.php/colaboradores">Colaboradores</a> |
                <a title="Fale conosco" href="http://desaparecidos.ice.ufjf.br/index.php/fale_conosco">Fale conosco</a>
            </div>
            <img class="logos" src="http://desaparecidos.ice.ufjf.br/images/footer.png" />
		</div>
    </div>
    <div class="desenvolvimento">
    	<div class="center-layout">
            <div class="copyR">© Projeto Desaparecidos - UFJF</div>
            <div class="autor">Web Master - Adriano Delvoux</div>
        </div>
    </div>
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
