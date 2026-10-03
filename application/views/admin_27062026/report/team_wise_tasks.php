<?php // view to show missing employees for selected team and month ?>
<div class="container" style="padding-top:200px;">
  <h3>Team <?=$team;?> — <?=htmlspecialchars($month_name);?> (Missing Records)</h3>
  <p>Showing financial years from 2006-2007 to 2014-2015 for month <strong><?=htmlspecialchars($month_name);?></strong>.</p>

  <?php if(empty($missing)){ ?>
    <div class="alert alert-success">No missing entries found for this month in the range.</div>
  <?php } else { ?>
    <?php foreach($missing as $idx => $row){ ?>
      <h4><?=htmlspecialchars($row['financial_year']);?> — <small>for year <?=htmlspecialchars($row['for_year']);?></small></h4>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Emp ID</th>
            <th>Employee Name</th>
            <th>Joining Date</th>
            <th>Month Name</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($row['employees'] as $k => $emp){ ?>
            <tr>
              <td><?=($k+1);?></td>
              <td><?=htmlspecialchars($emp['emp_id']);?></td>
              <td><?=htmlspecialchars($emp['emp_name']);?></td>
              <td><?=htmlspecialchars($emp['joining_date']);?></td>
              <td><?=htmlspecialchars($row['month_name']);?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } ?>
  <?php } ?>

  <div style="margin-top:10px;"><a class="btn btn-default" href="<?=base_url('admin')?>">Back</a></div>
</div>