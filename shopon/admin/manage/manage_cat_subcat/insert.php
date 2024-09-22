<?php
	include('../../../asset/db.php');
	include('function.php');
	if(isset($_POST["operation"]))
	{
		
		
		if($_POST["operation"] == "add_cat")
		{
			$statement = $connection->prepare(
			"INSERT INTO category (cat_name) VALUES (:cat_name) " );
			
			$result = $statement->execute(
			array(
			':cat_name' => $_POST["cat_name"]
			)
			);
			
			if(!empty($result))
			{
				echo 'Category Added';
			}
			else
			{
				//echo( $result->error);
				print_r($statement->errorInfo());
			}
			
		}
		
		
		if($_POST["operation"] == "Edit")
		{
			
			$statement = $connection->prepare(
			"UPDATE category 
			SET cat_name = :cat_name
			WHERE cat_id = :cat_id
			"
			);
			$result = $statement->execute(
			array(
			':cat_name' => $_POST["cat_name"],
			':cat_id' => $_POST["cat_id"]
			)
			);
			if(!empty($result))
			{
				echo 'Data Updated';
			}
		}
		
		
		
		
		
		
		
		if($_POST["operation"] == "add_subcat_val")
		{
			$statement = $connection->prepare(
			"INSERT INTO subcategory (cat_id, subcat_name) VALUES (:cat_id, :subcat_name) " );
			
			$result = $statement->execute(
			array(
			':cat_id' => $_POST["cat_id"],
			':subcat_name' => $_POST["subcat_name"]
			)
			);
			
			if(!empty($result))
			{
				echo 'Subcategory added';
			}
			else
			{
				//echo( $result->error);
				print_r($statement->errorInfo());
			}
			
		}
		
		
		
		if($_POST["operation"] == "Edit_subcat_name")
		{
			$statement = $connection->prepare(
			"UPDATE subcategory SET subcat_name = :subcat_name WHERE subcat_id = :subcat_id" );
			
			$result = $statement->execute(
			array(
			':subcat_name' => $_POST["subcat_name"],
			':subcat_id' => $_POST["cat_id"]
			)
			);
			
			if(!empty($result))
			{
				echo 'Attribute value updated';
			}
			else
			{
				//echo( $result->error);
				print_r($statement->errorInfo());
			}
			
		}
		
		
		 
	}
	
?>