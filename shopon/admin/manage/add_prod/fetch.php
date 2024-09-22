<?php
	include('../../../asset/db.php');
	include('function.php');
	$query = '';
	$output = array();
	$query .= "SELECT product.*, prod_mfrs.* FROM `product`  
	LEFT JOIN `prod_mfrs` ON `product`.`mfrs` = `prod_mfrs`.`mfrs_id` ";
	if(isset($_POST["search"]["value"]))
	{
		$query .= 'WHERE product.prod_name LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR product.prod_desc LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR prod_mfrs.name LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY product.prod_id DESC ';
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
		$query2 = "SELECT * FROM `prod_attrib` INNER JOIN attrib_val_list ON prod_attrib.attrib_val_id = attrib_val_list.attrib_val_id 
		INNER JOIN attrib_list ON attrib_val_list.attrib_id = attrib_list.attrib_id WHERE prod_id = '$row[prod_id]' ";
		$statement2 = $connection->prepare($query2);
		$statement2->execute();
		$result2 = $statement2->fetchAll();
		
		$query3 = "SELECT * FROM prod_image WHERE prod_id = '$row[prod_id]' ";
		$statement3 = $connection->prepare($query3);
		$statement3->execute();
		$result3 = $statement3->fetchAll();
		
		
		
		$query5 = "SELECT * FROM prod_feat WHERE prod_id = '$row[prod_id]' ";
		$statement5 = $connection->prepare($query5);
		$statement5->execute();
		$result5 = $statement5->fetchAll();
		
		
		
		
		
		
		
		$sub_array = array();
		$sub_array[] = null ; 
		$sub_array[] = $row["prod_name"];
		$sub_array[] = "₹ ".$row["prod_price"];
		$sub_array[] = $row["prod_desc"];
		$sub_array[] = $row["keyword"];
		$sub_array[] = $row["name"];
		
		if($row["type"] == 0) 
		{
			$sub_array[] = 'service';
		} else if( $row["type"] == 1)
		{
			$sub_array[] = 'product';
		}
		$sub_array[] = '<button type="button" name="update" id="'.$row["prod_id"].'"  
		prod_name="'.$row["prod_name"].'" prod_price="'.$row["prod_price"].'" prod_desc="'.$row["prod_desc"].'" 
		keyword="'.$row["keyword"].'" mfrs_id="'.$row["mfrs"].'" service_type="'.$row["type"].'" 
		class="btn btn-warning btn-xs update">Update</button>';
		$sub_array[] = $row["prod_id"];
		
		$data2 = array();
		foreach($result2 as $row2)
		{
			$subs_array = array();
			$subs_array[] = $row2["attrib_name"];
			$subs_array[] = $row2["attrib_val"];
			$subs_array[] = '<button type="button" name="delete" idn="'.$row2["attrib_val_id"].'"  id="'.$row2["prod_attrib_id"].'" class="btn btn-danger btn-xs delete_attrib">Delete</button>';
			$data2[] = $subs_array;
			
		}
		$sub_array[] = $data2;	
		
		$data3 = array();
		foreach($result3 as $row3)
		{
			$subs2_array = array();
			$subs2_array[] = $row3["img_path"];
			$subs2_array[] = '<button type="button" name="delete" id="'.$row3["img_id"].'" img_path="'.$row3["img_path"].'" class="btn btn-danger btn-xs delete_img">Delete</button>';
			$data3[] = $subs2_array;
			
		}
		$sub_array[] = $data3;	
		
		
		
		
		$data5 = array();
		foreach($result5 as $row5)
		{
			$subs4_array = array();
			$subs4_array[] = $row5["feature"];
			$subs4_array[] = '<button type="button" name="delete" id="'.$row5["feat_id"].'"  class="btn btn-danger btn-xs delete_feat">Delete</button>';
			$data5[] = $subs4_array;
			
		}
		$sub_array[] = $data5;
		
		
		
		$data[] = $sub_array;
		//print_r($sub_array[11]);
	}
	//print_r($data[0][11]);
	$output = array(
	"draw"    => intval($_POST["draw"]),
	"recordsTotal"  => $filtered_rows,
	"recordsFiltered" =>  get_total_all_records(),
	"data"    => $data
	);
	echo json_encode($output);
?>	