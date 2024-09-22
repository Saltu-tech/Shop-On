<?php
	include('../../../asset/db.php');
	include('function.php');
	if(isset($_POST["operation"]))
	{
		if($_POST["operation"] == "Add")
		{
			
			$statement = $connection->prepare("
			INSERT INTO product (prod_name, prod_price, prod_desc, keyword, mfrs, type ) 
			VALUES (:prod_name, :prod_price, :prod_desc, :keyword, :mfrs, :type)
			");
			$result = $statement->execute(
			array(
			':prod_name' => $_POST["prod_name"],
			':prod_price' => $_POST["prod_price"],
			':prod_desc' => $_POST["prod_desc"] == '' ? NULL : $_POST["prod_desc"],
			':keyword' => $_POST["keyword"]== '' ? NULL : $_POST["keyword"],
			':mfrs' => $_POST["mfrs"] == '' ? NULL : $_POST["mfrs"],
			':type' => $_POST["service_type"]
			)
			);
			if(!empty($result))
			{
				echo 'Product Inserted';
			}
			else
			{
				print_r($statement->errorInfo());
			} 
		}
		if($_POST["operation"] == "Edit")
		{
			
			$statement = $connection->prepare(
			"UPDATE product 
			SET prod_name = :prod_name, prod_price = :prod_price, prod_desc = :prod_desc, keyword = :keyword, mfrs = :mfrs, type = :type  
			WHERE prod_id = :prod_id
			"
			);
			$result = $statement->execute(
			array(
			':prod_name' => $_POST["prod_name"],
			':prod_price' => $_POST["prod_price"],
			':prod_desc' => $_POST["prod_desc"] == '' ? NULL : $_POST["prod_desc"],
			':keyword' => $_POST["keyword"] == '' ? NULL : $_POST["keyword"],
			':mfrs' => $_POST["mfrs"] == '' ? NULL : $_POST["mfrs"],
			':type' => $_POST["service_type"],
			':prod_id'   => $_POST["prod_id"]
			)
			);
			if(!empty($result))
			{
				echo 'Data Updated';
			}
			else
			{
				print_r($statement->errorInfo());
			}
		}
		
		
		
		if($_POST["operation"] == "add_attrib")
		{
			$statement = $connection->prepare(
			"INSERT INTO prod_attrib (prod_id, attrib_val_id) VALUES (:prod_id, :attrib_val_id) " );
			
			$result = $statement->execute(
			array(
			':prod_id' => $_POST["prod_id"],
			':attrib_val_id' => $_POST["attrib_val_id"]
			)
			);
			
			if(!empty($result))
			{
				echo 'Attribute Added';
			}
			else
			{
				//echo( $result->error);
				print_r($statement->errorInfo());
			}
			
		} 
		
		
		
		
		if($_POST["operation"] == "add_feat")
		{
			$statement = $connection->prepare(
			"INSERT INTO prod_feat (prod_id, feature) VALUES (:prod_id, :feature) " );
			
			$result = $statement->execute(
			array(
			':prod_id' => $_POST["prod_id"],
			':feature' => $_POST["feature"]
			)
			);
			
			if(!empty($result))
			{
				echo 'Feature Added';
			}
			else
			{
				//echo( $result->error);
				print_r($statement->errorInfo());
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
			INSERT INTO prod_image (prod_id, img_path) 
			VALUES (:prod_id, :img_path)
			");
			$result = $statement->execute(
			array(
			':prod_id' => $_POST["prod_id"],
			':img_path'  => $image
			)
			);
			if(!empty($result))
			{
				echo 'Data Inserted';
			}
			else
			{
				//echo( $result->error);
				print_r($statement->errorInfo());
			}
			
		} 
	}
	
?>