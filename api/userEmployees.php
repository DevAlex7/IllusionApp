<?php 
if (isset($_SERVER['HTTP_ORIGIN'])) {  
    header('Access-Control-Allow-Origin: *');   
    header('Access-Control-Allow-Credentials: true');  
    header('Access-Control-Max-Age: 86400');   
}  

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {  

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))  
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");  

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))  
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");  
}

    require_once('../backend/instance/instance.php');
    require_once('../helpers/validator.php');
    require_once('../backend/models/Employees.php');
    require_once('../helpers/select.php');

    if( isset($_GET['request']) && isset($_GET['action']) ){
        
        session_start();
        $result=array(
            'status'=> 0,
            'exception' => '',
            'userInformation'
        );
        $employe = new Employee(); 
        $select = new Select();
        
        switch($_GET['request']){
            
            case 'GET':
                switch($_GET['action']){
                    case 'allEmployees':
                       if($employe->id($_SESSION['idUser'])){
                            if($result['dataset']=$employe->all()){
                                $result['status']=1;
                            }   
                            else{
                                $result['exception']='No hay empleados disponibles';
                            }
                       }
                       else{
                        $result['exception']='No hay información';
                       }
                    break;
                    case 'ListEmployees':
                        if($employe->id($_SESSION['idUser'])){
                            if($result['dataset']=$employe->ListPersons()){
                                $result['status']=1;
                            }   
                            else{
                                $result['exception']='No hay empleados disponibles';
                            }
                        }
                        else{
                            $result['exception']='No hay información';
                        }
                    break;
                }
            break;
            
            case 'POST':
                switch($_GET['action']){
                    case 'CreateUser':
                        if($employe->name($_POST['NameUser'])){
                            if($employe->lastname($_POST['LastName'])){
                                if($employe->email($_POST['EmailUser'])){
                                    if($employe->username($_POST['Nickname'])){
                                        if( $_POST['pass'] == $_POST['pass2'] ){
                                            if($employe->password($_POST['pass'])){
                                                if($employe->role(1)){
                                                    if(!$select->emailWhere("employees", $_POST['EmailUser'] )){
                                                        $employe->save();
                                                        $result['status']=1;
                                                    }
                                                    else{
                                                        $result['exception']='Correo existente';
                                                    }
                                                }
                                                else{
                                                    $result['exception']='Cargo invalido';
                                                }
                                            }
                                            else{
                                                $result['exception']='La contraseña debe constar al menos de 8 carácteres';
                                            }
                                        }
                                        else{
                                            $result['exception']='Las contraseñas ingresadas no son iguales';
                                        }
                                    }
                                    else{
                                        $result['exception']='El nombre de usuario debe constar de 7 carácteres';
                                    }
                                }
                                else{
                                    $result['exception']='Correo invalido';
                                }
                            }
                            else{
                                $result['exception']='Apellido incorrecto debe llevar al menos 5 carácteres';
                            }
                        }
                        else{
                            $result['exception']='Nombre incorrecto debe llevar al menos 5 carácteres';
                        }
                    break;
                    case 'CreatePublicUser':
                        if($employe->name($_POST['NameUser'])){
                            if($employe->lastname($_POST['LastName'])){
                                if($employe->email($_POST['EmailUser'])){
                                    if($employe->username($_POST['Nickname'])){
                                        if( $_POST['pass'] == $_POST['pass2'] ){
                                            if($employe->password($_POST['pass'])){
                                                if($employe->role(2)){
                                                    if(!$select->emailWhere("employees", $_POST['EmailUser'] )){
                                                        $employe->save();
                                                        $result['status']=1;
                                                    }
                                                    else{
                                                        $result['exception']='Correo existente';
                                                    }
                                                }
                                                else{
                                                    $result['exception']='Cargo invalido';
                                                }
                                            }
                                            else{
                                                $result['exception']='La contraseña debe constar al menos de 8 carácteres';
                                            }
                                        }
                                        else{
                                            $result['exception']='Las contraseñas ingresadas no son iguales';
                                        }
                                    }
                                    else{
                                        $result['exception']='El nombre de usuario debe constar de 7 carácteres';
                                    }
                                }
                                else{
                                    $result['exception']='Correo invalido';
                                }
                            }
                            else{
                                $result['exception']='Apellido incorrecto debe llevar al menos 5 carácteres';
                            }
                        }
                        else{
                            $result['exception']='Nombre incorrecto debe llevar al menos 5 carácteres';
                        }
                    break;
                    case 'publicLogin':
                    if($employe->username($_POST['Nickname'])){
                        if($employe->checkUsername()){
                            if($employe->password($_POST['pass'])){
                                if($employe->checkPassword()){
                                        $_SESSION['idPublicUser']=$employe->getId();
                                        $_SESSION['publicNameUser']=$employe->getName();
                                        $_SESSION['publicLastnameUser']=$employe->getLastname();
                                        $_SESSION['publicEmail']=$employe->getEmail();
                                        $_SESSION['publicUsernameActive']=$employe->getUsername();
                                        $_SESSION['publicRole']=$employe->getRole();
                                        $result['status']=1;
                                        $result['userInformation']=$_SESSION;
                                }
                                else{
                                    $result['exception']='Contraseña o usuario incorrecto';
                                }
                            }
                            else{
                                $result['exception']='Ingrese la contraseña porfavor, minimo 8 carácteres';
                            }
                        }
                        else{
                            $result['exception']='Usuario inexistente';
                        }
                    }
                    else{
                        $result['exception']='El usuario debe contar con 7 carácteres';
                    }   
                    break;
                    case 'LogoffPublic':
                        if($employe->LogOffPublic()){
                                header('location: /Illusion/');
                        }
                        else{
                            header('location: /Illusion/user/requests.php');
                            
                        }
                    break;
                    case 'Logoff':
                        if($employe->logOff()){
                                header('location: /Illusion/private/');
                        }
                        else{
                            header('location: /Illusion/private/home.php');
                            
                        }
                    break;
                    default:
                    exit('Acción no disponible');
                }
            break;
            
            case 'PUT':
                switch($_GET['action']){
                    case 'updateProfile':
                        if($employe->id($_POST['id'])){
                            if($employe->name($_POST['name'])){
                                if($employe->lastname($_POST['lastname'])){
                                    if($employe->email($_POST['email'])){
                                        if($employe->username($_POST['username'])){
                                            $employe->updateProfile();
                                            $result['status']=1;
                                        }
                                        else{
                                            $result['exception']='Nombre ingresado invalido';
                                        }
                                    }
                                    else{
                                        $result['exception']='Email ingresado invalido';
                                    }
                                }
                                else{
                                    $result['exception']='Apellido ingresado invalido';
                                }    
                            }
                            else{
                                $result['exception']='Nombre ingresado invalido';
                            }
                        }
                        else{
                            $result['exception'] = 'No se ha encontrado información';
                        }
                    break;
                    case 'resetPassword':
                        if($employe->id($_POST['id'])){
                           if( strlen($_POST['pass1'])>=8 && strlen($_POST['pass1'])>=8 ){
                               if( $_POST['pass1'] == $_POST['pass2'] ){
                                    if($employe->password($_POST['pass1'])){
                                        $employe->updatePassword();
                                        $result['status']=1;
                                    }
                                    else{
                                        $result['exception']='Contraseña invalida';    
                                    }
                               }
                               else{
                                    $result['exception']='Las contraseñas no son iguales';    
                               }
                           }
                           else{
                               $result['exception']='Las contraseñas son menores a 8 digitos';
                           }
                        }
                        else{
                            $result['exception']='No hay información de usuario';
                        }
                    break;
                }
            break;

            case 'DELETE':
                switch($_GET['action']){
                    case 'DeleteUser':
                    break;
                }
            break;

            default:
            exit('Petición rechazada');
        }
        
        print( json_encode($result) );
    }
    else{
        exit('Petición de HTTP y acción no definidas');
    }
?>