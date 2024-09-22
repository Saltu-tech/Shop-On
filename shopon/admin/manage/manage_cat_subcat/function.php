<?php

function upload_image()
{
 if(isset($_FILES["prod_image"]))
 {
  $extension = explode('.', $_FILES['prod_image']['name']);
  $new_name = uniqid() . '.' . $extension[1];
  $destination = '../../image/' . $new_name;
  move_uploaded_file($_FILES['prod_image']['tmp_name'], $destination);
  return $new_name;
 }
}

function get_image_name($user_id)
{
 include('../../../asset/db.php');
 $statement = $connection->prepare("SELECT image FROM users WHERE id = '$user_id'");
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row["image"];
 }
}

function get_total_all_records()
{
 include('../../../asset/db.php');
 $statement = $connection->prepare("SELECT * FROM `category`");
 $statement->execute();
 $result = $statement->fetchAll();
 return $statement->rowCount();
}

?>