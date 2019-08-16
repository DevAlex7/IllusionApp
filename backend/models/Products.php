<?php 
date_default_timezone_set("America/El_Salvador");
class Product extends Validator{
    private $id;
    private $nameProduct;
    private $imageroot='../Imports/resources/pics/products/';
    private $image_product;
    private $count;
    private $date;
    private $id_employee;
    private $price;
    private $search;
    
    public function id($value){
        if($this->validateId($value)){
            $this->id=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function nameProduct($value){
        if($this->validateAlphanumeric($value,3,150)){
            $this->nameProduct=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function getNameProduct(){
        return $this->nameProduct;
    }
    public function getImage(){
        return $this->image_product;
    }
    public function getRoot(){
        return $this->imageroot;
    }
    public function image_product($file, $name){
        if($this->validateImageFile($file, $this->imageroot, $name, 500, 500)){
            $this->image_product=$this->getImageName();
            return true;
        }
        else{
            return false;
        }
    }
    public function count($value){
        if($this->ValidateInt($value)){
            $this->count=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function id_employee($value){
        if($this->validateId($value)){
            $this->id_employee=$value;
            return true;
        }
        else{
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

    public function searchbyUser($value){
        if($this->validateAlphanumeric($value,1,50)){
            $this->search=$value;
            return true;
        }
        else{
            return false;
        }
    }

    public function save(){
        $sql='INSERT INTO products (nameProduct, image_product, count, date, id_employee, price) VALUES (?,?,?,?,?,?)';
        $params=array($this->nameProduct, $this->image_product, $this->count , $today = date("Y-m-d"), $this->id_employee, $this->price );
        return Database::executeRow($sql,$params);
    }
    public function edit(){
        $sql = 'UPDATE products SET nameProduct=?, image_product=? ,count=?, price=? WHERE id=?';
        $params=array($this->nameProduct, $this->image_product , $this->count, $this->price, $this->id);
        return Database::executeRow($sql,$params);
    }
    public function delete(){
        $sql='DELETE FROM products WHERE id=?';
        $params=array($this->id);
        return Database::executeRow($sql,$params);
    }
    public function find(){
        $sql='  SELECT products.id, products.nameProduct, products.image_product ,products.count, products.date, employees.name, employees.lastname, products.price 
                FROM (( products 
                INNER JOIN employees 
                ON employees.id=products.id_employee 
                AND products.id=?))';
        $params=array($this->id);
        return Database::getRow($sql,$params);
    }
    public function editCount(){
        $sql='UPDATE products SET count=? WHERE id=?';
        $params=array($this->count,$this->id);
        return Database::executeRow($sql,$params);
    }
    public function likes(){
        $sql='SELECT COUNT(*) AS likes FROM ((votes_products INNER JOIN products ON votes_products.id_product=products.id) INNER JOIN like_states ON votes_products.id_vote=like_states.id AND products.id=? AND like_states.id=1)';
        $params=array($this->id);
        return Database::getRow($sql,$params);
    }
    public function dislikes(){
         $sql='SELECT COUNT(*) AS dislikes FROM ((votes_products INNER JOIN products ON votes_products.id_product=products.id) INNER JOIN like_states ON votes_products.id_vote=like_states.id AND products.id=? AND like_states.id=2)';
        $params=array($this->id);
        return Database::getRow($sql,$params);
    }
    public function search(){
        $sql='
                SELECT products.*, 
                employees.name, employees.lastname 
                FROM products 
                INNER JOIN employees ON products.id_employee = employees.id 
                WHERE 
                products.nameProduct LIKE ?
                OR products.price LIKE ?
                OR products.date  LIKE ?
                OR products.count LIKE ? 
                OR employees.name LIKE ?
                OR employees.lastname LIKE ?
        ';
        $params=array("%$this->search%","%$this->search% ","%$this->search%","%$this->search%","%$this->search%","%$this->search%");
        return Database::getRows($sql,$params);
    }
    public function RequestsInProduct(){
        $sql='SELECT list_product_request.id AS idList, products.nameProduct, requests.name_event, list_product_request.count, employees.username FROM ((list_product_request INNER JOIN products ON list_product_request.id_product=products.id) INNER JOIN requests ON list_product_request.id_request=requests.id INNER JOIN employees ON requests.public_user_id=employees.id AND products.id=? AND employees.id=?)';
        $params=array($this->id,$this->id_employee);
        return Database::getRows($sql,$params);
    }
    public function deleteItemRequest(){
        $sql='DELETE FROM list_product_request WHERE id=?';
        $params = array($this->id);
        return Database::executeRow($sql,$params);
    }
    public function all($option){
        $sql="SELECT * FROM products ORDER BY products.count $option";
        $params=array($option);
        return Database::getRows($sql,$params);
    }
    

}

?>