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
			<h1 align="center"><?= $_SESSION['name'] ?>'s Manufacturer Management</h1>
			<br />
			<div class="table-responsive">
				<br />
				<div align="right">
					<button type="button" id="add_mfrs" data-toggle="modal" data-target="#mfrsModal" class="btn btn-info btn-lg">Add Manufacturer</button>
				</div>
				
				<br /><br />
				<table id="mfrs_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="10%"> </th> 
							<th width="20%">Manufacturer Name</th>
							<th width="20%">Address</th>
							<th width="15%">Mobile</th>
							<th width="20%">Email</th>
							<th width="15%">Edit</th>
							
						</tr>
					</thead>
				</table>
				
			</div>
		</div>
	</body> 
</html>












<div id="mfrsModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="mfrs_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Manufacturer</h4>
				</div>
				<div class="modal-body">
					
					<label>Add  Name</label>
					<input type="text" name="mfrs_name" id="mfrs_name" class="form-control" />
					<br />
					<label>Add Address</label>
					<input type="text" name="mfrs_add" id="mfrs_add" class="form-control" />
					<br />
					<label>Add mobile</label>
					<input type="text" name="mfrs_mobile" id="mfrs_mobile" class="form-control" />
					<br />
					<label>Add Email</label>
					<input type="text" name="mfrs_email" id="mfrs_email" class="form-control" />
					<br />
					<label>Add Password</label>
					<input type="password" name="mfrs_pswd" id="mfrs_pswd" class="form-control" />
					<br />
					
					
				</div>
				<div class="modal-footer">
					
					<input type="hidden" name="operation" id="operation" />
					<input type="hidden" name="mfrs_id" id="mfrs_id" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add Manufacturer" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>






<script type="text/javascript" language="javascript" >
	$(document).ready(function(){
		
		
		$('#add_mfrs').click(function(){
			$('#mfrs_form')[0].reset();
			$('.modal-title').text("Add Manufacturer");
			$('#action').val("Add Manufacturer");
			$('#operation').val("add_mfrs");
		});
		
		
		
		
		
	
		var dataTable = $('#mfrs_data').DataTable({
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
		
		
		
		
		
		
		$(document).on('submit', '#mfrs_form', function(event){
			event.preventDefault();
			var mfrs_name = $('#mfrs_name').val();
			var mfrs_add = $('#mfrs_add').val();
			var mfrs_mobile = $('#mfrs_mobile').val();
			var mfrs_email = $('#mfrs_email').val();
			var mfrs_pswd = $('#mfrs_pswd').val();
			
			
			if(mfrs_name != '' && mfrs_add != '' && mfrs_mobile != '' && mfrs_email != '' && mfrs_pswd != '')
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
						$('#mfrs_form')[0].reset();
						$('#mfrsModal').modal('hide');
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
			var mfrs_id = $(this).attr("id");
			var mfrs_name = $(this).attr("mfrs_name");
			var mfrs_add = $(this).attr("address");
			var mfrs_mobile = $(this).attr("mobile");
			var mfrs_email = $(this).attr("email");
			
			
			
			$('#mfrsModal').modal('show');
			
			
			$('#mfrs_name').val(mfrs_name);
			$('#mfrs_add').val(mfrs_add);
			$('#mfrs_mobile').val(mfrs_mobile);
			$('#mfrs_email').val(mfrs_email);
			$('#mfrs_pswd').attr('readonly', true);
			
			
			
			$('.modal-title').text("Update Manufacturer");
			$('#mfrs_id').val(mfrs_id);
			$('#action').val("Edit");
			$('#operation').val("Edit");
			
			
		});
		
		
		
		
		
		$('#mfrs_data tbody').on('click', 'td.details-control', function() {
			
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
			$.each(d[6],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td>' +d[6][index][0]+'</td>';
				child_row += '<td>' +d[6][index][1]+'</td>';
				child_row += '<td>' +d[6][index][2]+'</td>';
				child_row += '</tr>'
				
			});	
			
			
			child_row += '</table>';
			child_row +=  '</div>';
			
			return child_row;
			
			
		} 
		
		
	});
</script>					