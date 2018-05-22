<?php $this->load->view('tema/header'); ?>

<?php
    $url = base_url();
    $app = 'appFacebook';
    if($url == 'http://172.18.10.52/'){
        $app = 'appLocal';
    }
?>

<script type="text/javascript">

function recarregar() {

    frames[0].location="<?php echo base_url() . $app ?>";
    blur();
    return false;

}

</script>


<h2><?php if(!empty($title)) echo $title; ?></h2>
<div class="box-app">
    <img src="<?php echo base_url() ?>/images/celular.png" />
    
    
    
    <iframe width="318" height="474" src="<?php echo base_url() . $app  ?>" border="0"></iframe>
    
    <img class="qrcode" src="<?php echo base_url() ?>/images/qrcode.png" />
    
    <img class="clique-carregar" src="<?php echo base_url() ?>/images/clique-carregar.png" />
    
    <a class="link-app" onclick="recarregar()" /></a>
</div>



<?php $this->load->view('tema/footer'); ?>