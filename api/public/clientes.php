<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/clientes.php');
require_once('../dashboard/correos.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cliente = new Clientes;
    $vali = new Validator;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0,'noventa'=>0, 'recaptcha' => 0, 'message' => null, 'exception' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['id_cliente'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset( $_SESSION['usuario'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['usuario'];
                } else {
                    $result['exception'] = 'Correo de cliente indefinido';
                }
                break;
            case 'logOut':
                if (isset($_SESSION['id_cliente'])) {
                    unset($_SESSION['id_cliente']);
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
                case 'changePassword':
                    $_POST = $cliente->validateForm($_POST);
                    if (!$cliente->setId($_SESSION['id_usuario'])) {
                        $result['exception'] = 'Usuario incorrecto';
                    } elseif (!$cliente->checkPassword($_POST['actual'])) {
                        $result['exception'] = 'Clave actual incorrecta';
                    } elseif ($_POST['nueva'] != $_POST['confirmar']) {
                        $result['exception'] = 'Claves nuevas diferentes';
                    } elseif (!$cliente->setClave($_POST['nueva'])) {
                        $result['exception'] = $cliente->getPasswordError();
                    } elseif ($cliente->changePassword()) {
                        $result['status'] = 1;
                        $result['message'] = 'Contraseña cambiada correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;    
                case 'checkToken':
                    $_POST = $cliente->validateForm($_POST);
                    if (!$cliente->setId($_SESSION['id_cliente'])) {
                        $result['exception'] = 'cliente incorrecto';
                    }elseif (!$cliente->checkToken($_POST['token'])) {
                        $result['exception'] = 'Token incorrecto';
                    }else {
                        $result['status'] = 1;
                        $result['message'] ='Token confirmado';
                        $_SESSION['token']=$cliente->getToken();
                    }
                    break;
                    case 'changePswd':
                        $_POST = $cliente->validateForm($_POST);
                        if (!$cliente->setId($_SESSION['id_usuario'])) {
                            $result['exception'] = 'Usuario incorrecto';
                        }elseif (!$cliente->checkPassword($_POST['actual'])) {
                            $result['exception'] = 'Clave actual incorrecta';
                        }elseif ($_POST['actual'] == $_POST['nueva']) {
                            $result['exception'] = 'La nueva clave no puede ser igual a la anterior';
                        } elseif ($_POST['nueva'] != $_POST['confirmar']) {
                            $result['exception'] = 'Claves nuevas diferentes';
                        } elseif (!$cliente->setClave($_POST['nueva'])) {
                            $result['exception'] = $cliente->getPasswordError();
                        } elseif ($cliente->changePassword()) {
                            $result['status'] = 1;
                            $result['message'] = 'Contraseña cambiada correctamente';
                            sendemail($cliente->getNombres(), $cliente->getCorreo(),'auntentificacion de inicio de sesion', 'alquien ha intentado iniciar sesion en su cuenta');
                            $result['message'] = 'Correo eviado';
                            $cliente->saveToken();
                        } else {
                            $result['exception'] = Database::getException();
                        }
                        break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el cliente no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'register':
                $_POST = $cliente->validateForm($_POST);
                //array de los campos a ser analisados for la foncion multihaystacks_stripos($haystacks,$needle)
                $origin = array($_POST['nombres'], $_POST['apellidos'], $_POST['usuario'], $_POST['correo']);
                //codigo del RECAPCHA que si el formulario tarda mucho tiempo en enviarse o por el contrario es inhumanamente rapido se llega a la conclucion que no es un humano
                $secretKey = '6LdBzLQUAAAAAL6oP4xpgMao-SmEkmRCpoLBLri-';
                $ip = $_SERVER['REMOTE_ADDR'];

                $data = array('secret' => $secretKey, 'response' => $_POST['g-recaptcha-response'], 'remoteip' => $ip);

                $options = array(
                    'http' => array('header'  => "Content-type: application/x-www-form-urlencoded\r\n", 'method' => 'POST', 'content' => http_build_query($data)),
                    'ssl' => array('verify_peer' => false, 'verify_peer_name' => false)
                );

                $url = 'https://www.google.com/recaptcha/api/siteverify';
                $context  = stream_context_create($options);
                $response = file_get_contents($url, false, $context);
                $captcha = json_decode($response, true);

                if (!$captcha['success']) {
                    $result['recaptcha'] = 1;
                    $result['exception'] = 'No eres un humano';
                } elseif (!$cliente->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$cliente->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$cliente->setUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$cliente->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$cliente->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecto';
                } elseif ($_POST['clave'] != $_POST['confirmar_clave']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$cliente->setClave($_POST['clave'])) {
                    $result['exception'] = $cliente->getPasswordError();
                } //llamando a la funcion en validator para asegurarnos que los datos de los campos no coincidan con la clave
                elseif (!$vali->multihaystacks_stripos($_POST['clave'],$origin)) {
                    $result['exception'] = 'La clave tiene que ser diferente al resto de informacion';
                } elseif ($cliente->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cliente registrado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'pswdReco':
                $_POST = $cliente->validateForm($_POST);
                if (!$cliente->checkEmail($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } else {
                    sendemail($cliente->getNombres(), $_POST['correo'], 'Recuperar contraseña',  'Alquien ha solicitado un cambio de contraseña');
                    $result['status'] = 1;
                    $result['message'] = 'Correo enviado';
                    $cliente->saveToken();
                }
                break;
                case 'forgotPassword':
                    $_POST = $cliente->validateForm($_POST);
                    /*se confirma que el token coincida con el de la base de datos y 
                    luego se procede con la asignacion de la nueva clave*/
                    if (!$cliente->checkToken($_POST['token'])) {
                        $result['exception'] = 'Token incorrecto';
                    }elseif ($_POST['nueva'] != $_POST['confirmar']) {
                        $result['exception'] = 'Claves nuevas diferentes';
                    } elseif (!$cliente->setClave($_POST['nueva'])) {
                        $result['exception'] = $cliente->getPasswordError();
                    } elseif ($cliente->forgetPassword()) {
                        $result['status'] = 1;
                        $result['message'] = 'Contraseña cambiada correctamente';
                        $cliente->deleteToken();
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
                    case 'logIn':
                        $_POST = $cliente->validateForm($_POST);
                        if (!$cliente->checkEmail($_POST['email'])) {
                            $result['exception'] = 'Correo o contraseña incorrectos';   
                        }/*si el numero de intentos es igual a  tres lanza una alerta luego un 
                        mensaje de que no puede acceder*/
                        elseif ($cliente->getIntentos() >=3) {
                                $result['exception'] = 'Limite de intentos alcanzado, tu cuenta ha sido bloqueda temporalmente';
                                $_SESSION['session']=0;
                                $cliente->bloqueoIntentos($_POST['email']);
                            }//luego de un dia la cuenta se desbloquea automaticamente
                            elseif($cliente->getFechaIntentos()>=1 or $cliente->getFechaIntentos()==null ){
                                if ($cliente->checkPassword($_POST['clave'])) {
                            /*luego de pasar 90 dias luego del ultimo cambio de clave 
                            le exige volverla a cambiar*/
                            if ( $cliente->getDiasClave()>90) {
                                $_SESSION['id_cliente'] = $cliente->getId();
                                $_SESSION['usuario'] = $cliente->getUsuario();
                                $_SESSION['correo_cliente'] = $cliente->getCorreo();
                                $result['exception'] = 'Tiene que cambiar su contraseña de inmdediato';
                                $result['noventa'] = 1;
                            }else{
                            /*si tiene 1 o 2 intentos fallidos, el conteo se reinia al poner
                             bien sus credenciales*/
                            $cliente->reinicioConteoIntentos($_POST['email']);
                            if(!$cliente->getEstado()){
                                $result['exception'] = 'Su cuenta ha sido baneada o borrada, porfavor comuniquese con adminstracion';
                            }else {
                            /*se envia al correo un codigo de 5 caracteres y lo guarda 
                            en la base de datos*/
                            if(sendemail($cliente->getNombres(),$_POST['email'],'Auntentificacion de inicio de sesion', 'Alguien ha intentado entrar a su cuenta')){
                            $result['status'] = 1;
                            $result['message'] = 'Correo eviado';
                            $cliente->saveToken();
                            $_SESSION['id_cliente'] = $cliente->getId();
                            $_SESSION['usuario'] = $cliente->getUsuario();
                            $_SESSION['correo_cliente'] = $_POST['email'];
                            }else {
                              $result['exception']= "El correo no se pudo enviar";
                            }
                            }
                        }
                        } else {
                            $result['exception'] = 'Correo o Contraseña incorectos';
                            $cliente->intentoFallido($_POST['email']);
                            
                        }}else{
                            $result['exception'] = 'Su cuenta ha sido bloqueada por 1 dia';  
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
