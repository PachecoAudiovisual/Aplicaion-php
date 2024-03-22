<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginControllers
{
    public static function login(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            //verificar datos antiguos
            //debuguear($auth);
            $alertas = $auth->varidarLogin();

            if (empty($alertas)) {
                // comprobas existencia de usuario
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    if( $usuario->comprobarPasswordAndVerificado($auth->password)){
                        // autentucar usuario
                        session_start();

                        $_SESSION['id']= $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario -> apellido ;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //REDIRECIONAMIENTO
                        if ($usuario->admin === "1") {
                            $_SESSION['admin']= $usuario->admin ?? null;
                            header('Location: /admin');
                      
                        }else  {
                           header('Location: /cita');
                        }
                      
                    }

                } else {
                    Usuario::setAlerta('error', 'Contraseña no valida');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas,


        ]);
    }

    public static function logout()
    {
      session_start();
      $_SESSION =[];
      header('location:/');
    }

    public static function olvide(Router $router)
    {
        $alertas=[];
        if ($_SERVER['REQUEST_METHOD']=== 'POST')   {
           $auth = new Usuario($_POST);
          $alertas= $auth->validarEmail();

          if (empty($alertas)) {
           $usuario = Usuario::where('email', $auth->email);

           if ($usuario && $usuario->confirmado === "1") {

            //TODO_ crear token nuevo
            $usuario->crearToken();
            $usuario->guardar();

            //enviar email
            $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
            $email->enviarInstrucciones();

            //alerta exito
            Usuario::setAlerta('exito','Revisa tu email');
            $alertas = Usuario::getAlertas();

           }else{
            Usuario::setAlerta('error','no existe o no está confirmado');
           }

          }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas'=>$alertas
        ]);
    }

    public static function recuperar(Router $router)
    {
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);
       
        //buscar usuario por su token

        $usuario = Usuario::where("token",$token);

        if (empty($usuario)) {
            Usuario::setAlerta('error','Token NO valido');
            $error = true;
        }

        if ($_SERVER['REQUEST_METHOD']==="POST") {
            // leer nuevo pawsword
            $password = new Usuario($_POST);
            $alertas = $password -> validarPassword();
            if (empty($alertas)) {
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado=$usuario->guardar();
                if ($resultado) {
                   header('location:/');
                };

            }

            
        }


        //debuguear($usuario);

        $alertas = Usuario::getAlertas();
        $router->render ( 'auth/recuperar-password',[
            'alertas'=>$alertas,
            'error'=> $error
        ]);
    }

    public static function crear(Router $router)
    {
        $usuario = new Usuario;

        //alertas vacias 
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();


            // revisar que alertas este vacio

            if (empty($alertas)) {

                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) {

                    $alertas = Usuario::getAlertas();
                } else {

                    //hashear el apssword
                    $usuario->hashPassword();

                    // GENERAR UN TOKE UNICO
                    $usuario->crearToken();

                    // ENVIAR EL MAIL
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);

                    $email->enviarConfirmacion();

                    // CREAR EL USUARIo
                    $resultado =  $usuario->guardar();

                    if ($resultado) {
                        header('Location: /mensaje');
                    }

                    // debuguear($usuario);
                }
            }
        }

        $router->render('auth/crear-cuenta', [

            'usuario' => $usuario,
            'alertas' => $alertas

        ]);
    }
    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }


    public static function confirmar(Router $router)
    {
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            # usuario vacio 
            Usuario::setAlerta('error', 'token no valido');
        } else {
            #usuauri modificado
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }
        //obtener alerta
        $alertas = Usuario::getAlertas();
        //renderizar vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas,


        ]);
    }
}
