<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/">
<head>
    <title>Access</title>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            
//            $('#click').click(function(){
//                $.ajax({
//                    url:'http://desaparecidos.ice.ufjf.br:8890/sparql?format='+$('#format').attr('value')+'&query='+$('#query').attr('value')+'&default-graph-uri=http://desaparecidos.ice.ufjf.br:8890/DES#', 
//                    success:function(data) {
//                        $('#content').html(data);
//                    }
//                });
//            });
//            
          

            
           
            
//            $.post(
//                'http://localhost/monografia/index.php/access/busca_por_nome', 
//                { 
//                    'format': 'text/html', 
//                    'query': 'prefix foaf: <http://xmlns.com/foaf/0.1/>  select ?nome, ?idade Where{ ?recurso foaf:name ?nome. ?recurso foaf:age ?idade }',
//                    'default-graph-uri': 'http://desaparecidos.ice.ufjf.br:8890/DES#'
//                },
//                function(data) {
//                    $('#content').html(data);
//                });
//            });

        });
        
        
        
        
        
        
        
        
        
        
        
        if(!window.Kolich){
                Kolich = {};
        }

        Kolich.Selector = {};
        // getSelected() was borrowed from CodeToad at
        // http://www.codetoad.com/javascript_get_selected_text.asp
        Kolich.Selector.getSelected = function(){
                var t = '';
                if(window.getSelection){
                        t = window.getSelection();
                }else if(document.getSelection){
                        t = document.getSelection();
                }else if(document.selection){
                        t = document.selection.createRange().text;
                }
                return t;
        }

        Kolich.Selector.mouseup = function(){
                var st = Kolich.Selector.getSelected();
                if(st!=''){                        
                        $('#content').html('');                
                        $.ajax({
                            url: 'http://localhost/monografia/index.php/access/busca_por_nome/'+st,
                            success: function(data) {                                
                                $('#content').html(data);                
                            }
                        });
                        
                }
        }

        $(document).ready(function(){
                $(document).bind("mouseup", Kolich.Selector.mouseup);
        });
    </script>

</head>
<body>
    <h2>Crianca desaparecida</h2>
    <h3>Schirlei Mara Simoes de Lima</h3>
    <p></p>
    
   <div id="content"></div>
</body>
</html>
