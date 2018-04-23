<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xml:lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Aplicativo - Projeto Desaparecidos UFJF</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=340" />
    <link rel="stylesheet" href="style.css?random=<?php echo rand(100, 999) ?>" type="text/css" />       
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
    <script type="text/javascript">
        var fuzzyFacebookTime = (function(){ 
        fuzzyTime.defaultOptions={
            // time display options
            relativeTime : 48,
            // language options
            monthNames : ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            amPm : ['AM', 'PM'],
            ordinalSuffix : function(n) {return ['th','st','nd','rd'][n<4 || (n>20 && n % 10<4) ? n % 10 : 0]}
        }

        function fuzzyTime (timeValue, options) {

            var options=options||fuzzyTime.defaultOptions, 
                date=parseDate(timeValue),
                delta=parseInt(((new Date()).getTime()-date.getTime())/1000),
                relative=options.relativeTime,
                cutoff=+relative===relative ? relative*60*60 : Infinity;

            if (relative===false || delta>cutoff)
            return formatTime(date, options)+' '+formatDate(date, options);

            if (delta<60) return 'menos de um minuto atrás';
            var minutes=parseInt(delta/60 +0.5);
            if (minutes <= 1) return 'há ± um minuto';
            var hours=parseInt(minutes/60 +0.5);
            if (hours<1) return minutes+' minutos atrás';
            if (hours==1) return 'há ± uma hora';
            var days=parseInt(hours/24 +0.5);
            if (days<1) return hours+' horas atrás';
            if (days==1) return formatTime(date, options)+' ontem';
            var weeks=parseInt(days/7 +0.5);
            if (weeks<2) return formatTime(date, options)+' '+days+' dias atrás';
            var months=parseInt(weeks/4.34812141 +0.5);
            if (months<2) return weeks+' semanas atrás';
            var years=parseInt(months/12 +0.5);
            if (years<2) return months+' meses atrás';
            return years+' anos atrás';
        }

        function parseDate (str) {
            var v=str.replace(/[T\+]/g,' ').split(' ');
            return new Date(Date.parse(v[0] + " " + v[1] + " UTC"));
        }

        function formatTime (date, options) {
            var h=date.getHours(), m=''+date.getMinutes(), am=options.amPm;
            return (h>12 ? h-12 : h)+':'+(m.length==1 ? '0' : '' )+m+' '+(h<12 ? am[0] : am[1]);
        }

        function formatDate (date, options) {
            var mon=options.monthNames[date.getMonth()],
                day=date.getDate(),
                year=date.getFullYear(),
                thisyear=(new Date()).getFullYear(),
                suf=options.ordinalSuffix(day);

            return mon+' '+day+suf+(thisyear!=year ? ', '+year : '');
        }

        return fuzzyTime;

        }());
        
        $(document).ready(function() {
//            $('.des-result').click(function(){
//               $('.view-posts').fadeIn('fast');
//            });

            $('.btn-about').click(function(){
                $('.view-about').fadeIn('fast');
            });
            $('.view-about .fechar').click(function(){
                $('.view-about').fadeOut('fast');
            });
        });
    </script>
    
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35549778-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
        <div id="fb-root"></div>
        <script type="text/javascript">
            var isLogged = false;
            var accessToken = '';
            var uid = '';
            var flag = true;
            window.fbAsyncInit = function() {
                FB.init({appId: '291320284303270', status: true, cookie: true, xfbml: true});
 
                /* All the events registered */
                FB.Event.subscribe('auth.login', function(response) {
                    isLogged = true;
                    appIni(response);
                    // do something with response                    
                });
                FB.Event.subscribe('auth.logout', function(response) {
                    // do something with response

                });
 
                FB.getLoginStatus(function(response) {   
                    if(!isLogged){
                        appIni(response);                                           
                    }
                });
            };
            (function() {
                var e = document.createElement('script');
                e.type = 'text/javascript';
                e.src = document.location.protocol +
                    '//connect.facebook.net/pt_BR/all.js';
                e.async = true;
                document.getElementById('fb-root').appendChild(e);
            }());
 
            function login(){
                FB.api('/me', function(response) {
                    document.getElementById('info').innerHTML = response.name + " succsessfully logged in!";
                });
            }
            
            function appIni(response){
                if (response.status === 'connected') {
                    $('.msg-login').css('display', 'none');
                    $('.load').fadeIn('fast');
                    loadProfile();                   
                    verMural();
                    uid = response.authResponse.userID;
                    accessToken = response.authResponse.accessToken;
                } else if (response.status === 'not_authorized') {
                    $('.msg-app').fadeIn('fast');                        
                } else {
                    $('.msg-login').fadeIn('fast');
                }
            }
            
            function verMural(){
            
                FB.api('/me/home',  function(response) {                    
                    if(response.data[6].story){                        
                        //response.data[6].story = 'Lorem Ipsum não foi Encontrada is simply dummy text of Jenifer Carolina de Oliveira Ciara the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.';
                        response.data[6].story = ' Alexandre Felisberto de Almeida está desaparecido';
                    }else{
                        if(response.data[6].message){
                            //response.data[6].message  = 'Lorem não foi Encontrada Ipsum is simply dummy text of Jenifer Carolina de Oliveira Ciara the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.';
                            response.data[6].message  = ' Alexandre Felisberto de Almeida está desaparecido';
                        }
                    }
                    
                    for(var i in response.data){  
                        
                        var post = response.data[i];
                        var html;
                        html = '<div id="' + post.id + '" class="item">';
                        html += '<img width="28" class="picture" src="http://graph.facebook.com.br/' + post.from.id + '/picture">';
                        if(post.icon){
                            html += '<img class="icon" src="' + post.icon + '" />';
                        }
                        html += '<p><a class="name" target="_blank" href="http://www.facebook.com.br/' + post.from.id + '">' + post.from.name + '</a></p>';
                        html += '<p><label class="date">' + fuzzyFacebookTime(post.created_time.replace(/-/g,'/')) + '</label></p>';
                        html += '<p class="clear"></p>'; 
                        var picture = '';
                        if(post.picture){
                            picture = '<a class="msg-picture" target="_blank" href="' + post.link + '"><img width="60" src="' + post.picture + '" /></a>';
                        }
                        
                        if(post.message){
                            html += '<p class="story">' + picture + post.message + '<div class="clear"></div></p>';                        
                        }else{                        
                            if(post.story){
                                html += '<p class="story">' + picture + post.story + '<div class="clear"></div></p>';                        
                            }
                        }
                        
                        if(post.caption){                                
                            if(existsIn(post.caption)){
                                //totalOcorrencia++;
                            }
                        }
                        
                        
                        html += '</div>';
                        $('#mural .load').css('display', 'none');
                        $('#mural #box-scroll').append(html);                           
                     }
                     $('.des-search').fadeIn('slow');                                          
                     var totalOcorrencia = search(response.data);
                     $('.des-search').css('display', 'none');

                     if(totalOcorrencia == 0){
                        $('.des-result').html('Sem postagens de pessoas desaparecidas no mural');
                     }else{
                        var plural = '';
                        if(totalOcorrencia > 1){
                            plural = 's';
                        }                        
                        $('.des-result').html('<strong>' + totalOcorrencia + '</strong> ocorrência' + plural + ' de pessoa' + plural + ' desaparecida' + plural);
                     }
                    $('.des-result').fadeIn('slow');    
                    
                    
                     
                });
            }

            function searchDataInVirtuoso(str, postId){        
                var query = '';                
                
                str = remove_stopwords(str);
                str = filtro_nome_proprio(str);
                
//                var nomes = str.split(' ');
//                
//                for(i=0; i < nomes.length; i++){
//                    if(nomes[i] == '' || nomes[i] == ' ') continue;
//                    if(i != 0) query += ' || ';
//                    query += 'regex(?nome, "' + nomes[i] + '", "i")';
//                }
                
                $.ajax({                        
                    url: 'http://172.18.10.52/index.php/buscar/ajax_search_name',
                    data: {texto: str},
                    dataType: 'json',
                    success: function(data) {                        
                        $('#' + postId).css('background', '#F7F1AF');
                        $('#' + postId).css('border-left', '3px solid #F7D600');
                        
                        if(data.error == 0){
                            if(data.size == 0){
                                $('#' + postId + ' .status').html('Nenhuma informação encontrada');
                            }else{
                                $('#' + postId + ' .status').html('<a target="_blank" href="' + data.link + '">' + data.status + '</a>');
                            }
                            
                        }else{
                            $('#' + postId + ' .status').html('Ocorreu um erro.');
                        }                        
                    },
                    done: function(data){                        
                    }
                });
            }
            
            function loadProfile(){
                FB.api('/me', function(response) {
                    var html;
                    html = '<img width="45" class="picture" src="http://graph.facebook.com.br/'+response.id+'/picture" />';
                    html += '<p><a class="name" target="_blank" href="http://www.facebook.com.br/' + response.id + '">' + response.name + '</a></p>';
                    $('#info').html(html);
                });
            }

            function existsIn(str){
                var ocorrencias = new Array("desapare", "Desapare", "encontra", "Encontra");
                for(var i in ocorrencias){
                    if(str.search(ocorrencias[i]) != -1){
                        return true;
                    }
                }                
            }
            
            function search(res){
                var totalOcorrencia = 0;
                for(var i in res){
                    var post = res[i];
                    var found = false;
                    
//                    if(flag){
//                        totalOcorrencia++;
//                        echoFeed(post);
//                        flag = false;
//                    }
                    
                    if(post.message){                        
                        if(existsIn(post.message)){
                            if(!found){
                                found = true;
                                totalOcorrencia++;
                                echoFeed(post);
                            }
                        }
                    }else{                        
                        if(post.story){                            
                            if(existsIn(post.story)){
                                if(!found){
                                    found = true;
                                    totalOcorrencia++;
                                    echoFeed(post);
                                }
                            }
                        }
                    }
                    
                    if(post.caption){                                
                        if(existsIn(post.caption)){
                            if(!found){
                                found = true;
                                totalOcorrencia++;
                                echoFeed(post);
                            }                         
                        }
                    }
                    
                }
                return totalOcorrencia;
            }
            
            function echoFeed(post){                
                var strAux = '';
                
                html = '<div id="' + post.id + '" class="item">';
                html += '<img width="28" class="picture" src="http://graph.facebook.com.br/' + post.from.id + '/picture">';
                if(post.icon){
                    html += '<img class="icon" src="' + post.icon + '" />';
                }
                html += '<p><a class="name" target="_blank" href="http://www.facebook.com.br/' + post.from.id + '">' + post.from.name + '</a></p>';
                html += '<p><label class="date">' + fuzzyFacebookTime(post.created_time.replace(/-/g,'/')) + '</label></p>';
                html += '<p class="clear"></p>'; 
                var picture = '';
                if(post.picture){
                    picture = '<a class="msg-picture" target="_blank" href="' + post.link + '"><img width="60" src="' + post.picture + '" /></a>';
                }

                if(post.message){
                    html += '<p class="story">' + picture + post.message + '<div class="clear"></div></p>';                                            
                    strAux += post.message;
                }else{                        
                    if(post.story){
                        html += '<p class="story">' + picture + post.story + '<div class="clear"></div></p>';                                                
                        strAux += post.story;
                    }
                }
                html += '<div class="info-result"></div>';
                html += '</div>';
                strAux = clearStr(strAux);
                $('#' + post.id).append('<span class="status"><div class="info" postid="' + post.id + '">'+strAux+'</div><img src="images/ajax-loader.gif" />Situação: xxxx</span>');
                searchDataInVirtuoso(strAux, post.id);                        
                
                //$('.view-posts .content').append(html);
                
//                $.ajax({
//                    url: 'in-data.php?uid='+uid+'&post_id='+post.id+'&token='+accessToken,
//                    context: document.body
//                }).done(function(data) { 
//                    var info = data.split("|||");
//                    $('#'+info[0]).children('.info-result').html(info[1]);
//                });                
            }
            
            function replaceAll(string, token, newtoken) {
                while (string.indexOf(token) != -1) {
                        string = string.replace(token, newtoken);
                }
                return string;
            }
            
            function clearStr(str){
                str = replaceAll(str, "?"," ");
                str = replaceAll(str, "!"," ");
                str = replaceAll(str, ","," ");
                str = replaceAll(str, "."," ");
                str = replaceAll(str, "→"," ");
                str = replaceAll(str, "-"," ");
                str = replaceAll(str, ":"," ");
                str = replaceAll(str, "/"," ");
                str = replaceAll(str, "'"," ");
                str = replaceAll(str, "+"," ");
                str = replaceAll(str, "*"," ");
                str = replaceAll(str, "("," ");
                str = replaceAll(str, ")"," ");
                str = replaceAll(str, "'"," ");
                str = replaceAll(str, '"'," ");
                str = replaceAll(str, '['," ");
                str = replaceAll(str, ']'," ");
                str = replaceAll(str, "  "," ");
                str = replaceAll(str, "   "," ");
                return str;                
            }
            
            function remove_stopwords(str){
                var stopwords = new Array('de','a','o','e','do','da', 'em', 'um', 'para', 'é', 'com', 'não', 'uma', 'os', 'no', 'se', 'na', 'por', 'mais', 'as', 'dos', 'como', 'mas', 'foi', 'ao', 'ele', 'das', 'tem', 'à', 'seu', 'sua', 'ou', 'ser', 'quando', 'muito', 'há', 'nos', 'já', 'está', 'eu', 'também', 'só', 'pelo', 'pela', 'até', 'isso', 'ela', 'entre', 'era', 'depois', 'sem', 'mesmo', 'aos', 'ter', 'seus', 'quem', 'nas', 'me', 'esse', 'eles', 'estão', 'você', 'tinha', 'foram', 'essa', 'num', 'nem', 'suas', 'meu', 'às', 'minha', 'têm', 'numa', 'pelos', 'elas', 'havia', 'seja', 'qual', 'será', 'nós', 'tenho', 'lhe', 'deles', 'essas', 'esses', 'pelas', 'este', 'fosse', 'dele', 'tu', 'te', 'vocês', 'vos', 'lhes', 'meus', 'minhas', 'teu', 'tua', 'teus', 'tuas', 'nosso', 'nossa', 'nossos', 'nossas', 'dela', 'delas', 'esta', 'estes', 'estas', 'aquele', 'aquela', 'aqueles', 'aquelas', 'isto', 'aquilo', 'estou', 'está', 'estamos', 'estão', 'estive', 'esteve', 'estivemos', 'estiveram', 'estava', 'estávamos', 'estavam', 'estivera', 'estivéramos', 'esteja', 'estejamos', 'estejam', 'estivesse', 'estivéssemos', 'estivessem', 'estiver', 'estivermos', 'estiverem', 'hei', 'há', 'havemos', 'hão', 'houve', 'houvemos', 'houveram', 'houvera', 'houvéramos', 'haja', 'hajamos', 'hajam', 'houvesse', 'houvéssemos', 'houvessem', 'houver', 'houvermos', 'houverem', 'houverei', 'houverá', 'houveremos', 'houverão', 'houveria', 'houveríamos', 'houveriam', 'sou', 'somos', 'são', 'era', 'éramos', 'eram', 'fui', 'foi', 'fomos', 'foram', 'fora', 'fôramos', 'seja', 'sejamos', 'sejam', 'fosse', 'fôssemos', 'fossem', 'for', 'formos', 'forem', 'serei', 'será', 'seremos', 'serão', 'seria', 'seríamos', 'seriam', 'tenho', 'tem', 'temos', 'tém', 'tinha', 'tínhamos', 'tinham', 'tive', 'teve', 'tivemos', 'tiveram', 'tivera', 'tivéramos', 'tenha', 'tenhamos', 'tenham', 'tivesse', 'tivéssemos', 'tivessem', 'tiver', 'tivermos', 'tiverem', 'terei', 'terá', 'teremos', 'terão', 'teria', 'teríamos', 'teriam');
                var segmentos = str.split(' ');
                var newStr = '';                
                for(var i = 0; i < segmentos.length; i++){
                    if(jQuery.inArray(segmentos[i].toLowerCase(), stopwords) == -1){
                        newStr += segmentos[i] + ' ';
                    }
                }                                                
                return newStr;
            }
            
            function remove_acento_letra(letra) {
                var str_acento = "áàãâäéèêëíìîïóòõôöúùûüçÁÀÃÂÄÉÈÊËÍÌÎÏÓÒÕÖÔÚÙÛÜÇ";
                var str_sem_acento = "aaaaaeeeeiiiiooooouuuucAAAAAEEEEIIIIOOOOOUUUUC";
                var nova = "";
                
                if (str_acento.indexOf(letra) != -1) {
                    nova += str_sem_acento.substr(str_acento.search(letra.substr(0,1)),1);
                } else {
                    nova+=letra.substr(0,1);
                }
                
                return nova;
            }
            
            function filtro_nome_proprio(str){
                var segmentos = str.split(' ');
                var iniciais = new Array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Z', 'Y');
                var newStr = '';
                for(var i = 0; i < segmentos.length; i++){
                    var letra = remove_acento_letra(segmentos[i].charAt(0));                    
                    if(jQuery.inArray(letra, iniciais) != -1){
                        newStr += segmentos[i] + ' ';
                    }
                }
                return newStr;
            }
        </script> 
<div class="all">
    <div id="wrap">
        <div class="view-about">
            <div class="content">
                <div class="fechar">Voltar para o mural</div>
                <p>
                    <img class="logo-ufjf" src="images/logo-ufjf.png" />
                    Este é um protótipo originado de um projeto de monografia da Universidade Federal de Juiz de Fora desenvolvido por: 
                    <br />Adriano Rodrigues Delvoux Mattos
                    <br />Jairo Franscisco de Souza 
                    <br />
                    <a target="_blank" href="http://172.18.10.52">Clique aqui</a> e visite nosso site.
                </p>
                
            </div>                
        </div>
        <div class="header">
            <div class="relative-position">
                <img class="btn-about" src="images/next-icon.png" />
                <span class="btn-login"><fb:login-button autologoutlink="true" perms="read_stream,publish_stream"></fb:login-button></span>
                <span class="des-search"><img width="12" src="images/load.gif" /> Buscando dados de pessoas desaparecidas...</span>
                <span class="des-result"></span>
                <div id="info"></div>
            </div>
        </div>
        
        <div id="mural">
            <div id="box-scroll" class="scroll-pane">
                <div class="msg-login">
                    Você precisa está logado no Facebook para acessar o aplicativo. Clique no botão Entrar logo acima.
                </div>
                <div class="msg-app">
                    Você precisa aceitar o aplicativo no Facebook para começar a usá-lo.
                </div>
                <div class="load">
                    <img src="images/load-facebook.gif" /> Carregando atividades do mural...
                </div>
            </div>
            
        </div>
</div><!-- End all -->        



</body>
</html>