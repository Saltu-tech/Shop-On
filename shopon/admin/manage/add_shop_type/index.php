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
			<h1 align="center"><?= $_SESSION['name'] ?>'s Shop Type Management</h1>
			<br />
			<div class="table-responsive">
				<br />
				<div align="right">
					<button type="button" id="add_shopcat" data-toggle="modal" data-target="#shopcatModal" class="btn btn-info btn-lg">Add Shop Category</button>
				</div>
				
				<br /><br />
				<table id="shopcat_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="10%"> </th> 
							<th width="70%">Shop Category Name</th>
							<th width="20%">Desc</th>
							<th width="20%">Keyword</th>
							<th width="20%">Edit</th>
							
						</tr>
					</thead>
				</table>
				
			</div>
		</div>
	</body> 
</html>












<div id="shopcatModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="shopcat_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Shop category</h4>
				</div>
				<div class="modal-body">
					
					<label>Add  Name</label>
					<input type="text" name="shopcat_name" id="shopcat_name" class="form-control" />
					<br />
					<label>Add Desc</label>
					<input type="text" name="shopcat_desc" id="shopcat_desc" class="form-control" />
					<br />
					<label>Add Keyword</label>
					<input type="text" name="shopcat_keyword" id="shopcat_keyword" class="form-control" />
					<br />
					
					
				</div>
				<div class="modal-footer">
					
					<input type="hidden" name="operation" id="operation" />
					<input type="hidden" name="shopcat_id" id="shopcat_id" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add Attribute" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>






<script type="text/javascript" language="javascript" >
	$(document).ready(function(){
		
		
		$('#add_shopcat').click(function(){
			$('#shopcat_form')[0].reset();
			$('.modal-title').text("Add ShopCategory");
			$('#action').val("Add ShopCategory");
			$('#operation').val("add_shopcat");
		});
		
		
		
		
		
	
		var dataTable = $('#shopcat_data').DataTable({
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
		
		
		
		
		
		
		$(document).on('submit', '#shopcat_form', function(event){
			event.preventDefault();
			var shopcat_name = $('#shopcat_name').val();
			var shopcat_desc = $('#shopcat_desc').val();
			var shopcat_keyword = $('#shopcat_keyword').val();
			
			
			if(shopcat_name != '' && shopcat_desc != '' && shopcat_keyword != '')
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
						$('#shopcat_form')[0].reset();
						$('#shopcatModal').modal('hide');
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
			var shopcat_id = $(this).attr("id");
			var shopcat_name = $(this).attr("cat_name");
			var shopcat_desc = $(this).attr("descp");
			var shopcat_keyword = $(this).attr("keyword");
			
			
			$('#shopcatModal').modal('show');
			
			
			$('#shopcat_name').val(shopcat_name);
			$('#shopcat_desc').val(shopcat_desc);
			$('#shopcat_keyword').val(shopcat_keyword);
			
			$('.modal-title').text("Update Shop category");
			$('#shopcat_id').val(shopcat_id);
			$('#action').val("Edit");
			$('#operation').val("Edit");
			
			
		});
		
		
		
		
		
		$('#shopcat_data tbody').on('click', 'td.details-control', function() {
			
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
			$.each(d[5],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td>' +d[5][index][0]+'</td>';
				child_row += '<td>' +d[5][index][1]+'</td>';
				child_row += '<td>' +d[5][index][2]+'</td>';
				child_row += '<td>' +d[5][index][3]+'</td>';
				child_row += '</tr>'
				
			});	
			
			
			child_row += '</table>';
			child_row +=  '</div>';
			
			return child_row;
			
			
		} 
		
		
	});
</script>					