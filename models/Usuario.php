<?php

namespace Model;

class Usuario extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'usuario';
    protected static $columnasDB = ['id','nombre','apellido','telefono','email','admin','confirmado','token','password'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;
    public $admin;
    public $confirmado;
    public $token;
    public $password;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    //CREAR CUENTA  
    public function validarNuevaCuenta (){
        if(!$this->nombre){
            self::$alertas['error'][] = "El nombre es obligatorio";
        }
        if(!$this->apellido){
            self::$alertas['error'][] = "El apellido es obligatorio";
        }
        if(!$this->telefono){
            self::$alertas['error'][] = "El teléfono es obligatorio";
        }elseif(strlen($this->telefono)!=9){
            self::$alertas['error'][] = "El teléfono debe tener 9 digitos";
        }
        if(!$this->email){
            self::$alertas['error'][] = "El email es obligatorio";
        }
        if(!$this->password){
            self::$alertas['error'][] = "La contraseña es obligatoria";
        }elseif(strlen($this->password)<6){
            self::$alertas['error'][] = "La contraseña debe tener almenos 6 caracteres";
        }

        return self::$alertas;
    }

    //Revisar si ya existe la cuenta
    public function existeUsuario (){
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);
        
        if($resultado->num_rows){
            self::$alertas['error'][] = 'El usuario ya esta registrado';
        }
        
        return $resultado;
    }

    public function hashPassword (){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken (){
        $this->token = uniqid();
    }


    //LOGIN
    public function validarLogin (){
        if(!$this->email){
            self::$alertas['error'][]= 'El email es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][]= 'La contraseña es obligatoria';
        }elseif(strlen($this->password)<6){
            self::$alertas['error'][] = "La contraseña debe tener almenos 6 caracteres";
        }

        return self::$alertas;
    }

    public function comprobarPassAuth($password){

        $resultado = password_verify($password, $this->password);
        
        if($resultado==false || $this->confirmado===0  ){
            return false;
        }else{
            return true;
        }
      
    }


    //CONTRASEÑA OLVIDADA
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][]= 'El email es obligatorio';
        }
        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][]= 'La contraseña es obligatoria';
        }
        if(strlen($this->password)<6){
            self::$alertas['error'][] = "La contraseña debe tener almenos 6 caracteres";
        }
        return self::$alertas;
    }




}