<?php 
class List_product_request{
    static private $id;
    static private $id_product;
    static private $id_request;
    static private $count;

    public static function set(){
        return new static;
    }
    public static function id($value){
        static::$id = $value;
        return new static;
    }
    public static function id_product($value){
        static::$id_product = $value;
        return new static;
    }
    public static function id_request($value){
        static::$id_request = $value;
        return new static;
    }
    public static function count($value){
        static::$count = $value;
        return new static;
    }
    public static function save(){
        $sql='INSERT INTO list_product_request VALUES (null, ?,?,?)';
        $params = array(static::$id_product, static::$id_request, static::$count);
        return Database::executeRow($sql,$params);
    }
    public static function delete(){
        $sql='DELETE FROM list_product_request WHERE id=?';
        $params = array(static::$id);
        return Database::executeRow($sql,$params);
    }
}
?>