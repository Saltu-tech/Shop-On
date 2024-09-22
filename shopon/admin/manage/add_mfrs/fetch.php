<?php
	include('../../../asset/db.php');
	include('function.php');
	$query = '';
	$output = array();
	$query .= "SELECT * FROM `prod_mfrs`";
	if(isset($_POST["search"]["value"]))
	{
		$query .= 'WHERE prod_mfrs.name LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY prod_mfrs.name ASC ';
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
		
		$query2 = "SELECT * FROM `product` WHERE product.mfrs = '$row[mfrs_id]'  ";
		$statement2 = $connection->prepare($query2);
		$statement2->execute();
		$result2 = $statement2->fetchAll();
		
		$sub_array = array();
		$sub_array[] = null ; 
		$sub_array[] = $row["name"];
		$sub_array[] = $row["address"];
		$sub_array[] = $row["mobile"];
		$sub_array[] = $row["email"];
		$sub_array[] = '<button type="button" name="update" id="'.$row["mfrs_id"].'" mfrs_name="'.$row["name"].'" address="'.$row["address"].'" mobile="'.$row["mobile"].'"
		                 email="'.$row["email"].'" class="btn btn-warning btn-xs update">Update</button>'; 
		
		$data2 = array();
		foreach($result2 as $row2)
		{
			$subs_array = array();
			$subs_array[] = $row2["prod_name"];
			$subs_array[] = $row2["prod_price"];
			$subs_array[] = $row2["prod_desc"];
			
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