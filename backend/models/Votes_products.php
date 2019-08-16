<?php 
class Votes_products extends Validator{
    private $id;
    private $id_user;
    private $id_product;
    private $id_vote;

    public function id($value){
        if($this->validateId($value)){
            $this->id=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function id_user($value){
        if($this->validateId($value)){
            $this->id_user=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function id_product($value){
        if($this->validateId($value)){
            $this->id_product=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function id_vote($value){
        if($this->validateId($value)){
            $this->id_vote=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function exist(){
        $sql='SELECT 1 AS exist FROM ((votes_products INNER JOIN products ON votes_products.id_product=products.id) INNER JOIN employees ON votes_products.id_user=employees.id) WHERE products.id=? AND employees.id=?';
        $params=array($this->id_product,$this->id_user);
        return Database::getRow($sql,$params);
    }
    public function getlikeInfo(){
        $sql='SELECT products.nameProduct, employees.username, like_states.id AS likeState, like_states.action FROM ((votes_products INNER JOIN products ON votes_products.id_product=products.id) INNER JOIN like_states ON votes_products.id_vote=like_states.id INNER JOIN employees ON votes_products.id_user=employees.id AND products.id=? AND employees.id=?)';
        $params=array($this->id_product,$this->id_user);
        return Database::getRow($sql,$params);
    }
    public function updateAction(){
        $sql='UPDATE votes_products SET id_vote=? WHERE id_user=? AND id_product=?';
        $params=array($this->id_vote,$this->id_user,$this->id_product);
        return Database::executeRow($sql,$params);
        
    }
    public function deleteLike(){
        $sql='DELETE FROM votes_products WHERE id_user=? AND id_product=? AND id_vote=?';
        $params=array($this->id_user,$this->id_product,$this->id_vote);
        return Database::executeRow($sql,$params);
    }
    
    public function save(){
        $sql='INSERT INTO votes_products VALUES (NULL,?,?,?)';
        $params=array($this->id_user, $this->id_product, $this->id_vote);
        return Database::getRow($sql,$params);
    }
}
?>