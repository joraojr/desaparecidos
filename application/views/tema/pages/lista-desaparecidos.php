<?php $this->load->view('tema/header'); ?>

<?php
$abc = array("TODOS", "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","U","V","W","X","Y","Z");
?>

<h2><?php if(!empty($title)) echo $title; ?></h2>

<div class="alfabeto">
    <?php foreach($abc as $letra_atual): ?>
    <a <?php if($letra_atual == $letra) echo 'class="current"' ?> href="<?php echo site_url('desaparecido/lista/'.$letra_atual) ?>"><?php echo $letra_atual ?></a>
    <?php endforeach; ?>
</div>

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
        $count = 0;
        foreach ($desaparecidos as $value) {
            $count++;
            echo '<tr><td>'.($value->nome).'</td>';
            echo '<td>'.$value->sexo.'</td>';
            echo '<td>'.$value->situacao.'</td>';
            echo '<td><a href="'.  site_url("desaparecido/html").'/'.$value->id.'">Detalhe</td></tr>';
        }
        
        if(sizeof($desaparecidos) == 0){
            echo '<tr><td colspan="4" class="text-align-center">Nenhum registro encontrado.</td></tr>';
        }        
        
    ?>
    </tbody>
</table>

<?php
    if(sizeof($desaparecidos) != 0 && $count == 50){
        echo '<a style="text-decoration:none;background: none repeat scroll 0 0 #E5E5E5;border: 1px solid #CECECE;color: #4F5155;cursor: pointer;display:block;margin-bottom: 4px;margin-right: 2px;margin-top: 6px;padding: 3px 6px;" href="' . site_url('desaparecido/lista/'.$letra.'/?offset=' . $offset) . '">Ver mais resultados</a>';
    }
?>

<?php $this->load->view('tema/footer'); ?>