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
        
        #body{
            padding:0 6px;
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
        
        h3{
            padding:6px;
            font-size:16px;
            font-weight: bold;            
        }
        
    </style>

</head>
<body>
    <div id="header">
        <h2>PROJETO DESAPARECIDOS - UFJF</h2>
    </div>
    
    <div id="body">
        <h3>Busca por: <i><?php echo $palavra ?></i></h3>
        <table cellspacing="0" cellpadding="0" border="0">
        <?php $control = 'one'; ?>
        <?php foreach($desaparecidos as $des): ?>
            <tr class="<?php echo $control; ?>">
                <td><?php echo $des->nome ?></td>
                <td width="100"><a href="<?php echo site_url('access/detalhe').'/'.$des->id.'/'.$palavra; ?>">Ver detalhes</a></td>
            </tr>
            
            <?php
                if($control == 'one')
                    $control = 'two';
                else
                    $control = 'one';
            ?>
        <?php endforeach; ?>
            <?php
                if(sizeof($desaparecidos) == 0){
                    echo '<tr><td class="data-not-found">Nenhum registro encontrado</td></tr>';
                }
            ?>
        </table>
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
