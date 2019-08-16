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
    require_once('../backend/models/Request.php');
    require_once('../backend/models/List_product_request.php');
    require_once('../helpers/validates.php');

    if( isset($_GET['request']) && isset($_GET['action']) ){
        
        session_start();
        $result = array('status'=>0, 'exception'=>'');
        switch($_GET['request'])
        {
            case 'GET':
                switch($_GET['action']){
                    case 'getRequest':
                    if($result['dataset'] = Request::allRequest()){
                        $result['status']=1;
                    }
                    else{
                        $result['exception']='No hay solicitudes';
                    }
                    break;
                    case 'listRequestDate':
                        if($result['dataset']=Request::getRequestDates()){
                            $result['status']=1;
                        }
                        else{
                            $result['exception']='No hay solicitudes';
                        }
                    break;
                    default:
                    exit('acción no disponible');
                }
            break;
            case 'POST':
                switch($_GET['action']){
                    case 'verifyStatus':
                        if(Validate::Integer($_POST['user_id'])->Id()){
                            if(Validate::Integer($_POST['request_id'])->Id()){
                                Request::set()->user_id($_POST['user_id'])->id($_POST['request_id']);
                                if($result['dataset']=Request::verifyStatus()){
                                    $result['status']=1;
                                }
                                else{
                                    $result['exception']='Fallo obtener su información de la petición';
                                }
                            }
                            else{
                                $result['exception']='No se ha encontrado información de la solicitud';
                            }
                        }
                        else{
                            $result['exception']='No se encontraron datos de usuario';
                        }
                    break;
                    case 'myRequests':
                        if(Validate::Integer($_POST['id'])->Id()){
                            Request::set()->user_id($_POST['id']);
                            if($result['dataset']=Request::getmyRequests()){
                                $result['status']=1;
                            }
                            else{
                                $result['exception']='No tienes solicitudes todavia';
                            }
                        }
                        else{
                            $result['exception']='No hay información del usuario';
                        }
                    break;
                    case 'productsInNotListRequest':
                    if(Validate::Integer($_POST['id'])){
                        Request::set()->id($_POST['id']);
                        if($result['dataset']=Request::productsInNotRequest()){
                            $result['status']=1;
                        }   
                        else{
                            $result['exception']='No hay productos';
                        }
                    }
                    else{
                        $result['exception']='No se encontro información de la solicitud';
                    }
                    break;
                    case 'addProductListRequest':
                        if( Validate::Integer($_POST['id_product'])->Id() ){
                            if( Validate::Integer($_POST['count'])->Id() ){
                                if(Validate::Integer($_POST['id_request'])->Id()){
                                    List_product_request::set()
                                                    ->id_product($_POST['id_product'])
                                                    ->id_request($_POST['id_request'])
                                                    ->count($_POST['count'])
                                                    ->save();
                                    $result['status']=1;
                                }
                                else{
                                    $result['exception']='No se ha encontrado información de la solicitud';
                                }
                            }
                            else{
                                $result['exception']='Ingrese una cantidad para solicitar producto';
                            }
                        }
                        else{
                            $result['exception']='No se ha seleccionado un producto';
                        }
                    break;
                    case 'getProductRequest':
                    if(Validate::Integer($_POST['id_request'])->Id()){
                        Request::set()->id($_POST['id_request']);
                        if($result['dataset']=Request::getProductsRequest()){
                            $result['status']=1;
                        }
                        else{
                            $result['exception']='No hay productos en su lista';
                        }
                    }
                    else{
                        $result['exception']='No se ha encontrado información de la solicitud';
                    }
                    break;
                    case 'getmyRequest':
                        if(Validate::Integer($_POST['id'])){
                            Request::set()->id($_POST['id']);
                            if($result['dataset']=Request::getmyRequest()){
                                $result['status']=1;
                            }   
                            else{
                                $result['exception']='No se ha encontrado información de la solicitud';
                            }
                        }
                        else{
                            $result['exception']='No se encontro información de usuario';
                        }
                    break;
                    case 'getEvent':
                        if(Validate::Integer($_POST['id'])->Id()){
                            Request::set()->id($_POST['id']);
                            if($result['dataset']=Request::getEventbyRequest()){
                                $result['status']=1;
                            }
                            else{
                                $result['exception']='No se le ha asignado ningun evento';
                            }
                        }
                        else{
                            $result['exception']='No hay información de la solicitud';
                        }
                    break;
                    default: 
                    exit('acción no disponible');
                }
            break;
            case 'PUT':
                switch($_GET['action']){
                    case 'updateRequest':
                        if(Validate::Integer($_POST['id'])->Id()){
                            if(Validate::Integer($_POST['status'])->Id()){
                                if(Request::set()->id($_POST['id'])->status($_POST['status'])->updateStatus()){
                                    $result['status']=1;
                                }
                                else{
                                    $result['exception']='Fallo';
;                                }
                            }
                            else{
                                $result['exception']='No hay información de el estatus';                            
                            }
                        }
                        else{
                            $result['exception']='No hay información de la solicitud';
                        }
                    break;
                    default:
                    exit('Acción no disponible');
                }
            break;
            case 'DELETE':
                switch($_GET['action']){
                   
                    default:
                    exit('Acción no disponible');
                }
            break;

            default:
            exit('Petición rechazada');
        }
    print(json_encode($result));
    }
    else{
        exit('Petición Http y acción no definidas');
    }
?>