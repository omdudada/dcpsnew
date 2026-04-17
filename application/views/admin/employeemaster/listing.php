<div class="page-header">
    <h1>Employee Master</h1>
    <ul class="breadcrumb">
        <li><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
        <li>Employee Master</li>
    </ul>
</div>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
    <strong>Success:</strong> <?php echo $this->session->flashdata('success'); ?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger">
    <strong>Error:</strong> <?php echo $this->session->flashdata('error'); ?>
</div>
<?php endif; ?>

<div class="box">
    <div class="box-header">
        <h3>Employee List</h3>
        <a href="<?php echo base_url('admin/add-emp'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add New Employee</a>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="empTable" class="table">
                <thead>
                    <tr>
                        <th width="5%">Sr. No.</th>
                        <th>Employee Name</th>
                        <th>Employee ID</th>
                        <th>Joining Date</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($results)): ?>
                        <?php $i=1; foreach($results as $row): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['emp_name']; ?></td>
                            <td><?php echo $row['emp_id']; ?></td>
                            <td><?php echo $row['joining_date']; ?></td>
                            <td>
                                <a href="<?php echo base_url('admin/edit-emp/'.$row['id']); ?>" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                <button onclick="confirmDelete(<?php echo $row['id']; ?>)" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">No employees found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // If DataTables is available
    if ($.fn.DataTable) {
        $('#empTable').DataTable({
            "order": [[ 0, "asc" ]]
        });
    }
});

function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this employee?')) {
        window.location.href = "<?php echo base_url('admin/masterdata/deleteEmp/'); ?>" + id;
    }
}
</script>