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

    require_once('../Backend/instance/instance.php');
    require_once('../helpers/validator.php');
    require_once('../backend/models/Votes_products.php');

    if( isset($_GET['request']) && isset($_GET['action']) ){
        
        session_start();
        $result = array('status'=>0,'exception'=>'');
        $vote = new Votes_products();
        switch($_GET['request'])
        {
            case 'GET':
                switch($_GET['action']){
                    default:
                    exit('acción no disponible');
                }
            break;
            case 'POST':
                switch($_GET['action']){
                    case 'verify':
                        if($vote->id_user($_POST['idUser'])){   
                            if($vote->id_product($_POST['idProduct'])){
                                if($vote->id_vote($_POST['like'])){
                                    if($vote->exist()){
      
                                        $getVote = $vote->getlikeInfo();
      
                                        if($getVote['likeState'] == 1 && $_POST['like'] == 1){
                                            //Se borra la acción de like
                                            if($vote->deleteLike()){
                                                $result['status']=2; 
                                            }
                                            else{
                                                $result['exception']='No se borro el like';
                                            }
                                        }
                                        else if($getVote['likeState'] == 1 && $_POST['like'] == 2){
                                            //Actualizara a dislike
                                            $vote->updateAction();
                                            $result['status']=3;
                                        }
                                        else if($getVote['likeState'] == 2 && $_POST['like'] == 2){
                                            //Se borra la acción de dislike 
                                            if($vote->deleteLike()){
                                                $result['status']=4;
                                            }
                                            else{
                                                $result['exception']='No se borro el like';
                                            }
                                            
                                        }
                                        else if($getVote['likeState'] == 2 && $_POST['like'] == 1){
                                            //Actualizara a like
                                            $vote->updateAction();
                                            $result['status']=5;
                                        }
                                        else{
                                            //No hara nada xD
                                        }
                                    }
                                    else{
                                        $vote->save();
                                        //Se creara la acción
                                        $result['status']=1; 
                                    }
                                }
                                else{
                                   $result['exception']='No hay reacción de usuario';
                                }
                            }
                            else{
                                $result['exception']='No hay información de producto';    
                            }
                        }
                        else{
                            $result['exception']='No hay información de usuario';
                        }
                    break;
                    case 'verifyAction':
                        if($vote->id_user($_POST['idUser'])){
                            if($vote->id_product($_POST['idProduct'])){
                                if($result['dataset']=$vote->getlikeInfo()){
                                    $result['status']=1;
                                }
                                else{
                                    $result['exception']='No hay registro de actividad';
                                }
                            }
                            else{
                                $result['exception']='No hay información de producto';
                            }
                        }
                        else{
                            $result['exception']='No hay información del usuario';
                        }
                    break;
                    default: 
                    exit('acción no disponible');
                }
            break;
            case 'PUT':
                switch($_GET['action']){
                  default: 
                    exit('acción no disponible');  
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