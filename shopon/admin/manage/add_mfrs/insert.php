<?php
	include('../../../asset/db.php');
	include('function.php');
	if(isset($_POST["operation"]))
	{
		
		
		if($_POST["operation"] == "add_mfrs")
		{
			$statement = $connection->prepare(
			"INSERT INTO prod_mfrs (name, address, mobile, email, password) VALUES (:mfrs_name, :mfrs_add, :mfrs_mobile, :mfrs_email, :mfrs_pswd) " );
			
			$result = $statement->execute(
			array(
			':mfrs_name' => $_POST["mfrs_name"],
			':mfrs_add' => $_POST["mfrs_add"],
			':mfrs_mobile' => $_POST["mfrs_mobile"],
			':mfrs_email' => $_POST["mfrs_email"],
			':mfrs_pswd' => md5($_POST["mfrs_pswd"])
			)
			);
			
			if(!empty($result))
			{
				echo 'Manufacturers Added';
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
			"UPDATE prod_mfrs 
			SET name = :mfrs_name, address = :mfrs_add, mobile = :mfrs_mobile, email = :mfrs_email
			WHERE mfrs_id = :mfrs_id
			"
			);
			$result = $statement->execute(
			array(
			':mfrs_id' => $_POST["mfrs_id"],
			':mfrs_name' => $_POST["mfrs_name"],
			':mfrs_add' => $_POST["mfrs_add"],
			':mfrs_mobile' => $_POST["mfrs_mobile"],
			':mfrs_email' => $_POST["mfrs_email"]
			)
			);
			if(!empty($result))
			{
				echo 'Manufacturer Updated';
			}
		}
		
		
		
		
		
		
		
		
		 
	}
	
?>