<?php
class Brands{
  public $db;
  
  public function __construct(){
    $this->db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    if(mysqli_connect_errno()){
      echo "Database connection error.";
      exit;
    }
  }

  public function get_brands(){
    $sql = "SELECT * FROM brands";
    $result = mysqli_query($this->db,$sql);
    while($row = mysqli_fetch_array($result)){
      $list[] = $row;
    }
    if(!empty($list)){
      return $list;
    }
  }

  public function add_brand($value){
    $sql = "INSERT INTO brands(brand_name) VALUES('$value')";
    $result = mysqli_query($this->db,$sql) or die(mysql_error() . "Cannot Insert Data");
    return $this->db->insert_id;
  }
}