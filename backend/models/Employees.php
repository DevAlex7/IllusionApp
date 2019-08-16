<?php 
class Employee extends Validator{
    private $id;
    private $name;
    private $lastname;
    private $email;
    private $username;
    private $password;
    private $role;

    public function id($value){
        if($this->validateId($value)){
            $this->id=$value;
            return true;
        }
        else{
            return false;
        }
    }

    public function getId()
	{
		return $this->id;
    }
    
    public function name($value){
        if($this->validateAlphanumeric($value, 4, 150)){
            $this->name = $value;
            return true;
        }
        else{
            return false;
        }
    }

    public function getName()
	{
		return $this->name;
    }
    
    public function lastname($value){
        if($this->validateAlphanumeric($value, 4, 150)){
            $this->lastname = $value;
            return true;
        }
        else{
            return false;
        }
    }

    public function getLastname(){
        return $this->lastname;
    }

    public function email($value){
        if($this->validateEmail($value)){
            $this->email=$value;
            return true;
        }
        else{
            return false;
        }
    }
    
    public function getEmail(){
        return $this->email;
    }

    public function username($value){
        if($this->validateAlphanumeric($value,7,150)){
            $this->username =$value;
            return true;
        }
        else{
            return false;
        }
    }

    public function getUsername(){
        return $this->username;
    }

    public function password($value){
        if($this->validateAlphanumeric($value,8,255)){
            $this->password = $value;
            return true;
        }
        else{
            return false;
        }
    }
    public function role($value){
        if($this->validateId($value)){
            $this->role=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function getRole(){
        return $this->role;
    }

    public function checkUsername()
	{
		$sql = 'SELECT id, name, lastname, username, email ,role FROM employees WHERE username = ?';
		$params = array($this->username);
		$data = Database::getRow($sql, $params);
		if ($data) {
			$this->id = $data['id'];
			$this->name = $data['name'];
            $this->lastname = $data['lastname'];
            $this->email = $data['email'];
            $this->username=$data['username'];
            $this->role = $data['role'];
			return true;
		} else {
			return false;
		}
	}

	public function checkPassword()
	{
		$sql = 'SELECT password FROM employees WHERE id = ?';
		$params = array($this->id);
		$data = Database::getRow($sql, $params);
		if (password_verify($this->password, $data['password'])) {
			return true;
		} else {
			return false;
		}
	}
    public function votes(){
        $sql='SELECT employees.id AS idUser, products.nameProduct, products.image_product, products.id AS productId, products.price, employees.username, like_states.id AS likeStatus, like_states.action FROM ((votes_products INNER JOIN products ON votes_products.id_product= products.id) INNER JOIN employees on votes_products.id_user=employees.id INNER JOIN like_states ON votes_products.id_vote=like_states.id AND employees.id=?)';
        $params=array($this->id);
        return Database::getRows($sql,$params);
    }
    public function save(){
        $hash = password_hash($this->password, PASSWORD_DEFAULT);
        $sql='INSERT INTO employees (name, lastname, email, username, password, role) VALUES (?,?,?,?,?,?)';
        $params = array($this->name, $this->lastname, $this->email, $this->username, $hash, $this->role);
        return Database::executeRow($sql,$params);
    }
    public function verifyRole(){
        $sql='
            SELECT roles.id, employees.id AS User, roles.role, employees.name, employees.lastname 
            FROM (employees INNER JOIN roles 
            ON employees.role=roles.id AND employees.id=?)
        ';
        $params=array($this->id);
        return Database::getRow($sql,$params);
    }
    public function all(){
        $sql='SELECT * FROM employees WHERE employees.id NOT IN (?)';
        $params=array($this->id);
        return Database::getRows($sql,$params);
    }
    public function ListPersons(){
        $sql='SELECT employees.*, roles.role FROM ((employees INNER JOIN roles ON employees.role=roles.id)) WHERE employees.id NOT IN (?)';
        $params=array($this->id);
        return Database::getRows($sql,$params);
    }
    public function updatePassword(){
        $hash = password_hash($this->password, PASSWORD_DEFAULT);
        $sql='UPDATE employees SET password=? WHERE id=?';
        $params=array($hash, $this->id);
        return Database::executeRow($sql,$params);
    }
    
    public function updateProfile(){
        $sql='UPDATE employees SET name=?, lastname=?, email=?, username=? WHERE id=?';
        $params=array($this->name, $this->lastname, $this->email, $this->username, $this->id);
        return Database::executeRow($sql,$params);
    }

    public function LogOff(){
		if(isset($_SESSION['idUser'])){
			unset($_SESSION['idUser']);
			unset($_SESSION['NameUser']);
			unset($_SESSION['LastnameUser']);
            unset($_SESSION['UsernameActive']);
            unset($_SESSION['Role']);
			return true;
		}	
		else
		{
			return false;
		}	
	}
    
    
}
?>