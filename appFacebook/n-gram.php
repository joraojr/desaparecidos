<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xml:lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Aplicativo - Projeto Desaparecidos UFJF</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />    
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript">
            $(document).ready(function() {
                
                    

                
                $('#button').click(function(){
                    var str = $('#field').val();
                    var arr = str.split(' ');
                    var count = 1;
                    var aux = '';
                    str = '';
                    for(i=0; i < (arr.length - 1); i++){
                        if(i != 0) str += ' || ';
                        str += 'regex(?nome, "' + arr[i]+' '+arr[i+1] + '", "i")';
                    }
                    
                    $('.result').html(str);
                    
                    $.ajax({                        
                        url: 'http://desaparecidos.ice.ufjf.br/index.php/buscar/ajax_search_name',
                        data: {texto: str},
                        dataType: 'json',
                        success: function(data) {
                            alert(data.size);
                        }
                    });
                });
            });
		
	</script>
</head>
<body>
    <textarea id="field" style="width:500px;height:300px;">Lorem Ipsum is simply Alexandre Felisberto de Almeida dummy text of the printing and typesetting industry.</textarea>
    <br />
    <input type="button" value="Processar" id="button" />
    <div class="result"></div>
</body>
</html>