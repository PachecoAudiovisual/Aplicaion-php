<?php

namespace Model;


class Usuario extends ActiveRecord
{
    // BASE DE DATOS 

    protected static $tabla = 'usuarios';
    protected static $columnasDB = [
        'id', 'nombre', 'apellido', 'email', 'password',
        'telefono', 'admin', 'confirmado', 'token'
    ];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    // MENSAJE VALIDACION

    public function validarNuevaCuenta()
    {
        if (!$this->nombre) {
            # code...
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if (!$this->apellido) {
            # code...
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }
        if (!$this->email) {
            # code...
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if (!$this->password) {
            # code...
            self::$alertas['error'][] = 'El password es obligatorio';
        }

        if (strlen($this->password) < 6) {
            # code...
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres no consecutivos';
        }

        return self::$alertas;
    }
    public function varidarLogin()
    {

        if (!$this->email) {
            # code...
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        if (!$this->password) {
            # code...
            self::$alertas['error'][] = 'El password es obligatorio';
        }

        return self::$alertas;
    }

    public function validarEmail()
    {
        if (!$this->email) {

            self::$alertas['error'][] = 'El email es obligatorio';
        }
        return self::$alertas;
    }


    public function validarPassword(){
        if (!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener como mínimo 6 caracteres';
            
        }
        return self::$alertas;
    }


    //REVISA SI USUARIO EXISTE
    //REVISA SI USUARIO EXISTE

    public function existeUsuario()
    {
        $query = " SELECT * FROM "  .  self::$tabla .  " WHERE email = '" . $this->email . "' LIMIT 1 ";



        $resultado = self::$db->query($query);

        if ($resultado->num_rows) {

            self::$alertas['error'][] = 'El usuario ya está registrado';
            # code...
        }

        return $resultado;
    }

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken()
    {
        $this->token = trim(uniqid());
    }


    public function  comprobarPasswordAndVerificado($password)
    {
        $resultado = password_verify($password, $this->password);

        if (!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Contraseña incorrecta o no verificado el correo electrónico.';
        } else {
            return true;
        }
    }
}
