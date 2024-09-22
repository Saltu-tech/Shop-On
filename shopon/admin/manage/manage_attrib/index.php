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
		<title>Manage Attribute | ShopOn</title>
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
			<h1 align="center"><?= $_SESSION['name'] ?>'s Attribute Management</h1>
			<br />
			<div class="table-responsive">
				<br />
				<div align="right">
					<button type="button" id="add_attrib" data-toggle="modal" data-target="#attribModal" class="btn btn-info btn-lg">Add Attribute</button>
				</div>
				
				<br /><br />
				<table id="attrib_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="10%"> </th> 
							<th width="70%">Attrib Name</th>
							<th width="20%">Edit</th>
							
						</tr>
					</thead>
				</table>
				
			</div>
		</div>
	</body> 
</html>












<div id="attribModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="attrib_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Attribute</h4>
				</div>
				<div class="modal-body">
					
					<label>Attribute Name</label>
					<input type="text" name="attrib_name" id="attrib_name" class="form-control" />
					<br />
					
					
				</div>
				<div class="modal-footer">
					
					<input type="hidden" name="operation" id="operation" />
					<input type="hidden" name="attrib_id" id="attrib_id" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add Attribute" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>



<div id="attribvalueModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="attribvalue_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add attribute</h4>
				</div>
				<div class="modal-body">
					
					<label>Attribute value</label>
					<input type="text" name="attrib_value" id="attrib_value" class="form-control" />
					<br />
					
				</div>
				<div class="modal-footer">
					<input type="hidden" name="operation" id="operation2" />
					<input type="hidden" name="attrib_id" id="attrib_idv" />
					<input type="submit" name="action" id="action2" class="btn btn-success" value="Add Attribute value" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>


<script type="text/javascript" language="javascript" >
	$(document).ready(function(){
		
		
		$('#add_attrib').click(function(){
			$('#attrib_form')[0].reset();
			$('.modal-title').text("Add Supplier");
			$('#action').val("Add Attribute");
			$('#operation').val("add_attrib");
		});
		
		$(document).on('click', '.add_attrib_val', function(){
			var attrib_id = $(this).attr("id");
			var supp_n = $(this).attr("idn");
			$('#attribvalue_form')[0].reset();
			$('#prod_id').attr("readonly", false);
			$('.modal-title').text("Add Attribute value for " +supp_n);
			$('#action2').val("Add Attribute Val");
			$('#operation2').val("add_attrib_val");
			$('#attrib_idv').val(attrib_id);
			
		});
		
		
		
	
		var dataTable = $('#attrib_data').DataTable({
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
		
		
		
		
		
		
		$(document).on('submit', '#attrib_form', function(event){
			event.preventDefault();
			var attrib_name = $('#attrib_name').val();
			
			
			if(attrib_name != '')
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
						$('#attrib_form')[0].reset();
						$('#attribModal').modal('hide');
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
			var attrib_id = $(this).attr("id");
			var attrib_name = $(this).attr("attrib_name");
			
			
			$('#attribModal').modal('show');
			
			$('#attrib_name').val(attrib_name);
			
			$('.modal-title').text("Update Attrib name");
			$('#attrib_id').val(attrib_id);
			$('#action').val("Edit");
			$('#operation').val("Edit");
			
			
		});
		
		
		$(document).on('submit', '#attribvalue_form', function(event){
			event.preventDefault();
			var attrib_value = $('#attrib_value').val();
			
			
			if(attrib_value != '' )
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
						$('#attribvalue_form')[0].reset();
						$('#attribvalueModal').modal('hide');
						dataTable.ajax.reload();
					}
				});
			}
			else
			{
				alert("All Fields are Required");
			} 
		});
		
		
		
		
		
		
		$(document).on('click', '.update_attribval', function(){
			var attrib_val_id = $(this).attr("id");
			var attrib_val = $(this).attr("idn");
			$('#attribvalueModal').modal('show');
			
			
			$('#attrib_idv').val(attrib_val_id);
			$('#attrib_value').val(attrib_val);
			
			$('.modal-title').text("Update Attrib value");
			$('#action2').val("Edit Attrib value");
			$('#operation2').val("Edit_attrib_value");
			
			
			
		});
		
		
		
	
		
		
		
		
		
		$('#attrib_data tbody').on('click', 'td.details-control', function() {
			
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
			child_row += '<tr><td><button type="button" id="'+d[3]+'" idn="'+d[1]+'" data-toggle="modal" data-target="#attribvalueModal" class="btn btn-success btn-xs add_attrib_val">Add attribute value</button></td></tr>';
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