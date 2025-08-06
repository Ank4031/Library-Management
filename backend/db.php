<?php
class db{
    public function __construct(){
        $this->conn = new mysqli("localhost","root","","library");
    }

    public function get_Con(){
        return $this->conn;
    }

    public function check_Email(string $email){
        if (isset($_SESSION["name"])){
            $str = $this->conn->prepare("SELECT * FROM users  WHERE email= ? and username != ?");
            $str->bind_param('ss',$email,$_SESSION['username']);
        }else{
            $str = $this->conn->prepare("SELECT * FROM users  WHERE email= ?");
            $str->bind_param('s',$email);
        }
        $str->execute();
        $result = $str->get_result();
        if ($result->num_rows > 0){
            return true;
        }else{
            return false;
        }
        exit();
    }

    public function check_Username($username){
        if (isset($_SESSION["name"])){
            $str = $this->conn->prepare("SELECT * FROM users  WHERE email != ? and username = ?");
            $str->bind_param('ss',$_SESSION['email'],$username);
            
        }else{
            $str = $this->conn->prepare("SELECT * FROM users  WHERE username = ?");
            $str->bind_param('s', $username);
        }
        $str->execute();
        $result = $str->get_result();
        if ($result->num_rows > 0){
            return true;
        }else{
            return false;
        }
        exit();
    }

    public function create_User($data){
        $name = $data['name'];
        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];
        $role = 'user';
        if (isset($_SESSION["role"])){
            if ($_SESSION['role']=='admin'){
                $role = $data['role'];
            }
        }
        $str = $this->conn->prepare("INSERT INTO users (username, name, email, password, role) VALUES (?,?,?,?,?)");
        $str->bind_param('sssss', $username, $name, $email, $password, $role);
        $str->execute();
        return true;
    }
}