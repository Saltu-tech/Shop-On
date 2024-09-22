<?php
	include('../../../asset/db.php');
	include('function.php');
	$query = '';
	$output = array();
	$query .= "SELECT * FROM `attrib_list`";
	if(isset($_POST["search"]["value"]))
	{
		$query .= 'WHERE attrib_list.attrib_name LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY attrib_list.attrib_name ASC ';
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
		
		$query2 = "SELECT * FROM `attrib_val_list` WHERE attrib_val_list.attrib_id = '$row[attrib_id]'  ";
		$statement2 = $connection->prepare($query2);
		$statement2->execute();
		$result2 = $statement2->fetchAll();
		
		$sub_array = array();
		$sub_array[] = null ; 
		$sub_array[] = $row["attrib_name"];
		$sub_array[] = '<button type="button" name="update" id="'.$row["attrib_id"].'" attrib_name="'.$row["attrib_name"].'" 
		                 class="btn btn-warning btn-xs update">Update</button>'; 
		$sub_array[] = $row["attrib_id"];
		
		$data2 = array();
		foreach($result2 as $row2)
		{
			$subs_array = array();
			$subs_array[] = $row2["attrib_val"];
			$subs_array[] = '<button type="button" name="update" idn="'.$row2["attrib_val"].'"  id="'.$row2["attrib_val_id"].'"  class="btn btn-warning btn-xs update_attribval">Update</button>';
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