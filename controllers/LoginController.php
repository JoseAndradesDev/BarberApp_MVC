<?php 

namespace Controllers;

use Model\Usuario;
use Util\Email;
use MVC\Router;


class LoginController{

    //inicio sesion
    public static function login(Router $router){
        $alertas=[];

        $auth = new Usuario;
    
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            
            $alertas=$auth->validarLogin();

            if(empty($alertas)){
                //comprobar que el usuario existe
                $usuario = Usuario::where('email', $auth->email);
               
                if($usuario){
                    //comprobar que coincide contraseña y usuario
                    if($usuario->comprobarPassAuth($auth->password)){
                        //autenticar el usuario
                        
                        crearSession();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['admin'] = $usuario->admin;
                        $_SESSION['login'] = true ?? false;
                       
                        
                        if( $_SESSION['admin']==1 &&  $_SESSION['login'] == true){
                            header('location: /admin');
                        }else{
                            header('location: /cita');
                        }
                        
                    }else{
                        Usuario::setAlerta('error', 'Contraseña incorrecta');
                    }

                }else{
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }
        
        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas'=> $alertas,
            'auth' => $auth
        ]);
    }


    //cerrar sesion
    public static function logout(){
        $_SESSION = [];
        header('Location: /');
    }


    //solicitar cambio de contraseña
    public static function olvidar(Router $router){
        $alertas=[];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);

                if($usuario && $usuario->confirmado==1){
                    //Generar token unico
                    $usuario->crearToken();
                    $usuario->guardar();

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito', 'Revisa tu email para restablecer tu contraseña');
                   
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/password-olvidar', [
            'alertas'=> $alertas
        ]);
    }


    //nueva contraseña
    public static function recuperar(Router $router){

        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        //Buscar usuario por su token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
            $error=true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //leer nuevo password y guardarlo

            $password = new Usuario($_POST);
            $alertas=$password->validarPassword();

            if(empty($alertas)){
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado=$usuario->guardar();
                if($resultado){
                    header('Location: /');
                }

            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/password-recuperar', [
            'alertas'=> $alertas,
            'error'=> $error
        ]);

    }


    //crear cuenta
    public static function crear(Router $router){
        $usuario = new Usuario;
        $alertas=[];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //revisar que no hay alertas
            if(empty($alertas)){
                //comprobar que el usuario no existe ya
                $resultado=$usuario->existeUsuario();

                if($resultado->num_rows){
                    //esta registrado
                    $alertas = Usuario::getAlertas();
                }else{
                    //no esta registrado
                    $usuario->hashPassword();

                    //Generar token unico
                    $usuario->crearToken();

                    //enviar el email de confirmacion
                    $email = new Email($usuario->nombre,$usuario->email,$usuario->token);
                    $email->enviarConfirmacion();

                    //Crear el usuario
                    $resultado=$usuario->guardar();
                    if($resultado){
                        header('location: /mensaje');
                    }

                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas'=> $alertas
        ] );
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router){
        $alertas=[];

        $token = s($_GET['token']);

        $usuario=Usuario::where('token', $token);

        if(empty($usuario)){
            //msj error
            Usuario::setAlerta('error', 'Error al confirmar');
        }else{
            $usuario->confirmado=1;
            $usuario->token='';
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            'alertas'=>$alertas
        ]);
    }


}