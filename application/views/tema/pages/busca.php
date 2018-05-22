<?php $this->load->view('tema/header'); ?>

<h2>Buscar desaparecido</h2>
<div class="form-busca" style="position: relative;">
    <span style="float:right;margin-top:10px;margin-right:20px;"><b>Total de cadastros: </b><?php echo $total ?></span>
    <?php echo form_open(); ?>
    <div>Nome: <br /><input id="nome" type="text" name="nome" /></div>
    <div>Sexo: <br /><select id="sexo" name="sexo"><option value="">Selecione uma opção</option><option value="Masculino">Masculino</option><option value="Feminino">Feminino</option></select></div>
    <div>Idade: <br /><input id="idade" type="text" name="idade" /></div>
    <div>Data desaparecimento: <br /><input id="data-desaparecimento" type="text" name="data_desaparecimento" /></div>
    <!--<div>Situação: <br /><select id="situacao" name="situacao"><option value="">Selecione uma opção</option><option value="Encontrada">Encontrada</option><option value="Desaparecida">Desaparecida</option></select></div> -->
    <span class="btn-search" id="search">Buscar</span>
    </form>
</div>


<div id="result">
    <div class="load" style="display:none;">
        <label>Carregando dados...</label>
        <img src="<?php echo base_url('images'); ?>/ajax-loader.gif" />
    </div>
    <div class="content">
        
    </div>
</div>

<?php $this->load->view('tema/footer'); ?>
