<?php $this->load->view('tema/header', array('title'=>$title, 'breadcrumbs'=>$breadcrumbs)); ?>

<h2>Extesão para Firefox</h2>

<div class="text-format">
    
<h3>O que é?</h3>
<p>Esta é uma ferramenta simples criada para exemplificar a criação de aplicações capazes de manipular dados ligados e apresentar resultados que podem ser muito úteis para o usuário.</p>
<p>A aplicação é uma extensão compatível com o navegador Mozilla Firefox. Mais informações sobre como que é uma extensão e como instalar <a href="http://br.mozdev.org/firefox/plugin" target="_blank">clique aqui</a>.</p>

<h3>Como obter?</h3>
<p>A ferramenta pode ser adquirida <a target="_blank" href="http://desaparecidos.ice.ufjf.br/plugin/projeto-desaparecidos-ufjf_1.0.xpi">clicando aqui</a>.</p>

<h3>Como utilizar?</h3>
<p>Como o objetivo do plugin é ajudar a identificar e-mails falsos de pessoas desaparecidas vamos começar com um exemplo.</p>
<p>Temos um exemplo de e-mail recebido de uma criança desaparecida. Veja que o remetente pede para repassarmos o e-mail. Mas como saber rapidamente se é uma mensagem verdadeira? Ou se aquela criança já foi encontrada? <br />Vamos tentar descobrir isso utilizando a ferramenta.</p>

<img class="align-center" src="<?php echo base_url('images/manual') ?>/tela_1.jpg" />

<p>Vamos fazer uma busca pelo nome da criança. Selecione o nome e clique no botão esquerdo do mouse (veja o exemploo abaixo). Na caixa que irá aparecer clique em <i>"Buscar desaparecido por nome"</i>.</p>

<img class="align-center" src="<?php echo base_url('images/manual') ?>/tela_2.jpg" />

<p>Em seguida o plugin é acionado e uma caixa com informações relacionadas a sua busca aparece. Caso exista alguma criança na base de dados com o nome procurado ela aparecerá aqui. Clique em ver detalhes para saber mais informações.</p>

<img class="align-center" src="<?php echo base_url('images/manual') ?>/tela_3.jpg" />

<p>Na área abaixo é possível obter as informações existentes sobre a pessoa desaparecida, inclusive a fonte de onde os dados foram fornecidos.</p>

<img class="align-center" src="<?php echo base_url('images/manual') ?>/tela_4.jpg" />

<p>Veja que a criança já foi encontrada e não é necessário repassar o e-mail.</p>
<p>Em poucas etapas conseguimos evitar que outras pessoas recebessem este spam.</p>
</div>

<h3>Considerações finais</h3>

<p>Esta ferramenta é apenas uma versão inicial. Aguarde que muitas outras funcionalidades serão agregadas ao plugin.</p>

<?php $this->load->view('tema/footer'); ?>