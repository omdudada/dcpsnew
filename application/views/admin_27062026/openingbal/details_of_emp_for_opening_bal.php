<?php //echo "<pre>";print_r($data);die(); ?>

<div class="searchTable">
<table id="" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead class="bg-primary">
		<tr>
			
			<th class="">#</th>
			<th class="">Emp Id</th>
			<th class="">Month</th>
			<th class="">Year</th>
			<th class="">Opening Balance</th>
			<!--<th class="">Emp DCPS Con</th>-->
			<!--<th class="">Emp Supplimentory DCPS Con</th>-->
			<!--<th class="">NMC DCPS Con</th>-->
			<!--<th class="">NMC Supplimentory DCPS Con</th>-->
			<th class="">Total Contribution</th>
			<th class="">Calculate</th>
			
			
		</tr>
	</thead>
	<tbody>
		<?php //echo "<pre>";print_r($data); exit;
			$i=1;
			foreach ($data as $row) {?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['emp_td']; ?></td>
				<td><?php echo $row['for_month']; ?></td>
				<td><?php echo $row['for_year']; ?></td>
				<td><?php echo round($row['opening_balance'],2); ?></td>
				<!--<td><?php echo $row['emp_DCPS_contribution']; ?></td>-->
				<!--<td><?php echo $row['emp_DCPS_supplimentory_contribution']; ?></td>-->
				<!--<td><?php echo $row['NMC_DCPS_contribution']; ?></td>-->
				<!--<td><?php echo $row['NMC_supplimentory_DCPS_contribution']; ?></td>-->
				<td><?php $total = $row['emp_DCPS_contribution']+$row['emp_DCPS_supplimentory_contribution']+$row['NMC_DCPS_contribution']+$row['NMC_supplimentory_DCPS_contribution'];echo $total; ?></td>
				<td><a href="javascript:void(0)" class="btn btn-primary" type="button" name="submit" id="submit" value="Submit" onclick="select(<?php echo $row['id']; ?>)">Calculate</a></td>
				<?php $i++; ?>
				
				
			</tr>
		<?php } ?>

	</tbody>
	
	<!-- <tfoot class="bg-primary">
		<tr>
			<th class="th-sm">Employee Id
			</th>
			<th class="th-sm">Employee Name
			</th>
			<th class="th-sm">Month
			<th class="th-sm">Year
			</th>
			
		</tr>
	</tfoot> -->
</table>

</div>


<style type="text/css">
	.sorting{
		color: #fff;
	}
	.searchTable{
		text-align: center;
		margin-bottom: 10px;
	}
	.searchTable .table-bordered {
		margin-bottom: 15px;
	}
	.searchTable .table-bordered>tbody>tr>td{
		border:solid 1px #0000001a;
	}

	.searchTable .dataTable tfoot th, table.dataTable tfoot td{
		border-top: none !important;
		text-align: center;
	}
	.searchTable table.dataTable thead th, table.dataTable thead td{
		border-bottom: #347ab6;
	}
	.searchTable .dataTables_paginate{
		border-radius:10px;
		border: solid 2px #dee2e6;
		padding-top: 5px;
		padding-bottom:5px; 
	}
	.searchTable .dataTables_wrapper .dataTables_paginate .paginate_button.current{
		background: linear-gradient(to bottom, #007aff 0%, #007aff 100%) !important;
		color: #fff !important;
		border-color: #007bff;
		margin-left:0px;
	}
	/*.dataTables_wrapper .dataTables_paginate .paginate_button:hover{
		background:#007bff !important;
		border:solid 1px #e9ecef;
		color: #000;
	}*/
	/*.searchTable .dataTables_wrapper .dataTables_paginate .paginate_button
	:hover{
		color: #fff !important;
		background: linear-gradient(to bottom, #007aff 0%, #007aff 100%) !important;
		border:none;
	}*/

	/*.searchTable .dataTables_paginate span{
		    border-right: solid 2px #dee2e6;
		    padding: 12px;
	}*/
	/*.searchTable .paginate_button{
		border-right: solid 2px #dee2e6 !important;
	}*/

</style>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script type="text/javascript">
	
		
		
		function select(id){
			// alert(id);
			// var employee_id = $('#employee_id').val();
			//var month = $('#month').val();
			// var year = $('#year').val();
			// alert(year);
			$.ajax({
				type : 'POST',
				url    : '<?php echo base_url("ajax/usingTableCalculateOpenBal"); ?>',
				dataType:'JSON',
	            // contentType:false,
	            // processData:false,
	            // catche:false,
				data : { id: id},
				success: function(res){
					if(res.status == 1){
		            	//alert("Opening Balance Updated Successfully!!!");
		            	// window.location.reload();
		          	}else{
		            	alert("Already Updated!!! Please Check!!!");
		          	}
				}
				
			});
		}

</script>


