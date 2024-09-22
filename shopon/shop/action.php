<?php
	include('../asset/db.php');
	
	
	
	function upload_image()
	{
		if(isset($_FILES["shop_image"]))
		{
			$extension = explode('.', $_FILES['shop_image']['name']);
			$new_name = uniqid() . '.' . $extension[1];
			$destination = '../image/' . $new_name;
			move_uploaded_file($_FILES['shop_image']['tmp_name'], $destination);
			return $new_name;
		}
	} 
	if(isset($_POST["operation"]))
	{
		
		if($_POST["operation"] == "addshop_image")
		{
			$image = '';
			if($_FILES["shop_image"]["name"] != '')
			{
				$image = upload_image();
			}
			
			$statement = $connection->prepare("
			INSERT INTO shop_img (shop_id, img_path, img_type) 
			VALUES (:shop_id, :img_path, :img_type)
			");
			$result = $statement->execute(
			array(
			':shop_id' => $_POST["shop_id"],
			':img_path'  => $image,
			':img_type'  => $_POST["img_type"]
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
	}
	
	
	
	
	
	if(isset($_POST["img_id"]) && isset($_POST["img_path"]))
	{
		
		$image = $_POST["img_path"];
		unlink("../image/" . $image);
		
		$statement = $connection->prepare(
		"DELETE FROM shop_img WHERE img_id = :img_id"
		);
		$result = $statement->execute(
		array(
		':img_id' => $_POST["img_id"]
		)
		);
		
		if(!empty($result))
		{
			echo 'Image Deleted';
		}
	}
	
?>