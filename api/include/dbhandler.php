<?php
 
class DbHandler 
{ 
    private $conn;
 
    function __construct() 
    {
        require_once dirname(__FILE__) . '/dbconnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
    
    public function readUsers()
    {
        $stmt = $this->conn->prepare("SELECT * FROM users");
        if($stmt->execute())
        {
            $rows = array();
            $users = $stmt->get_result();
        
            while ($r = $users->fetch_assoc()) 
            {
                $rows[] = $r;
            }
            $stmt->close();
            return $rows;
        }
        else
        {
            $stmt->close();
            return false;
        }
    }
    
    public function register($email, $password)
    {
        if(!$this->doesThisUserExist($email))
        {
            $stmt = $this->conn->prepare("INSERT INTO users (`email`, `password`, `created`) VALUES (?,?,NOW())");
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function login($email, $password)
    {
        if($this->doesUserExist($email))
        {
            $stmt = $this->conn->prepare("SELECT password FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $newPassword = $stmt->get_result()->fetch_assoc();
            $newPassword = $newPassword['password'];
        
            if($password == $newPassword)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else 
        {
            return false;
        }
    }
    
    private function doesUserExist($email)
    {
        $stmt = $this->conn->prepare("SELECT `email` FROM users WHERE `email` = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $result = $result['email'];
        $stmt->close();
        
        if($result != "")
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function getUserFromEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT `id`,`email`,`created` FROM users WHERE `email` = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }
}
?>