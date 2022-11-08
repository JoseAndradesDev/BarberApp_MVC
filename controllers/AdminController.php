<?php 

namespace Controllers;
use MVC\Router;
use Model\AdminCita;



class AdminController{
    public static function index( Router $router){
        isAdmin();
        
        $fecha = $_GET['fecha'] ??  date('Y-m-d');;
        $fechas = explode('-', $fecha);

        if(!checkdate( $fechas[1], $fechas[2], $fechas[0])){
            header('Location:/404');
        }

        //Consultar base de datos
        $consulta = "SELECT cita.id, cita.hora, CONCAT( usuario.nombre, ' ', usuario.apellido) as cliente,";
        $consulta .= " usuario.email, usuario.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM cita  ";
        $consulta .= " LEFT OUTER JOIN usuario ";
        $consulta .= " ON cita.usuarioId=usuario.id  ";
        $consulta .= " LEFT OUTER JOIN citaservicios ";
        $consulta .= " ON citaservicios.citaId=cita.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citaservicios.servicioId ";
        $consulta .= " WHERE fecha =  '${fecha}' ";


       
        $citas = AdminCita::SQL($consulta);


        //Mostrar vista
        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}

?>