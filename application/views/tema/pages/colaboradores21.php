<?php $this->load->view('tema/header'); ?>

<h2><?php if(!empty($title)) echo $title; ?></h2>

<div class="box-colaboradores">

    <a target="_blank" href="http://www.criancadesaparecida.org"><img src="<?php echo base_url('images/colaboradores/' . 'logo-desaparecida-org.jpg') ?>" /></a>
    
    <div class="clear"></div>    
</div>



<?php $this->load->view('tema/footer'); ?>