<?php 
class Events extends Validator{

    private $id;
    private $nameEvent;
    private $date;
    private $clientName;
    private $id_employee;
    private $price;
    private $pay_status;
    private $type_event;
    private $place;
    private $search;

    public function id($value){
        if($this->ValidateInt($value)){
            $this->id=$value;
            return true;
        }
        else{
            return false;
        }   
    }
    public function nameEvent($value){
        if($this->validateAlphanumeric($value, 5 , 150)){
            $this->nameEvent=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function getEventName(){
        return $this->nameEvent;
    }
    public function date($value){
        if($this->validateDate($value)){
            $this->date=$value;
            return true;            
        }
        else{
            return false;
        }
    }
    public function clientName($value){
        if($this->validateAlphabetic($value , 3 , 150)){
            $this->clientName=$value;
            return true;            
        }
        else{
            return false;
        }
    }
    public function id_employee($value){
        if($this->ValidateInt($value)){
            $this->id_employee=$value;
            return true;
        }
        else
        {
            return false;
        }
    }
    public function price($value){
        if($this->validateMoney($value)){
            $this->price = $value;
            return true;
        }
        else{
            return false;
        }
    }
    public function pay_status($value){
        if($this->ValidateInt($value)){
            $this->pay_status=$value;
            return true;
        }
        else{
            return false;
        }   
    }
    public function type_event($value){
        if($this->ValidateInt($value)){
            $this->type_event=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function place($place){
        if($this->isHTML($place)){
            $this->place = $place;
            return true;
        }
        else{
            return false;
        }
    }
    public function searchbyUser($value){
        if($this->validateAlphanumeric($value,1,70)){
            $this->search=$value;
            return true;
        }
        else{
            return false;
        }
    }
    
    public function all(){
        $sql='SELECT * FROM events ORDER BY id DESC';
        $params=array(null);
        return Database::getRows($sql,$params);
    }
    public function save(){
        $sql='INSERT INTO events (name_event, date, client_name, id_employee, price, pay_status, type_event, place) VALUES (?,?,?,?,?,?,?,?)';
        $params = array($this->nameEvent, $this->date, $this->clientName, $this->id_employee, $this->price, $this->pay_status, $this->type_event, $this->place);
        return Database::executeRow($sql,$params);
    }
    public function getInformation(){
                $sql='  SELECT events.id, events.name_event, events.date, events.id_employee, events.type_event ,  events.client_name, employees.name, employees.lastname, events.price, payment_event_status.status, event_types.type, events.place 
                        FROM ((employees 
                        INNER JOIN events ON events.id_employee=employees.id) 
                        INNER JOIN payment_event_status ON events.pay_status=payment_event_status.id 
                        INNER JOIN event_types ON events.type_event=event_types.id AND events.id=?)';
        $params=array($this->id);
        return Database::getRow($sql,$params);
    }
    public function getProductsinEvent(){
        $sql='  SELECT list_products_event.id AS idProductList, products.id, products.nameProduct, list_products_event.count, products.price 
                FROM ((products 
                INNER JOIN list_products_event 
                ON products.id=list_products_event.id_product) 
                INNER JOIN events 
                ON events.id=list_products_event.id_event AND events.id=?)
        ';
        $params=array($this->id);
        return Database::getRows($sql,$params);
    }
    public function allProductsinNotList(){
        $sql='  SELECT products.id, products.nameProduct 
                FROM products
                WHERE NOT EXISTS 
                (SELECT 1 FROM list_products_event 
                WHERE products.id = list_products_event.id_product 
                AND list_products_event.id_event=?)';
        $params=array($this->id);
        return Database::getRows($sql,$params);
        
    }
    public function getCostinEvent(){
        $sql='  SELECT SUM(products.price * list_products_event.count) AS Cost FROM ((list_products_event 
                INNER JOIN products 
                ON list_products_event.id_product=products.id) 
                INNER JOIN events 
                ON list_products_event.id_event=events.id AND events.id=?)';
        $params=array($this->id);
        return Database::getRow($sql,$params);
    }
    public function getEventsCosts(){
        $sql='  SELECT events.name_event, events.pay_status, products.price * list_products_event.count AS Cost FROM 
                ((events 
                INNER JOIN list_products_event ON list_products_event.id_event=events.id) 
                INNER JOIN products ON list_products_event.id_product=products.id 
                INNER JOIN payment_event_status ON events.pay_status=payment_event_status.id)
            ';
        $params=array(null);
        return Database::getRows($sql,$params);
    }
    public function getTotalWin(){
        $sql='  SELECT SUM(list_products_event.count*products.price) AS Cost 
                FROM (products 
                INNER JOIN list_products_event ON products.id=list_products_event.id_product
                INNER JOIN events ON list_products_event.id_event=events.id AND events.pay_status=1)
        ';
        $params=array(null);
        return Database::getRow($sql,$params);
    }
    public function getTotalLost(){
        $sql='  SELECT SUM(list_products_event.count*products.price) AS Cost 
        FROM (products 
        INNER JOIN list_products_event ON products.id=list_products_event.id_product
        INNER JOIN events ON list_products_event.id_event=events.id AND events.pay_status=2)
        ';
        $params=array(null);
        return Database::getRow($sql,$params);
    }
    public function search(){
        $sql = '
                SELECT events.*, 
                employees.name, employees.lastname 
                FROM events 
                INNER JOIN employees ON events.id_employee = employees.id 
                WHERE 
                events.name_event LIKE ?
                OR events.date LIKE ?
                OR events.client_name  LIKE ?
                OR employees.name LIKE ?
                OR employees.lastname LIKE ?
        ';
        $params=array("%$this->search%","%$this->search%","%$this->search%","%$this->search%","%$this->search%");
        return Database::getRows($sql,$params);
    }
    public function updateInfo(){
        $sql='UPDATE events SET date=?, type_event=? WHERE id=?';
        $params=array($this->date,$this->type_event, $this->id);
        return Database::executeRow($sql,$params);
    }
    public function verifyAdmin(){
        $sql='
            SELECT events.name_event, employees.name, employees.lastname, roles.role FROM ((events 
            INNER JOIN employees ON events.id_employee=employees.id AND employees.id=?)
            INNER JOIN roles ON employees.role=roles.id AND roles.id=0 	AND events.id=?)
        ';
        $params=array($this->id_employee,$this->id);
        return Database::getRow($sql,$params);
    }
    public function verifyisAdmin_In_Event(){
        $sql='  SELECT employees.name, employees.lastname, events.name_event, roles.role 
                FROM ((events 
                INNER JOIN employees 
                ON events.id_employee=employees.id ) 
                INNER JOIN roles 
                ON employees.role=roles.id 
                AND events.id=? AND employees.id=?)';
        $params=array($this->id,$this->id_employee);
        return Database::getRow($sql,$params);
    }
    public function getMyEvents(){
        $sql='  SELECT events.id, events.name_event, events.client_name, events.date FROM ((events 
                INNER JOIN employees 
                ON events.id_employee=employees.id AND employees.id=?) 
                INNER JOIN roles ON employees.role=roles.id AND roles.id=0)';
        $params=array($this->id_employee);
        return Database::getRows($sql,$params);
    }
    public function searchInMyEvents(){
        $sql='  SELECT events.*, 
                    employees.name, employees.lastname 
                    FROM events 
                    INNER JOIN employees ON events.id_employee = employees.id AND employees.id=?
                    INNER JOIN roles ON employees.role=roles.id
                    WHERE 
                    events.name_event LIKE ?
                    OR events.date LIKE ?
                    OR events.client_name  LIKE ?
                    OR employees.name LIKE ?
                    OR employees.lastname LIKE ?
                ';
        $params=array($this->id_employee,"%$this->search%","%$this->search%","%$this->search%","%$this->search%","%$this->search%");
        return Database::getRows($sql,$params);
    }
    public function verifyCreator(){
        $sql='  SELECT events.name_event, employees.name, roles.role 
                FROM ((events 
                INNER JOIN employees ON employees.id=events.id_employee AND employees.id=?) 
                INNER JOIN roles ON roles.id=employees.role AND roles.id=0 AND events.id=?)';
        $params=array($this->id_employee,$this->id);
        return Database::getRow($sql,$params);
    }
    public function getSharesEvents(){
        $sql='  SELECT events.id, events.name_event, events.client_name, events.date 
                FROM ((events 
                INNER JOIN share_events ON share_events.id_event=events.id) 
                INNER JOIN employees ON employees.id=share_events.id_employee AND employees.id=?)';
        $params=array($this->id_employee);
        return Database::getRows($sql,$params);
    }
    public function getCollaborators(){
        $sql='  SELECT COUNT(share_events.id_employee) AS Count FROM 
            (share_events 
            INNER JOIN events 
            ON events.id=share_events.id_event AND events.id=?)';
        $params=array($this->id);
        return Database::getRow($sql,$params);
    }
    public function searchInMyShares(){
        $sql='
                SELECT events.*, 
                employees.name, employees.lastname 
                FROM events 
                INNER JOIN employees ON events.id_employee = employees.id 
                WHERE 
                events.name_event LIKE ?
                OR events.date LIKE ?
                OR events.client_name  LIKE ?
                OR employees.name LIKE ?
                OR employees.lastname LIKE ?
        ';
        $params=array("%$this->search%","%$this->search%","%$this->search%","%$this->search%","%$this->search%");
        return Database::getRows($sql,$params);
    }
    public function ListAdministrators(){
        $sql='  SELECT employees.id, employees.name, roles.role 
                FROM employees, roles 
                WHERE employees.role=roles.id AND roles.id=0 
                AND 
                NOT EXISTS (SELECT 1 FROM share_events 
                WHERE employees.id = share_events.id_employee 
                AND share_events.id_event=?)';
        $params=array($this->id);
        return Database::getRows($sql,$params);
        
    }
    
    
    

}

?>