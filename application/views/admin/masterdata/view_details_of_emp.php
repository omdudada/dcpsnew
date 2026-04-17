<?php //echo "<pre>==>";print_r($data); exit; ?>
<div class="searchTable">
<table id="dataTables-example" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead class="bg-primary">
		<tr>
			<th class="">Sr.No.</th>
			<th class="">Employee Id</th>
			<th class="">Employee Name</th>
			<th class="">Month</th>
			<th class="">Year</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=1;
			foreach ($data as $row) {?>
			<tr>
				<td style="text-align: center;"><?=$i++?></td>
				<td>
					<a href="<?=base_url('admin/view-employee-data/'.$row->id);?>" target="_blank"><?php echo $row->emp_td; ?></a>
				</td> 
				<td><?php echo $row->emp_name; ?></td>
				<td><?php echo $row->for_month; ?></td>
				<td><?php echo $row->for_year; ?></td>
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
	.dataTables_wrapper .dataTables_paginate .paginate_button:hover{
		background:#007bff !important;
		border:solid 1px #e9ecef;
		color: #000;
	}
	/*.searchTable .dataTables_wrapper .dataTables_paginate .paginate_button
	:hover{
		color: #fff !important;
		background: linear-gradient(to bottom, #007aff 0%, #007aff 100%) !important;
		border:none;
	}*/

	.searchTable .dataTables_paginate span{
		    /*border-right: solid 2px #dee2e6;*/
		    /*padding: 12px;*/
	}
	.searchTable .paginate_button{
		border-right: solid 2px #dee2e6 !important;
	}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready( function () {
		$('#dataTables-example').DataTable();
	});
</script>