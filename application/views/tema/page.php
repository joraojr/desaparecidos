<?php $this->load->view('tema/header'); ?>

<h2><?php if(!empty($title)) echo '» '.$title; ?></h2>

<?php if(!empty($content)) echo $content; ?>

<?php $this->load->view('tema/footer'); ?>