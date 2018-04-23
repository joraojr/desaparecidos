<?php
    if(isset($_GET['uid']) && isset($_GET['post_id']) && isset($_GET['token'])){    
        $username = "rooke670_delvoux";
        $password = "my20237264";
        $hostname = "localhost"; 

        //CONECTA COM O BANCO
        $conexao = @mysql_connect($hostname, $username, $password);
        $db = mysql_select_db("rooke670_comercioeletronico",$conexao);                    
        
        //VERIFICA SE O POST JÁ ESTÁ CADASTRADO DE ACORDO COM SEU ID
        $result = mysql_query('SELECT COUNT(*) as total FROM des_postagem WHERE post_id = "'.trim($_GET['post_id']).'"');
        $row = mysql_fetch_array($result);
        if($row['total'] == 0){
            //BUSCA OS DADOS DA POSTAGEM
            $post = file_get_contents('https://graph.facebook.com/' . trim($_GET['post_id']) . '&access_token=' . trim($_GET['token']));
            if(isset($post) && $post != 'false'){
                //CADASTRA O POST NO BANCO
                if($post != ''){
                    mysql_query("INSERT INTO des_postagem(uid, post_id, post) VALUES ('" . $_GET['uid'] . "', '" . $_GET['post_id'] . "',  '" . addslashes($post) . "')");
                }else{
                    mysql_query("INSERT INTO des_postagem(uid, post_id, post) VALUES ('ERROR', '" . $_GET['post_id'] . "',  '" . $_GET['uid'] . " - " . addslashes($post) . "')");
                }
            }else{
                
            }
            echo $_GET['post_id'] . '|||Não foi encontrado nenhum registro desta mensagem na base!';
        }else{
            echo $_GET['post_id'] . '|||Está mensagem já existe na base';
        }
        
    }
?>
