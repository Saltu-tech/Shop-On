<?php
	include('../../../asset/db.php');
	include('function.php');
	$query = '';
	$output = array();
	if($_POST['subcat_id'] != null)
	{
		$query .= "SELECT product.*, prod_mfrs.* FROM `product` 
		LEFT JOIN `prod_mfrs` ON `product`.`mfrs` = `prod_mfrs`.`mfrs_id` 
		INNER JOIN `subcat_prod` ON `product`.`prod_id` = `subcat_prod`.`prod_id` AND `subcat_prod`.`subcat_id` = '$_POST[subcat_id]' ";
	}
	else 
	{
		
		$query .= "SELECT product.*, prod_mfrs.* FROM `product` 
		LEFT JOIN `prod_mfrs` ON `product`.`mfrs` = `prod_mfrs`.`mfrs_id` ";
	}
	
	
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
		
		$query4 = "SELECT * FROM prod_feat WHERE prod_id = '$row[prod_id]' ";
		$statement4 = $connection->prepare($query4);
		$statement4->execute();
		$result4 = $statement4->fetchAll();
		
		
		
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
		
		
		$data2 = array();
		foreach($result2 as $row2)
		{
			$subs_array = array();
			$subs_array[] = $row2["attrib_name"];
			$subs_array[] = $row2["attrib_val"];
			$data2[] = $subs_array;
			
		}
		$sub_array[] = $data2;	
		
		$data3 = array();
		foreach($result3 as $row3)
		{
			$subs2_array = array();
			$subs2_array[] = $row3["img_path"];
			$data3[] = $subs2_array;
			
		}
		$sub_array[] = $data3;	
		
		
		
		$data4 = array();
		foreach($result4 as $row4)
		{
			$subs3_array = array();
			$subs3_array[] = $row4["feature"];
			$data4[] = $subs3_array;
			
		}
		$sub_array[] = $data4;
		
		
		
		
		
		$data[] = $sub_array;
		//print_r($sub_array[11]);
	}
	//print_r($data[0][11]);
	$output = array(
	"draw"    => intval($_POST["draw"]),
	"recordsTotal"  => get_total_all_records(),
	"recordsFiltered" =>  $filtered_rows,
	"data"    => $data
	);
	echo json_encode($output);
?>							