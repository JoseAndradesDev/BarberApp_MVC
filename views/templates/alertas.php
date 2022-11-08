<?php
    foreach($alertas as $key => $tipo):
        foreach($tipo as $mensaje):
?>
    <div class="alerta <?php echo $key; ?>">
            <?php echo $mensaje; ?>
    </div>
<?php
        endforeach;
    endforeach;
?>