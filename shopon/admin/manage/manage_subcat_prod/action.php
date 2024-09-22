<?php
	include('../../../asset/db.php');
	include('function.php');
	if(isset($_POST["operation"]))
	{
		
		
		
		if($_POST["operation"] == "add_product")
		{
			$statement = $connection->prepare(
			"INSERT INTO subcat_prod (subcat_id, prod_id) VALUES (:subcat_id, :prod_id) " );
			
			$result = $statement->execute(
			array(
			':subcat_id' => $_POST["subcat_id"],
			':prod_id' => $_POST["prod_id"]
			)
			);
			
			if(!empty($result))
			{
				echo 'Product added in subcategory';
			}
			else
			{
				//echo( $result->error);
				print_r($statement->errorInfo());
			}
			
		}
		
		
		
		if($_POST["operation"] == "delete_prod")
		{
			$statement = $connection->prepare(
			"DELETE FROM subcat_prod WHERE subcatp_id = :subcatp_id" );
			
			$result = $statement->execute(
			array(
			':subcatp_id' => $_POST["subcatp_id"]
			)
			);
			
			if(!empty($result))
			{
				echo 'Product deleted from category';
			}
			else
			{
				//echo( $result->error);
				print_r($statement->errorInfo());
			}
			
		}
		
		
		 
	}
	
?>