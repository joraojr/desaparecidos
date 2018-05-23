<?php
/*
 * Nao está funcionando
 *
 * */
error_reporting(E_ALL);
include("atualizacaoPrincipal.php");
include("../simple_html_dom/simple_html_dom.php");

$url = "http://200.144.31.45/desaparecidos/";
$html = file_get_html($url);

function getPage($id) {
    date_default_timezone_set('America/Sao_Paulo');
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
    $headers = array(
    'Accept' => ' */*',
    'Accept-Encoding' => 'gzip, deflate',
    'Accept-Language' => 'pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
    'Cache-Control' => 'no-cache',
    'Connection' => 'keep-alive',
    'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
    'Host' => '200.144.31.45',
    'Origin' => 'http://200.144.31.45',
    'Referer' => 'http://200.144.31.45/desaparecidos/',
    'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36',
    'X-MicrosoftAjax' => 'Delta=true',
    'X-Requested-With' => 'XMLHttpRequest'
    );

    $postData = array(
        'Toolkitscriptmanager1' => "UpNumeroPagina|link4",
        'Toolkitscriptmanager1_HiddenField' =>';;AjaxControlToolkit, Version=3.5.404
        12.0, Culture=neutral, PublicKeyToken=28f01b0e84b6d53e:en-US:1547e793-5b7
        e-48fe-8490-03a375b13a33:de1feab2:f9cec9bc:35576c48:a67c2700:f2c8e708:8613
        aea7:3202a5a2:ab09e3fe:87104b7c:be6fb298;',
        'txtNomeFiltro' =>'',
        'waTxtNomeFiltro_ClientState' => '',
//        '__EVENTTARGET' => 'link4',
//        '__EVENTARGUMENT' => '',
//        '__VIEWSTATE' => '/wEPDwUKMTkxMzg5MDY1MA8WFh4KbGJsQ0lkYWRlc2UeBHBhZ2UCZB4PbGJsQ0NvckRvQ2FiZWxvZR4NbGJsQ0NvckRhUGVsZWUeDXR4dE5vbWVGaWx0cm9lHghsYmxDU2V4b2UeCmxibENBbHR1cmFlHgtsYmxDQ2lkYWRlc2UeD2xibENDb3JEb3NPbGhvc2UeC3ZpZXdzcGFnaW5nAgceBXBhZ2VzAmQWAgIDD2QWBgIJDxYCHgdFbmFibGVkaGQCCw9kFgJmD2QWAgIBDw8WAh4EVGV4dAUDOTk1ZGQCDQ9kFgJmD2QWAgIBD2QWCmYPZBYCAhkPZBYCAgMPDxYCHghJbWFnZVVybAVASW1hZ2VXYXRlcm1hcmsuYXNweD9pZHBob3RvPTZkMjc4MzAzLTE1ZWItNGRkNi1iMGIyLWE3NzIzYWU1NDU4OGRkAgEPZBYCAhkPZBYCAgMPDxYCHw0FQEltYWdlV2F0ZXJtYXJrLmFzcHg/aWRwaG90bz04MTE3YmJhZC02MjJhLTRlOWQtYmNlZS03ZjQ4Y2JlN2Y2OWRkZAICD2QWAgIZD2QWAgIDDw8WAh8NBUBJbWFnZVdhdGVybWFyay5hc3B4P2lkcGhvdG89NTBlYmRiMGYtYTExMC00YWUyLWE1ZjItYzQyODlmMjYxN2U1ZGQCAw9kFgICGQ9kFgICAw8PFgIfDQVASW1hZ2VXYXRlcm1hcmsuYXNweD9pZHBob3RvPTcxYTEyYmEyLWI3ZTItNGIzNC05NmUyLWQ5NDAxYjc1NzcyZGRkAgQPZBYCAhkPZBYCAgMPDxYCHw0FQEltYWdlV2F0ZXJtYXJrLmFzcHg/aWRwaG90bz0xZGNlYjE3ZS02ZTRiLTRmNDktYWQxMS04ZThkMGU5NTEwODhkZBgBBR5fX0NvbnRyb2xzUmVxdWlyZVBvc3RCYWNrS2V5X18WBQUOY3RsMzEkaW1nQ2xvc2UFDmN0bDMyJGltZ0Nsb3NlBQ5jdGwzMyRpbWdDbG9zZQUOY3RsMzQkaW1nQ2xvc2UFDmN0bDM1JGltZ0Nsb3NlU8nd/kJgHEhomN8yg/nQFHJTTdSHzsr0XPYdHKpm968=',
//        '__VIEWSTATEGENERATOR' => 'C4D27F4E',
//        '__EVENTVALIDATION' => '/wEdACY4E8GRA3EPMQF66wHOb05AFpB1Lsj4nnY1qBe/fPyAlpCzSd//5pRpIbIB5hRq4yW01JZNNcxBZjB7HPXbxevmfsbwyviVMPCqFPF+OgWkqZMVsNG5eBgrnrcPeZOH3eqIrcL+wrIl7sgMWWtJmJeNNVKsg1fa8xjNd+jk38DY7vLErmNy/5IFCaDWpsU1vH7m7w127Pkv23gFt3Ve+PCt8vga4fs88XPHVCuQjQo6N0DjTVbyDTmWtZfchdsrYA1KFxchsEHwJw5P4XLOwVqNthQc/kh/tRd5b/RDFharryQOKh5Cv+3IhhMrdNgaX+Wlk5ZQCB65uT7qKnt1D1XVc7SU68HZ/TlQEwCs4SMCu3hrLlwoIYZjt4j/EOAnlelexF4GVLoRlB2k9nVvWFZ9/RNZbtXOGZdc3QO5BuZM+3v4Imh6uXxRua3bha4lOjreFiaiWB6fH3y3aoKf2C9Z7euFHwmidBkeeJe9tvNbkfB29M4tHDoEHvwQAr3edITetG1CGpSSyu4BMW85SIEbNQfh0Cn1CoG7qJUWARExAZyhsJkfFe3AtHsku7F8MlqfC3X+R/STUx/4UbSqaEjitvdyS09utXREIsNzuxDGW4orZ9z0qRsScnuZ4eDLk7CXSfWe+meA6KqK1a8bFKE1NBR4u3C+4ElqZTkBISgJ5SgciffyXFMajwejXQYu9yb22Coyjw7tmuRHiYV0gW2pRB3YtIfA8kD/x1D0K456W+DCf/FJKRQbPdu/zvNm5Vq0h7jyRLje8Q9g+u6k3+wW9F5WPtmJ+M7dUocKAKIe289ia89UOc63ekEu32bGzcleAiToPErl4eZSsOrxg2bo' ,
        //'__ASYNCPOST' => 'true'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://200.144.31.45/desaparecidos/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookieDesaparecidos.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookieDesaparecidos.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $page = curl_exec($ch);


    curl_close($ch);

    return $page;
}

echo getPage(1);


/*for ($i = 1; $i <= 338; $i++) {
    $html_people = file_get_html($url);
    $data = array();
    $j = 0 ;
    while($html->find('div.DivPanelDesaparecidoDados b i span text',$j)->_[4] != NULL) {
        $data["Foto"] = $url . $html->find('div.DivPanelDesaparecidoFoto img', $j)->src;
        $data["Nome"] = $html->find('div.DivPanelDesaparecidoDados b i span text', $j)->_[4];
        foreach ($html->find('div.DivGeralDesaparecido') as $metadata) {
            $x = $metadata->find('div.DivPanelDesaparecidoDados span', 0)->id;
            $x = str_replace("Nome", "Caracter", $x);
            $alt = $metadata->find("div.DivPanelDesaparecidoDados span[id=$x]", 0)->plaintext;
            $alt = explode(":  ", $alt);
            $data[$alt[0]] = $alt[1];
            for ($k = 0; $k <= 6; $k++) {
                $data[$metadata->find('div.DivPanelDesaparecidoDados div.divPontilhada b label text', $k)->_[4]] =
                    $metadata->find('div.DivPanelDesaparecidoDados div.divPontilhada span text', $k)->_[4];

            }
        }
        var_dump($data);
        $j++;
    }



}*/

