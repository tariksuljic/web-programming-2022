<?php


class BaseDao{

private $conn;
private $table_name;

public function __construct($table_name){
  $this->table_name=$table_name;
  $servername="127.0.0.1:3308";
  $username="todo";
  $password="Tare123456";
  $schema="todo";

  $this->conn = new PDO("mysql:host=$servername;dbname=$schema",$username,$password);
  $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);



}

public function get_all(){

  $stmt=$this->conn->prepare("SELECT * FROM".$this->table_name);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);


}
public function get_by_id($id){

  $stmt=$this->conn->prepare("SELECT * FROM ".$this->table_name." WHERE id=:id");
  $stmt->bindParam(':id',$id);
  $stmt->execute();
  $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
  return @reset($result);


}

//Method to delete record from the database
  public function delete($id){

    $stmt=$this->conn->prepare("DELETE FROM ".$this->table." WHERE id=:id");
    $stmt->bindParam(':id',$id);
    $stmt->execute();



  }

  public function add($entity){
    $query = "INSERT INTO ".$this->table_name." (";
    foreach ($entity as $column => $value) {
      $query .= $column.", ";
    }
    $query = substr($query, 0, -2);
    $query .= ") VALUES (";
    foreach ($entity as $column => $value) {
      $query .= ":".$column.", ";
    }
    $query = substr($query, 0, -2);
    $query .= ")";

    $stmt= $this->conn->prepare($query);
    $stmt->execute($entity); // sql injection prevention
    $entity['id'] = $this->conn->lastInsertId();
    return $entity;
  }

  public function update($id, $entity, $id_column = "id"){
    $query = "UPDATE ".$this->table_name." SET ";
    foreach($entity as $name => $value){
      $query .= $name ."= :". $name. ", ";
    }
    $query = substr($query, 0, -2);
    $query .= " WHERE ${id_column} = :id";

    $stmt= $this->conn->prepare($query);
    $entity['id'] = $id;
    $stmt->execute($entity);
  }

  protected function query($query, $params){
    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  protected function query_unique($query, $params){
    $results = $this->query($query, $params);
    return reset($results);
  }

  //Method used to add todo to the database

    public function add($entity){
      return $this->add($entity);


    }

    //Method to update todo record

    public function update($id,$entity){

    return $this->update($entity);

    }


}



 ?>
