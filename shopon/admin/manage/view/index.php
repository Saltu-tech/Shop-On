<?php
	include('../../../asset/db.php');
	session_start();
	if(!isset($_SESSION['admin_id'])){
		$_SESSION['alert'] = "Log in first To continue to Admin Panel";
		header('Location:../../?redirect='.$_SERVER['REQUEST_URI']);
	}
	
	
	$query = "SELECT * FROM `category`";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	
	
	$query2 = "SELECT * FROM `subcategory`";
	$statement2 = $connection->prepare($query2);
	$statement2->execute();
	$result2 = $statement2->fetchAll();
	
	
	
?>	



<html>
	<head>
		<title>Manage Product | ShopOn</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
		
		
		
		
		
		
		<style>
			body
			{
			margin:0;
			padding:0;
			background-color:#f1f1f1;
			}
			.box
			{
			width:1270px;
			padding:20px;
			background-color:#fff;
			border:1px solid #ccc;
			border-radius:5px;
			margin-top:25px;
			}
			td.details-control {
			background:url('../../../asset/details_open.png') no-repeat center center; 
			cursor: pointer;
			
			}
			tr.shown td.details-control{
			background: url('../../../asset/details_close.png') no-repeat center center;
			}
			
			div.slider {
			display:none;
			}
			
			table.dataTable tbody td.no-padding {
			padding:0;
			}
		</style>
	</head>
	<body>
		<div class="container box">
			<a href="../"> Home </a>
			<h1 align="center"><?= $_SESSION['name'] ?>'s Admin Product Management</h1>
			<br />
			
			<center>
				
				<select class="custome-select" id="category" >
					<option value="0" selected>Please Select</option>
					<?php foreach($result as $row) { ?>
						<option value="<?=$row['cat_id'] ?>"><?= $row['cat_name'] ?> </option>
					<?php }  ?>
					
				</select>
				
				<select class="custome-select" id="subcat" style="display:none">
					
					
				</select> 
			</center>
			
			<div class="table-responsive">
				
				<table id="product_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="5%"> </th> 
							<th width="20%">Product Name</th>
							<th width="10%">Product Price</th>
							<th width="30%">Product Desc</th>
							<th width="5%">Keyword</th>
							<th width="10%">Manufactrer</th>
							<th width="10%">Type(Pro/ Service)</th>
							
						</tr>
					</thead>
				</table>
				
			</div>
		</div>
	</body>
</html>








<script type="text/javascript" language="javascript" >
	
	var subcategory = <?= json_encode($result2) ?>;
	var subcat_id = null;
	
	$(document).ready(function(){
		show_data();
	});
	
	
	$(function(){
		$("#category").change(function(){
			if($(this).val() == '0')
			{
				$("#subcat").hide();
				$("#subcat").val('0');
				if(subcat_id != null)
				{
					subcat_id = null;
					if ($.fn.dataTable.isDataTable('#product_data'))
					{
						
						$('#product_data').DataTable().destroy();
					}
					show_data();
				}
				
			} else 
			{
				var cat_id = $(this).val();
				var subcat_name = '';
				subcat_name += '<option value="0" selected>Please Select</option>'
				$.each(subcategory, function(index){
					if(subcategory[index][1] == cat_id)
					{
						subcat_name += '<option value="'+subcategory[index][0]+'">'+subcategory[index][2]+'</option>';
					}
					
				});
				
				$("#subcat").html(subcat_name);
				$("#subcat").show();
				
				if(subcat_id != null)
				{
					subcat_id = null;
					if ($.fn.dataTable.isDataTable('#product_data'))
					{
						
						$('#product_data').DataTable().destroy();
					}
					show_data();
				}
			}
		});
		
		
		$("#subcat").change(function(){
			if($(this).val() == '0')
			{
				if(subcat_id != null)
				{
					subcat_id = null;
					if ($.fn.dataTable.isDataTable('#product_data'))
					{
						
						$('#product_data').DataTable().destroy();
					}
					show_data();
				}
				
			} else 
			{
				subcat_id = $(this).val();
				
				if ($.fn.dataTable.isDataTable('#product_data'))
				{
					
					$('#product_data').DataTable().destroy();
					
				}
				show_data();
			}
		});
	});
	
	
	function show_data(){
		
		var dataTable = $('#product_data').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"fetch.php",
				data: {
					"subcat_id" : subcat_id
				},	
				type:"POST"
			},
			"columnDefs":[
			{
				"targets":[0,3,4,5,6],
				"orderable":false
			},
			{
				"className":'details-control',
				"defaultContent": '',
				"data": null,
				"targets" : [0]
			}
			
			],
			
		});
		
		
		
		
		$('#product_data tbody').on('click', 'td.details-control', function() {
			
			var tr = $(this).closest('tr');
			var row = dataTable.row(tr);
			
			if(row.child.isShown() ){
				
				$('div.slider', row.child()).slideUp( function () {
					row.child.hide();
					tr.removeClass('shown');
					
				});
				
				
				
			}
			else {
				row.child(format(row.data()), 'no-padding').show();
				tr.addClass('shown');
				
				$('div.slider', row.child()).slideDown();
			}
			
		}); 
		
		
		
		function format(d) {
			
			
			var child_row  = '<div class="slider">';
			child_row += '<table class="table"  >';
			
			child_row += '<tr><td><b>Attribute</b></td></tr>';
			$.each(d[7],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td>' +d[7][index][0]+'</td>';
				child_row += '<td>' +d[7][index][1]+'</td>';
				child_row += '</tr>'
				
			});	
			
			
			child_row += '<tr><td><b>Feature</b></td></tr>';
			$.each(d[9],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td>' +d[9][index][0]+'</td>';
				child_row += '</tr>'
				
			});
			
			
			child_row += '<tr><td><b>Image</b></td></tr>';
			$.each(d[8],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td><img src="../../../image/'+d[8][index][0]+'" class="img-thumbnail" width="50" height="35" /></td>';
				child_row += '</tr>'
				
			});	
			
			
			
			child_row += '</table>';
			child_row +=  '</div>';
			
			return child_row;
			
			
		}
		
		
	}
</script>					