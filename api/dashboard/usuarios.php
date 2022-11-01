<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/usuarios.php');
require_once('correos.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $usuario = new Usuarios;
    $vali = new Validator;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0,'noventa'=>0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['alias_usuario'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['alias_usuario'];
                } else {
                    $result['exception'] = 'Alias de usuario indefinido';
                }
                break;
            case 'logOut':
                if (isset($_SESSION['id_usuario'])) {
                    //unset para borrar solamente la variable id_usuario
                    unset($_SESSION['id_usuario']);
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
            case 'readProfile':
                if ($result['dataset'] = $usuario->readProfile()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'editProfile':
                $_POST = $usuario->validateForm($_POST);
                if (!$usuario->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif ($usuario->editProfile()) {
                    $result['status'] = 1;
                    $result['message'] = 'Perfil modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'changePassword':
                $_POST = $usuario->validateForm($_POST);
                if (!$usuario->setId($_SESSION['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->checkPassword($_POST['actual'])) {
                    $result['exception'] = 'Clave actual incorrecta';
                } elseif ($_POST['nueva'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves nuevas diferentes';
                } elseif (!$usuario->setClave($_POST['nueva'])) {
                    $result['exception'] = $usuario->getPasswordError();
                } elseif ($usuario->changePassword()) {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña cambiada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $usuario->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = $usuario->validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $usuario->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = $usuario->validateForm($_POST);
                //conjunto de datos a analizar por multihaystacks_stripos()
                $origin=array($_POST['nombres'],$_POST['apellidos'],$_POST['alias'],$_POST['correo'],$_POST['telefono']);
                if (!$usuario->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setAlias($_POST['alias'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$usuario->setClave($_POST['clave'])) {
                    $result['exception'] = $usuario->getPasswordError();
                } //comprobar que la clave sea diferente al resto de valores
                elseif ($vali->multihaystacks_stripos($origin,$_POST['clave'])) {
                    $result['exception'] = 'La clave tiene que ser diferente al resto de informacion';
                }elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $usuario->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'update':
                $_POST = $usuario->validateForm($_POST);
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif (!$usuario->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif ($usuario->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if ($_POST['id'] == $_SESSION['id_usuario']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                } elseif (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif ($usuario->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                case 'changePswd':
                    $_POST = $usuario->validateForm($_POST);
                    if (!$usuario->setId($_SESSION['id_usuario'])) {
                        $result['exception'] = 'Usuario incorrecto';
                    }elseif (!$usuario->checkPassword($_POST['actual'])) {
                        $result['exception'] = 'Clave actual incorrecta';
                    }elseif ($_POST['actual'] == $_POST['nueva']) {
                        $result['exception'] = 'La nueva clave no puede ser igual a la anterior';
                    } elseif ($_POST['nueva'] != $_POST['confirmar']) {
                        $result['exception'] = 'Claves nuevas diferentes';
                    } elseif (!$usuario->setClave($_POST['nueva'])) {
                        $result['exception'] = $usuario->getPasswordError();
                    } elseif ($usuario->changePassword()) {
                        $result['status'] = 1;
                        $result['message'] = 'Contraseña cambiada correctamente';
                        sendemail($usuario->getNombres(), $usuario->getCorreo(),'auntentificacion de inicio de sesion', 'alquien ha intentado iniciar sesion en su cuenta');
                        $result['message'] = 'Correo eviado';
                        $usuario->saveToken();
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
                case 'checkToken':
                    $_POST = $usuario->validateForm($_POST);
                    if (!$usuario->setId($_SESSION['id_usuario'])) {
                        $result['exception'] = 'Usuario incorrecto';
                    }elseif (!$usuario->checkToken($_POST['token'])) {
                        $result['exception'] = 'Token incorrecto';
                    }else {
                        $result['status'] = 1;
                        $result['message'] ='Token confirmado';
                        $_SESSION['token']=$usuario->getToken();
                    }
                    break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readUsers':
                if ($usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existe al menos un usuario registrado';
                } else {
                    $result['exception'] = 'No existen usuarios registrados';
                }
                break;
                /*linkeado con forgotPassword, password recovery,mejor conocido como pswdReco
                es el encargado de confirmar que el correo se encuentre en la base de datos
                para luego enviar enviar el token*/
                case 'pswdReco':
                    $_POST = $usuario->validateForm($_POST);
                    if (!$usuario->checkEmail($_POST['correo'])) {
                        $result['exception'] = 'Correo incorrecto';   
                    }else{
                        sendemail($usuario->getNombres(),$_POST['correo'],'recuperar contraseña',  'alquien ha solicitado un cambio de contraseña');
                        $result['status'] = 1;
                        $result['message'] ='Correo enviado';
                        $usuario->saveToken();
                    }
                    break;
            case 'register':
                /*se verifica que la base este vacia para poder funcionar de lo contrario
                 lanza un error*/
                if (!$usuario->readAll()) {
                    $_POST = $usuario->validateForm($_POST);
                    //conjunto de campos ser analizados por multihaystacks_stripos
                    $origin=array($_POST['nombres'],$_POST['apellidos'],$_POST['alias'],$_POST['correo'],$_POST['telefono']);
                    if (!$usuario->setNombres($_POST['nombres'])) {
                        $result['exception'] = 'Nombres incorrectos';
                    } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                        $result['exception'] = 'Apellidos incorrectos';
                    } elseif (!$usuario->setCorreo($_POST['correo'])) {
                        $result['exception'] = 'Correo incorrecto';
                    } elseif (!$usuario->setAlias($_POST['alias'])) {
                        $result['exception'] = 'Alias incorrecto';
                    } elseif ($_POST['clave'] != $_POST['confirmar']) {
                        $result['exception'] = 'Claves diferentes';
                    }elseif (!$usuario->setTelefono($_POST['telefono'])) {
                        $result['exception'] = 'Teléfono incorrecto';
                    } elseif (!$usuario->setClave($_POST['clave'])) {
                        $result['exception'] = $usuario->getPasswordError();
                    }/*funcion multihaystack_stripos que analiza si la clave contiene
                     informacion de los campos, si es asi lanza un mensaje*/
                    elseif ($vali->multihaystacks_stripos($origin,$_POST['clave'])) {
                        $result['exception'] = 'La clave tiene que ser diferente al resto de informacion';
                    }elseif ($usuario->registro()) {
                        $result['status'] = 1;
                        $result['message'] = 'Usuario registrado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                }else{
                    $result['exception'] = 'No puede registrarse dos veces';
                }
              
                break;
                case 'logIn':
                    $_POST = $usuario->validateForm($_POST);
                    if (!$usuario->checkUser($_POST['alias'])) {
                        $result['exception'] = 'Usuario o Contraseña incorrectos';   
                    }/*si el numero de intentos es igual a  tres lanza una alerta luego un 
                    mensaje de que no puede acceder*/
                    elseif ($usuario->getIntentos() >=3) {
                            $result['exception'] = 'Limite de intentos alcanzado, tu cuenta ha sido bloqueda temporalmente';
                            $_SESSION['session']=0;
                            $usuario->bloqueoIntentos($_POST['alias']);
                        }//luego de un dia la cuenta se desbloquea automaticamente
                        elseif($usuario->getFechaIntentos()>=1 or $usuario->getFechaIntentos()==null ){
                            if ($usuario->checkPassword($_POST['clave'])) {
                        /*luego de pasar 90 dias luego del ultimo cambio de clave 
                        le exige volverla a cambiar*/
                        if ( $usuario->getDiasClave()>90) {
                            $_SESSION['id_usuario'] = $usuario->getId();
                            $_SESSION['alias_usuario'] = $usuario->getAlias();
                            $result['exception'] = 'Tiene que cambiar su contraseña de inmdediato';
                            $result['noventa'] = 1;
                        }else{
                        /*si tiene 1 o 2 intentos fallidos, el conteo se reinia al poner
                         bien sus credenciales*/
                        $usuario->reinicioConteoIntentos($_POST['alias']);
                        /*se envia al correo un codigo de 5 caracteres y lo guarda 
                        en la base de datos*/
                        if(sendemail($usuario->getNombres(), $usuario->getCorreo(),'Auntentificacion de inicio de sesion', 'Alguien ha intentado entrar a su cuenta')){
                        $result['status'] = 1;
                        $result['message'] = 'Correo eviado';
                        $usuario->saveToken();
                        $_SESSION['id_usuario'] = $usuario->getId();
                        $_SESSION['alias_usuario'] = $usuario->getAlias();
                        }else {
                          $result['exception']= "El correo no se pudo enviar";
                        }
                        }
                    } else {
                        $result['exception'] = 'Usuario o Contraseña incorectos';
                        $usuario->intentoFallido($_POST['alias']);
                        
                    }}else{
                        $result['exception'] = 'Su cuenta ha sido bloqueada por 1 dia';  
                    }
                    break;
                    //es el encargado de la recuperacion de la clave
                    case 'forgotPassword':
                        $_POST = $usuario->validateForm($_POST);
                        /*se confirma que el token coincida con el de la base de datos y 
                        luego se procede con la asignacion de la nueva clave*/
                        if (!$usuario->checkToken($_POST['token'])) {
                            $result['exception'] = 'Token incorrecto';
                        }elseif ($_POST['nueva'] != $_POST['confirmar']) {
                            $result['exception'] = 'Claves nuevas diferentes';
                        } elseif (!$usuario->setClave($_POST['nueva'])) {
                            $result['exception'] = $usuario->getPasswordError();
                        } elseif ($usuario->forgetPassword()) {
                            $result['status'] = 1;
                            $result['message'] = 'Contraseña cambiada correctamente';
                            $usuario->deleteToken();
                        } else {
                            $result['exception'] = Database::getException();
                        }
                        break;
            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
