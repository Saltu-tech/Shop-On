<?php
	include('../../asset/db.php');
	
	
	
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
	if(isset($_POST["operation"]))
	{
		if($_POST["operation"] == "add_product")
		{
			$query = "SELECT * FROM `shop_PRODUCT` WHERE shop_id = '$_POST[shop_id]' AND prod_id = '$_POST[prod_id]' ";
			$statement = $connection->prepare($query);
			$statement->execute();
			$result2 = $statement->fetchAll();
			
			if(count($result2) == 0)
			{
				$statement = $connection->prepare("
				INSERT INTO shop_product (shop_id, prod_id, price, status ) 
				VALUES (:shop_id, :prod_id, :price, :status)
				");
				$result = $statement->execute(
				array(
				':shop_id' => $_POST["shop_id"],
				':prod_id' => $_POST["prod_id"],
				':price' => $_POST["prod_price"],
				':status' => 0
				)
				);
			} 
			else {
				$statement = $connection->prepare("
				UPDATE shop_product SET status = :status, price = :price WHERE shop_id = :shop_id AND prod_id = :prod_id
				");
				$result = $statement->execute(
				array(
				':shop_id' => $_POST["shop_id"],
				':prod_id' => $_POST["prod_id"],
				':price' => $_POST["prod_price"],
				':status' => 0
				)
				);
			}
			if(!empty($result))
			{
				echo 'Product Added';
			}
			else
			{
				print_r($statement->errorInfo());
			}
		}
		
		
		
		
		
		
		
		
		if($_POST["operation"] == "delete_prod")
		{
			$statement = $connection->prepare(
			"UPDATE shop_product SET status = 1 WHERE sp_pid = :sp_pid "
			);
			$result = $statement->execute(
			array(
			':sp_pid' => $_POST["sp_pid"]
			)
			);
			
			if(!empty($result))
			{
				echo 'Product Deleted';
			}
			
		} 
		
		
		if($_POST["operation"] == "add_image")
		{
			$image = '';
			if($_FILES["prod_image"]["name"] != '')
			{
				$image = upload_image();
			}
			
			$statement = $connection->prepare("
			INSERT INTO shop_prod_img (sp_pid, img_path) 
			VALUES (:sp_pid, :img_path)
			");
			$result = $statement->execute(
			array(
			':sp_pid' => $_POST["sp_pid"],
			':img_path'  => $image
			)
			);
			if(!empty($result))
			{
				echo 'Image Inserted';
			}
			else
			{
				//echo( $result->error);
				print_r($statement->errorInfo());
			}
			
		}
		
		
		
		if($_POST["operation"] == "delete_image")
		{
			
			$image = $_POST["img_path"];
			unlink("../../image/" . $image);
			
			$statement = $connection->prepare(
			"DELETE FROM shop_prod_img WHERE sp_img_id = :sp_img_id"
			);
			$result = $statement->execute(
			array(
			':sp_img_id' => $_POST["sp_img_id"]
			)
			);
			
			if(!empty($result))
			{
				echo 'Image Deleted';
			}
		}
	}
	
	
	
	
	
?>