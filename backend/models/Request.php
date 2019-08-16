<?php 
class Request{

    private static $id;
    private static $date_event;
    private static $name_event;
    private static $type_event;
    private static $persons;
    private static $description_event;
    private static $status;
    private static $user_id;
    
    public static function set(){
        return new static;
    }
    public static function name_event($value){
        static::$name_event=$value;
        return new static;
    }
    public static function id($value){
        static::$id=$value;
        return new static;
    }
    public static function date_event($value){
        static::$date_event = $value;
        return new static;
    }
    public static function persons($value){
        static::$persons = $value;
        return new static;
    }
    public static function type_event($value){
        static::$type_event =$value;
        return new static;
    }
    public static function description_event($value){
        static::$description_event =$value;
        return new static;
    }
    public static function default_status(){
        static::$status = 3;
        return new static;
    }
    public static function status($value){
        static::$status = $value;
        return new static;
    }
    public static function user_id($value){
        static::$user_id = $value;
        return new static;
    }

    public static function Insert(){
        $sql='INSERT INTO requests VALUES(null,?,?,?,?,?,?,?)';
        $params = array(static::$date_event,static::$name_event,static::$type_event, static::$persons, static::$description_event, static::$status, static::$user_id);
        return Database::executeRow($sql,$params);
    }
    public static function verifyStatus(){
        $sql='SELECT employees.id, employees.username, requests.name_event, status_requests.id as idStatus,status_requests.status 
        FROM ((requests 
        INNER JOIN status_requests ON requests.status=status_requests.id) 
        INNER JOIN employees ON requests.public_user_id=employees.id AND employees.id=? AND requests.id=?)';
        $params = array(static::$user_id,static::$id);
        return Database::getRow($sql,$params);
    }
    public static function getmyRequests(){
        $sql='SELECT requests.id, requests.date_event, requests.name_event, status_requests.id AS statusId ,status_requests.status,  event_types.type 
        FROM (( requests 
        INNER JOIN status_requests ON status_requests.id=requests.status
        INNER JOIN employees ON requests.public_user_id=employees.id) 
        INNER JOIN event_types ON requests.type_event=event_types.id AND employees.id=?)';  
        $params = array(static::$user_id);
        return Database::getRows($sql,$params);
    }
    public static function allRequest(){
        $sql='SELECT requests.id, requests.date_event, CONCAT(employees.name," ",employees.lastname) AS fullname, requests.name_event, status_requests.id AS statusId ,status_requests.status,  event_types.type 
        FROM (( requests 
        INNER JOIN status_requests ON status_requests.id=requests.status
        INNER JOIN employees ON requests.public_user_id=employees.id) 
        INNER JOIN event_types ON requests.type_event=event_types.id)';  
        $params = array(null);
        return Database::getRows($sql,$params);
    }
    public static function productsInNotRequest(){
        $sql='  SELECT products.id, products.nameProduct 
                FROM products 
                WHERE NOT EXISTS (SELECT 1 FROM list_product_request 
                WHERE products.id = list_product_request.id_product AND list_product_request.id_request=?)
        ';
        $params= array(static::$id);
        return Database::getRows($sql,$params);
    }
    public static function GetRequest(){
        $sql='  SELECT requests.*, status_requests.status AS status_event, event_types.type AS type_event
                FROM ((requests 
                INNER JOIN status_requests ON requests.status=status_requests.id) 
                INNER JOIN event_types ON requests.type_event=event_types.id)
        ';
        $params=array(null);
        return Database::getRows($sql,$params);
    }
    public static function getmyRequest(){
        $sql='SELECT requests.name_event, requests.date_event, requests.persons, requests.description_event, event_types.type FROM (requests INNER JOIN event_types ON event_types.id=requests.type_event AND requests.id=?)';
        $params=array(static::$id);
        return Database::getRow($sql,$params);

    }
    public static function getEventbyRequest(){
        $sql = 'SELECT events.id AS eventId, events.name_event, requests.id 
                FROM ((event_assignments 
                INNER JOIN events ON event_assignments.id_event=events.id) 
                INNER JOIN requests ON event_assignments.id_request=requests.id AND requests.id=?)';
        $params = array(static::$id);
        return Database::getRow($sql,$params);
            
    }
    public static function getProductsRequest(){
        $sql='SELECT products.nameProduct, list_product_request.count FROM ((list_product_request INNER JOIN products ON list_product_request.id_product=products.id) INNER JOIN requests ON list_product_request.id_request=requests.id AND requests.id=?)';
        $params= array(static::$id);
        return Database::getRows($sql,$params);
    }
    public static function updateStatus(){
        $sql='UPDATE requests SET status=? WHERE id=?';
        $params=array(static::$status, static::$id);
        return Database::executeRow($sql,$params);
    }
    public static function getRequestDates(){
        $sql='SELECT requests.date_request, COUNT(requests.id) AS countTotal FROM requests GROUP BY requests.date_request ORDER BY requests.date_request DESC';
        $params = array(null);
        return Database::getRows($sql,$params);
    }
    
}
?>