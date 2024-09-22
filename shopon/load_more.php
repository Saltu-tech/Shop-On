<?php 
	include('./asset/db.php');
	session_start();
	if(!isset($_SESSION['user_id'])){
		$_SESSION['alert'] = "Log in first To continue";
		header('Location:./login.php?redirect='.$_SERVER['REQUEST_URI']);
	}
	
	if($_POST["operation"] == "shop_data")
	{
		$_SESSION['shop_count'] = $_SESSION['shop_count'] + 3;
		$query = $_SESSION['query1'];
		$query .= " OFFSET $_SESSION[shop_count]";
		$statement = $connection->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		
		$output = '';
		
		foreach ($result as $row)
		{
			$output .= "<div class='card mx-auto my-3' style='width: 18rem;'>
			<img class='card-img-top' style='width:auto; height:200px' src='./image/{$row["img_path"] }'>
			<div class='card-body'>
			<table class='table borderless'>
			<colgroup>
			<col span='1' style='width: 70%;'>
			<col span='1' style='width: 30%;'>
			</colgroup>
			<tbody>
			<tr>
			<td> {$row["shop_name"] }</td>
			<td> <a  href='./shop_page.php?shop_id={$row['shop_id']}' class='btn btn-success btn-sm'>View provider</a> </td>
			</tr>
			<tr>";
			
			if($row['shop_type'] ==0) {
				$output .= "<td>".$row['building']." ".$row['locality']."</td>";
			} 
			else {
				$output .= "<td>{$row["mobile"] }</td>";
			}
			$output .=	"<td>".round( $row['distance'], 2). "Km </td>"; 
			$output .=					"</tr>
			</tbody>
			</table>
			</div>
			
			</div>";
		}
		
		echo $output;
	}
	else if($_POST["operation"] == "prod_data")
	{
		$_SESSION['prod_count'] = $_SESSION['prod_count'] + 3;
		$query = $_SESSION['query2'];
		$query .= " OFFSET $_SESSION[prod_count]";
		$statement = $connection->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		
		$output = '';
		
		foreach ($result as $row)
		{
			$output .= "<div class='card mx-auto my-3' style='width: 18rem;'>
							<img class='card-img-top' style='width:auto; height:200px' src='./image/{$row['img_path']}'>
							<div class='card-body'>
								<table class='table borderless'>
									<colgroup>
										<col span='1' style='width: 70%;'>
										<col span='1' style='width: 30%;'>
									</colgroup>
									<tbody>
										<tr>
											<td> {$row['prod_name'] }</td>
											<td> ₹ {$row['price'] } </td>
										</tr>
										<tr>
											<td> {$row['shop_name'] } </td>";
			$output .= "<td>".round($row['distance'], 2)." Km <a href='./product_page.php?prod_id={$row['sp_pid']}' class='btn btn-success btn-sm'>View Product</a> </td>";
			$output .= "</tr>
									</tbody>
								</table>
							</div>
							
						</div>";
		}
		
		echo $output; 
	}
	
	
	
	
	
	
	
	
	?>
	
