<?php
	include('../../../asset/db.php');
	include('function.php');
	$query = '';
	$output = array();
	$query .= "SELECT * FROM `shop_cat`";
	if(isset($_POST["search"]["value"]))
	{
		$query .= 'WHERE shop_cat.name LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY shop_cat.name ASC ';
	}
	if( $_POST["length"] != -1)
	{
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	} 
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	//print_r($result);
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{
		
		$query2 = "SELECT * FROM `shop` WHERE shop.shop_cat_id = '$row[shop_cat_id]'  ";
		$statement2 = $connection->prepare($query2);
		$statement2->execute();
		$result2 = $statement2->fetchAll();
		
		$sub_array = array();
		$sub_array[] = null ; 
		$sub_array[] = $row["name"];
		$sub_array[] = $row["descp"];
		$sub_array[] = $row["keyword"];
		$sub_array[] = '<button type="button" name="update" id="'.$row["shop_cat_id"].'" cat_name="'.$row["name"].'" descp="'.$row["descp"].'" keyword="'.$row["keyword"].'"
		                 class="btn btn-warning btn-xs update">Update</button>'; 
		
		$data2 = array();
		foreach($result2 as $row2)
		{
			$subs_array = array();
			if($row2["shop_type"] == 0)
			{
				$subs_array[] = 'Virtual';
			}
			else if($row2["shop_type"] == 1) 
			{
				$subs_array[] = 'Physical';
			}
			$subs_array[] = $row2["shop_name"];
			$subs_array[] = '<ul class="list-unstyled">
			                 <li>'.$row2["building"].'</li>
							 <li>'.$row2["locality"].'</li>
							 <li>'.$row2["city"].' '.$row2["state"].'  '.$row2["pin"].' </li>
							 </ul>';
			$subs_array[] = $row2["lat"].' '.$row2["longt"].' '.$row2["ranged"].' km';
			$data2[] = $subs_array;
			
		}
		$sub_array[] = $data2;	
		
		
		
		$data[] = $sub_array;
	}
	$output = array(
	"draw"    => intval($_POST["draw"]),
	"recordsTotal"  =>  $filtered_rows,
	"recordsFiltered" => get_total_all_records(),
	"data"    => $data
	);
	echo json_encode($output);
?>