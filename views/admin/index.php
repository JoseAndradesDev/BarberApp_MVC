<?php 
    include_once __DIR__ . '/../templates/barra.php'
?>

<div class="barra-servicios">
    <a class="btn-inicio " href="/admin">Ver Citas</a>
    <a class="btn-inicio " href="/servicios">Ver Servicios</a>
    <a class="btn-inicio " href="/servicios/crear">Crear Servicios</a>
</div>



<h1 class="nombre-pagina">Panel Adminstración</h1>


<h2>Buscar Citas</h2>

<div class="buscador">
    <form class="form">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input 
                type="date"
                id="fecha"
                name="fecha"
                value="<?php echo $fecha ?>"
            >
        </div>
    </form>



</div>

<?php 
    if(count($citas)===0){
        echo "<h3 class='msj-cita'>No hay citas este dia</h3>";
    }
?>

<div id="citas-admin">
    <ul class="citas">
        <?php 
        $idCita=0;
        
        foreach( $citas as $key => $cita){ 
            
            if($idCita !== $cita->id){ 
                $total=0;
            ?>
             
               

                <li>
                <h3 class="cabecera">Info Cliente</h3>
                    <p>ID: <span><?php echo $cita->id;  ?></p>
                    <p>Hora: <span><?php echo $cita->hora;  ?></p>
                    <p>Cliente: <span><?php echo $cita->cliente;  ?></p>
                    <p>Email: <span><?php echo $cita->email;  ?></p>
                    <p>Teléfono: <span><?php echo $cita->telefono;  ?></p>

                    <h3 class="">Servicios</h3>

                    <?php $idCita = $cita->id;
            }//fin if ?> 
                </li>
                <p class="sevicio"> <?php echo $cita->servicio . " " . $cita->precio."€"; ?> </p>
        
                <?php 
                $total+= $cita->precio;

                $actual = $cita->id;
                $prox = $citas[$key+1]->id ?? 0;

                if(last($actual, $prox)){ ?>
                    <p class="total">Total: <span> <?php echo $total."€"; ?> </span> </p>

                    <form action="/api/eliminar" method="POST"> 
                        <input type="hidden" name="id" value="<?php echo $cita->id?>">
                        <input type="submit" class="btn-eliminar" value="Eliminar">
                    </form>

                <?php } ?>
                
               

        <?php } //fin foreach ?> 
        
    </ul>
</div>

<?php 
    $script = "<script src='build/js/buscador.js'></script>"

?>