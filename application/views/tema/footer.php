    </div><!-- END box-content -->
    <div class="menu-lat">
        <h3>» Menu</h3>
        <ul>
            <li><a title="Lista de desaparecidos" href="<?php echo site_url() ?>">Buscar desaparecidos</a></li>
            <li><a title="Lista de desaparecidos" href="<?php echo site_url('desaparecido/lista') ?>">Lista de desaparecidos</a></li>
            <li><a title="Extesão para Firefox" href="<?php echo site_url('plugin') ?>">Extesão para Firefox</a></li>
            <li><a title="Aplicação social" href="<?php echo site_url('aplicacao') ?>">Aplicação social</a></li>
            <li><a title="Consulta Sparql" href="<?php echo site_url('sparql') ?>">Consulta Sparql</a></li>
        </ul>
        <h3>» Links úteis</h3>
        <ul>
            <li><a title="Virtuoso Opensource" href="http://virtuoso.openlinksw.com/">Virtuoso Opensource</a></li>
        </ul>
    </div>
    </div>
    <div class="clear auto-heigh"></div>
</div>

<div id="footer">
	<div class="box">
    	<div class="center-layout">
            <div class="menu-bottom">
                <a title="Página principal" href="<?php echo site_url(); ?>">Página principal</a> |
                <a title="Sobre o projeto" href="<?php echo site_url(); ?>/sobre">Sobre o projeto</a> |
                <a title="Colaboradores" href="<?php echo site_url(); ?>/colaboradores">Colaboradores</a> |
                <a title="Fale conosco" href="<?php echo site_url(); ?>/fale_conosco">Fale conosco</a>
            </div>
            <img class="logos" src="<?php echo base_url('images'); ?>/footer.png" />
		</div>
    </div>
    <div class="desenvolvimento">
    	<div class="center-layout">
            <div class="copyR">© Projeto Desaparecidos - UFJF</div>
        </div>
    </div>
</div>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32689418-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
