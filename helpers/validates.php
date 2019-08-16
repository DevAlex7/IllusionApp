<?php 
    
    class Validate{
        //Propiedades para Letras y numeros entre letras
        public static $value_param;
        public static $min_value;
        public static $max_value;

        //Propiedades para numeros y validar Id's
        public static $integer_param;

        //Propiedades para cualquier tipo
        public static $type_param;

        //Propiedad fecha para validar las fechas
        public static $date_param;

        public static function this($value, $min, $maximum){
           static::$value_param=$value;
           static::$min_value=$min;
           static::$max_value=$maximum;
           return new static;
        }

        public static function Alphabetic(){
            if (preg_match('/^[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{'.static::$min_value.','.static::$max_value.'}$/', static::$value_param)) {
                return true;
            } else {
                return false;
            }
        }
        public static function Alphanumeric(){
            if (preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.?,:]{'.static::$min_value.','.static::$max_value.'}$/', static::$value_param)) {
                return true;
            } else {
                return false;
            }
        }
        
        //Validaciones para ID
        public static function Integer($value){
            static::$integer_param = $value;
            return new static;
        }

        public static function Id(){
            if (filter_var(static::$integer_param, FILTER_VALIDATE_INT, array('min_range' => 1))) {
                return true;
            } else {
                return false;
            }
        }
        public static function Int(){
            if(preg_match('/^\d+$/', static::$type_param)){
                return true;	
            } 
            else {
                return false;
            }
        }
        
        //Validaciones para tipos de texto 
        public static function type($value){
            static::$type_param = $value;
            return new static;
        }
        public static function Money(){
            if (preg_match('/^[0-9]+(?:\.[0-9]{1,2})?$/', static::$type_param)) {
                return true;
            } else {
                return false;
            }
        }
        
        public static function HTML(){
            return static::$type_param != strip_tags(static::$type_param) ? true:false;
        }
        
        public static function Email(){
            if (filter_var(static::$type_param, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        }

        //Validaciones para fechas
        public static function date($date){
            static::$date_param = $date;
            return new static;
        }
        public static function format($format){
            if($format=='Y-m-d'){
                if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", static::$date_param )) {
                    return true ;
                } else {
                    return false;
                }
            }   
            else{
                return false;
            }
        }
        public static function afterToday(){

            $today = date("Y-m-d");
			$userDate = static::$date_param;

			if ($today <= $userDate) {
				return true;
			}
			else {
				return false;
			}
        }

        //Si es admin
        public function isAdmin($id_event, $employee){
            $events = new Events();
            if($events->id($id_event)){
                if($events->id_employee($employee)){
                    if($events->verifyAdmin()){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
        public function verifyRole($id_user){
            $employee = new Employee();
            if($employee->id($id_user)){
                $auth = $employee->verifyRole();
                if($auth['id']==0){
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
    }
?>