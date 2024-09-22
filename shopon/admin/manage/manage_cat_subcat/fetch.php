<?php
	include('../../../asset/db.php');
	include('function.php');
	$query = '';
	$output = array();
	$query .= "SELECT * FROM `category`";
	if(isset($_POST["search"]["value"]))
	{
		$query .= 'WHERE category.cat_name LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY category.cat_name ASC ';
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
		
		$query2 = "SELECT * FROM `subcategory` WHERE subcategory.cat_id = '$row[cat_id]'  ";
		$statement2 = $connection->prepare($query2);
		$statement2->execute();
		$result2 = $statement2->fetchAll();
		
		$sub_array = array();
		$sub_array[] = null ; 
		$sub_array[] = $row["cat_name"];
		$sub_array[] = '<button type="button" name="update" id="'.$row["cat_id"].'" cat_name="'.$row["cat_name"].'" 
		                 class="btn btn-warning btn-xs update">Update</button>'; 
		$sub_array[] = $row["cat_id"];
		
		$data2 = array();
		foreach($result2 as $row2)
		{
			$subs_array = array();
			$subs_array[] = $row2["subcat_name"];
			$subs_array[] = '<button type="button" name="update" idn="'.$row2["subcat_name"].'"  id="'.$row2["subcat_id"].'"  class="btn btn-warning btn-xs update_subcat">Update</button>';
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