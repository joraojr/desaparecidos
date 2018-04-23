<?php $this->load->view('tema/header'); ?>

<h2><?php if(!empty($title)) echo $title; ?></h2>

<div class="form">
    <!-- 
            ALTERADO
    <form method='GET' action='<?php url_virtuoso(true); ?>/sparql'>
    <input type="hidden" name="default-graph-uri" value="<?php get_graph(true); ?>" />
    -->
    <form method='GET' action='<?php url_allegrograph(true); ?>'>
    <div class="field">
        <label>Query:</label>
<textarea name='query'>
prefix foaf: <http://xmlns.com/foaf/0.1/>
select ?nome ?idade
Where{
?recurso foaf:name ?nome.
?recurso foaf:age ?idade
}
</textarea>
    </div>
    
    <div class="field">
        <label>Tipo de retorno:</label>
        <select name="format">
            <option value="auto">Auto</option>
            <option selected="selected" value="text/html">HTML</option>
            <option value="application/vnd.ms-excel">Spreadsheet</option>
            <option value="application/sparql-results+xml">XML</option>
            <option value="application/sparql-results+json">JSON</option>
            <option value="application/javascript">Javascript</option>
            <option value="text/plain">NTriples</option>
        <option value="application/rdf+xml">RDF/XML</option>
        </select>
    </div>

    <div class="submit">
        <input type="submit" value="Executar" />
    </div>
</form>
</div>

<?php $this->load->view('tema/footer'); ?>