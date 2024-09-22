<?php
	include('../../../asset/db.php');
	session_start();
	if(!isset($_SESSION['admin_id'])){
		$_SESSION['alert'] = "Log in first To continue to Admin Panel";
		header('Location:../../?redirect='.$_SERVER['REQUEST_URI']);
	}
?>	



<html>
	<head>
		<title>Manage category & Subcategory | ShopOn</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
			<h1 align="center"><?= $_SESSION['name'] ?>'s Category & Subcategory Management</h1>
			<br />
			<div class="table-responsive">
				<br />
				<div align="right">
					<button type="button" id="add_cat" data-toggle="modal" data-target="#catModal" class="btn btn-info btn-lg">Add Category</button>
				</div>
				
				<br /><br />
				<table id="cat_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="10%"> </th> 
							<th width="70%">Category Name</th>
							<th width="20%">Edit</th>
							
						</tr>
					</thead>
				</table>
				
			</div>
		</div>
	</body> 
</html>












<div id="catModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="cat_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add category</h4>
				</div>
				<div class="modal-body">
					
					<label>Category Name</label>
					<input type="text" name="cat_name" id="cat_name" class="form-control" />
					<br />
					
					
				</div>
				<div class="modal-footer">
					
					<input type="hidden" name="operation" id="operation" />
					<input type="hidden" name="cat_id" id="cat_id" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add category" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>



<div id="subcatModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="subcat_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Subcategory</h4>
				</div>
				<div class="modal-body">
					
					<label>Subcategory</label>
					<input type="text" name="subcat_name" id="subcat_name" class="form-control" />
					<br />
					
				</div>
				<div class="modal-footer">
					<input type="hidden" name="operation" id="operation2" />
					<input type="hidden" name="cat_id" id="cat_idv" />
					<input type="submit" name="action" id="action2" class="btn btn-success" value="Add Subcategory" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>


<script type="text/javascript" language="javascript" >
	$(document).ready(function(){
		
		
		$('#add_cat').click(function(){
			$('#cat_form')[0].reset();
			$('.modal-title').text("Add Category");
			$('#action').val("Add Category");
			$('#operation').val("add_cat");
		});
		
		$(document).on('click', '.add_subcat_val', function(){
			var cat_id = $(this).attr("id");
			var cat_n = $(this).attr("idn");
			$('#subcat_form')[0].reset();
			
			$('.modal-title').text("Add subcategory for " +cat_n);
			$('#action2').val("Add subcategory Val");
			$('#operation2').val("add_subcat_val");
			$('#cat_idv').val(cat_id);
			
		});
		
		
		
	
		var dataTable = $('#cat_data').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"fetch.php",
				type:"POST"
			},
			"columnDefs":[
			{
				"targets":[0],
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
		
		
		
		
		
		
		$(document).on('submit', '#cat_form', function(event){
			event.preventDefault();
			var cat_name = $('#cat_name').val();
			
			
			if(cat_name != '')
			{
				$.ajax({
					url:"insert.php",
					method:'POST',
					data:new FormData(this),
					contentType:false,
					processData:false,
					success:function(data)
					{
						alert(data);
						$('#cat_form')[0].reset();
						$('#catModal').modal('hide');
						dataTable.ajax.reload();
						
					}
				});
			}
			else
			{
				alert("All Fields are Required");
			} 
		});
		
		$(document).on('click', '.update', function(){
			var cat_id = $(this).attr("id");
			var cat_name = $(this).attr("cat_name");
			
			
			$('#catModal').modal('show');
			
			$('#cat_name').val(cat_name);
			
			$('.modal-title').text("Update Attrib name");
			$('#cat_id').val(cat_id);
			$('#action').val("Edit");
			$('#operation').val("Edit");
			
			
		});
		
		
		$(document).on('submit', '#subcat_form', function(event){
			event.preventDefault();
			var subcat_name = $('#subcat_name').val();
			
			
			if(subcat_name != '' )
			{
				$.ajax({
					url:"insert.php",
					method:'POST',
					data:new FormData(this),
					contentType:false,
					processData:false,
					success:function(data)
					{
						alert(data);
						$('#subcat_form')[0].reset();
						$('#subcatModal').modal('hide');
						dataTable.ajax.reload();
					}
				});
			}
			else
			{
				alert("All Fields are Required");
			} 
		});
		
		
		
		
		
		
		$(document).on('click', '.update_subcat', function(){
			var subcat_id = $(this).attr("id");
			var subcat_name = $(this).attr("idn");
			$('#subcatModal').modal('show');
			
			
			$('#cat_idv').val(subcat_id);
			$('#subcat_name').val(subcat_name);
			
			$('.modal-title').text("Update Subcategory");
			$('#action2').val("Edit Subcategory");
			$('#operation2').val("Edit_subcat_name");
			
			
			
		});
		
		
		
	
		
		
		
		
		
		$('#cat_data tbody').on('click', 'td.details-control', function() {
			
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
			child_row += '<tr><td><button type="button" id="'+d[3]+'" idn="'+d[1]+'" data-toggle="modal" data-target="#subcatModal" class="btn btn-success btn-xs add_subcat_val">Add Subcategory</button></td></tr>';
			$.each(d[4],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td>' +d[4][index][0]+'</td>';
				child_row += '<td>' +d[4][index][1]+'</td>';
				child_row += '</tr>'
				
			});	
			
			
			child_row += '</table>';
			child_row +=  '</div>';
			
			return child_row;
			
			
		} 
		
		
	});
</script>					