<?php
	include('../../../asset/db.php');
	include('function.php');
	if(isset($_POST["operation"]))
	{
		
		
		if($_POST["operation"] == "add_attrib")
		{
			$statement = $connection->prepare(
			"INSERT INTO attrib_list (attrib_name) VALUES (:attrib_name) " );
			
			$result = $statement->execute(
			array(
			':attrib_name' => $_POST["attrib_name"]
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
		
		
		if($_POST["operation"] == "Edit")
		{
			
			$statement = $connection->prepare(
			"UPDATE attrib_list 
			SET attrib_name = :attrib_name
			WHERE attrib_id = :attrib_id
			"
			);
			$result = $statement->execute(
			array(
			':attrib_name' => $_POST["attrib_name"],
			':attrib_id' => $_POST["attrib_id"]
			)
			);
			if(!empty($result))
			{
				echo 'Data Updated';
			}
		}
		
		
		
		
		
		
		
		if($_POST["operation"] == "add_attrib_val")
		{
			$statement = $connection->prepare(
			"INSERT INTO attrib_val_list (attrib_id, attrib_val) VALUES (:attrib_id, :attrib_val) " );
			
			$result = $statement->execute(
			array(
			':attrib_id' => $_POST["attrib_id"],
			':attrib_val' => $_POST["attrib_value"]
			)
			);
			
			if(!empty($result))
			{
				echo 'Attribute value added';
			}
			else
			{
				//echo( $result->error);
				print_r($statement->errorInfo());
			}
			
		}
		
		
		
		if($_POST["operation"] == "Edit_attrib_value")
		{
			$statement = $connection->prepare(
			"UPDATE attrib_val_list SET attrib_val = :attrib_val WHERE attrib_val_id = :attrib_val_id" );
			
			$result = $statement->execute(
			array(
			':attrib_val' => $_POST["attrib_value"],
			':attrib_val_id' => $_POST["attrib_id"]
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