<?php
	
	include('../../../asset/db.php');
	include("function.php");
	
	
	
	if(isset($_POST["prod_attrib_id"]))
	{
		
		$statement = $connection->prepare(
		"DELETE FROM prod_attrib WHERE prod_attrib_id = :prod_attrib_id"
		);
		$result = $statement->execute(
		array(
		':prod_attrib_id' => $_POST["prod_attrib_id"]
		)
		);
		
		if(!empty($result))
		{
			echo 'Attribute Deleted';
		}
	}
	
	if(isset($_POST["feat_id"]))
	{
		
		$statement = $connection->prepare(
		"DELETE FROM prod_feat WHERE feat_id = :feat_id"
		);
		$result = $statement->execute(
		array(
		':feat_id' => $_POST["feat_id"]
		)
		);
		
		if(!empty($result))
		{
			echo 'Feature Deleted';
		}
	}
	
	if(isset($_POST["img_id"]) && isset($_POST["img_path"]))
	{
		
		$image = $_POST["img_path"];
		unlink("../../image/" . $image);
		
		$statement = $connection->prepare(
		"DELETE FROM prod_image WHERE img_id = :img_id"
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