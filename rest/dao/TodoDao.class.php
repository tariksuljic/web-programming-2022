<?php

class TodoDao{


private $conn;

//constructor for dao class

  public function __construct(){
    $servername="127.0.0.1:3308";
    $username="todo";
    $password="Tare123456";
    $schema="todo";

    $this->conn = new PDO("mysql:host=$servername;dbname=$schema",$username,$password);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);



  }

//Method used to read all todo objects from database

  public function get_all(){

    $stmt=$this->conn->prepare("SELECT * FROM todos");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);


  }

//Method used to add todo to the database

  public function add($description,$created){
    $stmt=$this->conn->prepare("INSERT INTO todos (description,created) VALUES(:description,:created)");
    $stmt->execute(['description'=>$description,'created'=>$created]);
  }
//Method to delete record from the database
  public function delete($id){

    $stmt=$this->conn->prepare("DELETE FROM todos WHERE id=:id");
    $stmt->bindParam(':id',$id);
    $stmt->execute();



  }

  //Method to update todo record

  public function update($id,$description,$created){

    $stmt=$this->conn->prepare("UPDATE todos SET description=:description,created=:created WHERE id=:id");
    $stmt->bindParam(':id',$id);
    $stmt->bindParam(':description',$description);
    $stmt->bindParam(':created',$created);
    $stmt->execute();



  }

  public function get_by_id($id){

    $stmt=$this->conn->prepare("SELECT * FROM todos WHERE id=:id");
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    return @reset($result);


  }



}


 ?>
