<?php
	include('../../../asset/db.php');
	include('function.php');
	if(isset($_POST["operation"]))
	{
		
		
		if($_POST["operation"] == "add_shopcat")
		{
			$statement = $connection->prepare(
			"INSERT INTO shop_cat (name, descp, keyword) VALUES (:shopcat_name, :shopcat_desc, :shopcat_keyword) " );
			
			$result = $statement->execute(
			array(
			':shopcat_name' => $_POST["shopcat_name"],
			':shopcat_desc' => $_POST["shopcat_desc"],
			':shopcat_keyword' => $_POST["shopcat_keyword"]
			)
			);
			
			if(!empty($result))
			{
				echo 'Shop Category Added';
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
			"UPDATE shop_cat 
			SET name = :shopcat_name, descp = :shopcat_desc, keyword = :shopcat_keyword
			WHERE shop_cat_id = :shopcat_id
			"
			);
			$result = $statement->execute(
			array(
			':shopcat_id' => $_POST["shopcat_id"],
			':shopcat_name' => $_POST["shopcat_name"],
			':shopcat_desc' => $_POST["shopcat_desc"],
			':shopcat_keyword' => $_POST["shopcat_keyword"]
			)
			);
			if(!empty($result))
			{
				echo 'Shop category Updated';
			}
		}
		
		
		
		
		
		
		
		
		 
	}
	
?>