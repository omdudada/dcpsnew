<?php //echo 123;exit; //echo "<pre>";print_r($data);die; ?>
<div class="searchTable">
<table id="dataTables-example" class="table table-striped table-bordered table-hover dataTable no-footer" aria-describedby="dataTables-example_info">
							
							<thead class="bg-primary">
								<tr role="row">
									<th width="5%">Sr. No.</th>
									<th>Voucher No.</th>
									<th>Voucher Date</th>
									<th>Employee Id</th>
									<th>Employee Name</th>
									<th>Basic</th>
									<th>DA</th>
									<th>Grade Pay</th>
									<th>Emp DCPS Deduction</th>
									<th>Emp DCPS Supplimentory Deduction</th>
									<th>For Month</th>
									<th>For Year</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if(!empty($data))
									{
										// echo "<pre>";print_r($data);die();
										$i=1;
										foreach($data as $row) {  ?>
										<tr role="row">
											<td style="text-align: center;"><?=$i++?></td>
											<td style="text-align: center;"><?php echo ($row['recovered_DCPS_with_voucher_no'])?($row['recovered_DCPS_with_voucher_no']):0; ?></td>
											<td style="text-align: center;"><?php echo ($row['recovered_DCPS_with_voucher_date'])?($row['recovered_DCPS_with_voucher_date']):"N/A"; ?></td>
											<td style="text-align: center;"><?php echo $row['emp_td']; ?></td>
											<td style="text-align: center;"><?php echo $row['emp_name']; ?></td>
											<td style="text-align: center;"><?php echo ($row['basic'])?($row['basic']):0; ?></td>
											<td style="text-align: center;"><?php echo ($row['da'])?($row['da']):0; ?></td>
											<td style="text-align: center;"><?php echo ($row['grade_pay'])?($row['grade_pay']):0; ?></td>
											<td style="text-align: center;"><?php echo ($row['emp_DCPS_contribution'])?($row['emp_DCPS_contribution']):0; ?></td>
											<td style="text-align: center;"><?php echo ($row['emp_DCPS_supplimentory_contribution'])?($row['emp_DCPS_supplimentory_contribution']):0; ?></td>
											<td style="text-align: center;"><?php echo $row['for_month']; ?></td>
											<td style="text-align: center;"><?php echo $row['for_year']; ?></td>
											<td style="text-align: center;"><a  href="<?php echo base_url(); ?>admin/edit-dcps-deduction-record/<?php echo $row['id']; ?>" class="btn btn-primary" type="button" target="_blank">Edit</a></td>
										</tr>
										<?php }
									} ?>
							</tbody>
						</table>
						
						<!-- Modal -->
    					<div id="myModal" class="modal fade" role="dialog">
    						<div class="modal-dialog modal-lg">
    							<div class="modal-content" >
    							    <div class="modal-header">
                                    	<button type="button" class="close" data-dismiss="modal">&times;</button>
                                    	<h4>DCPS Deduction Record</h4>
                                    </div>
                                    <div class="modal-body">
                                    	<div id="modalContent"></div>
                                	</div>
                                    <div class="modal-footer">
    							    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    							    </div>    
    							</div>
    						</div>
    					</div>
						
		
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

	.searchTable .dataTables_paginate span{
		    border-right: solid 2px #dee2e6;
		    padding: 12px;
	}
	.searchTable .paginate_button{
		border-right: solid 2px #dee2e6 !important;
	}


</style>

<script type="text/javascript">
	$(document).ready(function() { 
		$(function() { 
			$('#dataTables-example').on('click',".clsViewRecord",function(){
				var emp_id = $(this).attr("data-emp-id");				
				var year = $(this).attr("data-year");
				$.ajax({
					type : 'POST',
					url    : '<?php echo base_url("ajax/getEmpMonthsDetails"); ?>',
					data : { id: emp_id,year:year},
					datatype : 'JSON',
					success: function(response){
						var obj = jQuery.parseJSON(response);
						$("#modalContent").html(obj.customer_detail);
						$('#myModal').modal('show'); 
					}, 
				})
			})
		}); 
	}) 
</script>
<script type="text/javascript">
	$(document).ready( function () {
		$('#dataTables-example').DataTable();
	});
</script>
 