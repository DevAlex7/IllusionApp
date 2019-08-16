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
    require_once('../helpers/select.php');
    require_once('../backend/models/Events.php');
    require_once('../backend/models/Products.php');
    require_once('../backend/models/Employees.php');

    if( isset($_GET['request']) && isset($_GET['action']) ){
        
        session_start();
        $result = array('status'=>0,'exception'=>'');
        $select = new Select();
        $event = new Events();
        $employe = new Employee();
        $product = new Product();

        switch($_GET['request'])
        {
            case 'GET':
                switch($_GET['action']){

                    //This action is to select all products doesnt exist in list product
                    case 'getProducts':
                        if($event->id($_POST['idEvent'])){
                            if($result['dataset']=$event->allProductsinNotList()){
                                $result['status']=1;
                            }
                            else{
                                $result['exception']='No hay productos disponibles';
                            }
                        }
                        else{
                            $result['exception']='Evento no identificado';
                        }
                    break;
                    //This action is for get information by product Id
                    //This action is for get search results
                    case 'Search':
                        if($product->searchbyUser($_POST['SearchInput'])){
                            if($result['dataset']=$product->search()){
                                $result['status']=1;
                            }
                            else{
                                $result['exception']='No se encontraron resultados';
                            }
                        }
                        else{
                            $result['exception']='Busqueda invalida';
                        }
                    break;
                    default:
                    exit('acción no disponible');
                }
            break;
            case 'POST':
                switch($_GET['action']){
                     case 'SaveProduct':
                        if($product->nameProduct($_POST['NameProduct'])){
                            if(is_uploaded_file($_FILES['ProductImage']['tmp_name'])){
                                if($product->image_product($_FILES['ProductImage'],null)){
                                    if($product->saveFile($_FILES['ProductImage'], $product->getRoot(), $product->getImage())){
                                        if($product->count($_POST['CountStock'])){
                                            if($product->id_employee($_SESSION['idUser'])){
                                                if($product->price($_POST['PriceProduct'])){
                                                    $product->save();
                                                    $result['status']=1;
                                                }
                                                else{
                                                    $result['exception']='Dato de precio invalido';
                                                }
                                            }
                                            else{
                                                $result['exception']='Empleado no definido';
                                            }
                                        }
                                        else{
                                            $result['exception']='Cantidad invalida';
                                        }
                                    }
                                    else{
                                        $result['status'] = 2;
                                        $result['exception'] = 'No se guardó el archivo';
                                    }
                                }
                                else{
                                    $result['exception']=$product->getImageError();                                
                                }
                            }
                            else{
                                $result['exception'] = 'Seleccione una imagen';
                            }
                        }
                        else{
                            $result['exception']='Nombre de producto incorrecto';
                        }
                    break;
                     case 'GetbyId':
                        if($product->id($_POST['product'])){
                            
                            if($result['dataset']=$product->find()){
                                $result['status']=1;
                            }
                            else{
                                $result['exception']='No se encontro información';
                            }

                        }
                        else{
                            $result['exception']='Producto no identificado';
                        }   
                    break;
                     //This action is for select all products
                    case 'AllList':
                        if($result['dataset']=$product->all($_POST['default_option'])){
                            $result['status']=1;
                        }
                        else{
                            $result['exception']='No hay productos registrados';
                        }
                    break;
                    case 'verifylikes':
                        if($product->id($_POST['product'])){
                            
                            if($result['dataset']=$product->likes()){
                                $result['status']=1;
                            }
                            else{
                                $result['exception']='No hay likes';
                            }

                        }
                        else{
                            $result['exception']='Producto no identificado';
                        }   
                    break;
                    case 'getRequestsInproduct':
                        if($product->id($_POST['product'])){
                            if($product->id_employee($_POST['idUser'])){
                                if($result['dataset']=$product->RequestsInProduct()){
                                    $result['status']=1;
                                }
                                else{
                                    $result['exception']='No tienes solicitudes que has solicitado este producto';
                                }
                            }
                            else{
                                $result['exception']='No hay información del usuario';
                            }   
                        }
                        else{
                            $result['exception']='Producto no identificado';
                        }   
                    break;
                    case 'verifyDislikes':
                        if($product->id($_POST['product'])){
                            
                            if($result['dataset']=$product->dislikes()){
                                $result['status']=1;
                            }
                            else{
                                $result['exception']='No hay dislikes';
                            }

                        }
                        else{
                            $result['exception']='Producto no identificado';
                        }   
                    break;
                    default: 
                    exit('acción no disponible');
                }
            break;
            case 'PUT':
                switch($_GET['action']){
                     case 'EditProduct':
                        if($product->id($_POST['EditId'])){
                            if($product->nameProduct($_POST['EditNameProduct'])){
                                if($product->count($_POST['EditCountProduct'])){
                                    if($product->price($_POST['EditPriceProduct'])){
                                        if (is_uploaded_file($_FILES['FileEditCover']['tmp_name'])) {
                                            if ($product->image_product($_FILES['FileEditCover'], $_POST['ImageEditProduct'])) {
                                                $file = true;       
                                            } else {
                                                $result['exception'] = $product->getImageError();
                                                $file = false;
                                            }
                                        } else {
                                            if ($product->image_product(null, $_POST['ImageEditProduct'])) {
                                                $result['exception'] = 'No se subió ningún archivo';
                                            } else {
                                                $result['exception'] = $product->getImageError();
                                            }
                                            $file = false;
                                        }
                                    }
                                    else{
                                        $result['exception']='Precio invalido';
                                    }
                                }
                                else{
                                    $result['exception']='Cantidad invalida';
                                }
                            }
                            else{
                                $result['exception']='Nombre de producto incorrecto';
                            }
                            if ($product->edit()) {
                                if ($file) {
                                    if ($product->saveFile($_FILES['FileEditCover'], $product->getRoot(), $product->getImage())) {
                                        $result['status'] = 1;
                                    } else {
                                        $result['status'] = 2;
                                        $result['exception'] = 'No se guardó el archivo';
                                    }
                                } else {
                                    $result['status'] = 3;
                                }
                            } else {
                                $result['exception'] = 'Operación fallida';
                            }
                        }
                        else{
                            $result['exception']='No hay información del producto';
                        }
                    break;
                  default: 
                    exit('acción no disponible');  
                }
            break;
            case 'DELETE':
                switch($_GET['action']){
                    case 'deleteProduct':
                        if($product->id($_POST['idProduct'])){
                            if ($product->delete()){
                                if ($product->deleteFile($product->getRoot(), $_POST['imageFile'])) {
                                    $result['status'] = 1;
                                } else {
                                    $result['status'] = 2;
                                    $result['exception'] = 'No se borró el archivo';
                                }
                            } else {
                                $result['exception'] = 'Operación fallida';
                            }
                        }
                        else{
                            $result['exception']='No hay información del producto';
                        }
                    break;
                    case 'deleteRequestItem':
                        if($product->id($_POST['idProduct'])){
                            $product->deleteItemRequest();
                            $result['status']=1;
                        }
                        else{
                            $result['exception']='No hay información de la solicitud';
                        }
                    break;
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