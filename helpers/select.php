<?php 

    class Select{

        public static $column_field;
        public static $model_name;
        public static $field_name;
        public static $all="*";
        public static $value_filter;
        
        //ComboBoxes
        public function allFrom($Model){
            $sql='SELECT * FROM '. $Model;
            $params = array(null);
            return Database::getRows($sql, $params);
        }

        //Verify if a email exist
        public function emailWhere($Model , $email){
            $sql='SELECT email FROM '. $Model .' WHERE email = ?';
            $params = array($email);
            return Database::getRow($sql, $params);
        }

        public static function all(){
            static::$all;
            return new static;
        }
        public static function from($Model){
            static::$model_name = $Model;
            return new static;
        }
        public static function where($columnName, $value){
            static::$column_field = $columnName;
            static::$value_filter = $value;
            return new static;
        }

        //Method to get all row with all and from and where
        public static function get(){
            $sql='SELECT '. static::$all .' FROM '. static::$model_name .' WHERE '.static::$column_field.' =?';
            $params = array(static::$value_filter);
            return Database::getRow($sql,$params);
        }

        public static function getAll(){
            $sql='SELECT '. static::$all .' FROM '. static::$model_name .' WHERE '.static::$column_field.' =?';
            $params = array(static::$value_filter);
            return Database::getRows($sql,$params);
        }
        
        public static function in($Model, $column){
            static::$model_name=$Model;
            static::$column_field=$column;
            return new static;
        }
        //Method to get one field with in and where
        public static function getOne(){
            $sql='SELECT '. static::$column_field .' FROM '.static::$model_name.' WHERE '. static::$column_field .' = ?';
            $params=array(static::$value_filter);
            return Database::getRow($sql,$params);
        }

        
        


       
    }
?>