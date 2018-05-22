<?php $this->load->view('tema/header'); ?>

<h2><?php if(!empty($title)) echo '» '.$title; ?></h2>

<div class="form_faleconosco">
    <?php
        if(isset($msg)){
            echo '<div class="status-msg';
            if($msg['send']) echo ' success'; else echo ' error';
            echo '">' . $msg['text'] . '</div>';
        }
    ?>
    <?php echo form_open(); ?>
        <div class="field">
            <label><span>Nome:</span></label>
            <input class="inputForm" type="text" name="nome" size="80" />
        </div>
        
        <div class="field">
            <label><span>Email:</span></label>
            <input class="inputForm" type="text" name="email" size="80" />
        </div>

        <div class="field">
            <label><span>Telefone:</span></label>
            <input id="telefone" class="inputForm" type="text" name="telefone" size="15" />
        </div>

        <div class="field">
            <label><span>Assunto:</span></label>
            <input class="inputForm" type="text" name="assunto" size="60" /><label>
        </div>

        <div class="field">
            <label><span>Mensagem:</span></label>
            <textarea class="inputTxtForm" name="mensagem" rows="6" cols="70"></textarea>
        </div>
        
        <input class="btn-submit" type="submit" value="Enviar" />
    </form>
</div>

<?php $this->load->view('tema/footer'); ?>