<?php
	include('./asset/db.php');
	session_start();
	
	if($_POST["operation"] == "set_location")
	{
		
		$statement = $connection->prepare("SELECT * FROM user WHERE user_id = '$_SESSION[user_id]'");
		$statement->execute();
		$result2 = $statement->fetchAll();
		
		
		
		$statement = $connection->prepare("
		UPDATE user SET lat = :lat, longt = :longt WHERE user_id = :user_id
		");
		$result = $statement->execute(
		array(
		':lat' => $_POST["lat"],
		':longt' => $_POST["long"],
		':user_id' => $_SESSION["user_id"]
		)
		);
		
		
		
		
		if($result2[0]['lat'] == null || $result2[0]['longt'] == null || $result2[0]['lat'] != round($_POST['lat'], 6) || $result2[0]['longt'] != round($_POST['long'], 6))
		{
			
			$statement = $connection->prepare("
			INSERT INTO user_loc_hist (user_id, lat, longt) VALUES (:user_id, :lat, :longt)
			");
			$result3 = $statement->execute(
			array(
			':lat' => $_POST["lat"],
			':longt' => $_POST["long"],
			':user_id' => $_SESSION['user_id']
			)
			); 
		}
		if(!empty($result))
		{
			echo 'Location set';
		}
		else
		{
			print_r($statement->errorInfo());
		}
	}
	
	
	
	
	
	
	
	
	
	
	
?>	