<h2>Resultado da busca:</h2>

<table class="tabela">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Sexo</th>
            <th>Situação</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach ($desaparecidos as $value) {
            echo '<tr><td>'.($value->nome).'</td>';
            if( !empty($value->sexo))
                echo '<td>'.$value->sexo.'</td>';
            else
                echo '<td>Não Informado</td>';
            
            echo '<td>'.$value->situacao.'</td>';
            echo '<td><a href="'.  site_url("desaparecido/html").'/'.$value->id.'">Detalhe</td></tr>';
        }
        
        if(sizeof($desaparecidos) == 0){
            echo '<tr><td colspan="4" class="text-align-center">Nenhum registro encontrado.</td></tr>';
        }else{
            echo '<input style="background: none repeat scroll 0 0 #E5E5E5;border: 1px solid #CECECE;color: #4F5155;cursor: pointer;float: right;margin-bottom: 4px;margin-right: 2px;margin-top: -45px;padding: 3px 6px;" offset="' . $offset . '" type="button" class="mais-result" value="Ver mais resultados" />';        
        }
    ?>
    </tbody>
</table>