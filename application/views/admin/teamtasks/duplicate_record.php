<?php
// Team Tasks - Duplicate Record
$monthNames = [1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];
$teamMonthName = ($teamMonth && isset($monthNames[$teamMonth])) ? $monthNames[$teamMonth] : 'All Months';

$buildUrl = function($params = []) {
    $base = base_url('admin/team-tasks/duplicate-record');
    $qs = http_build_query(array_filter($params, function($v){ return $v !== null; }));
    return $base . ($qs ? ('?' . $qs) : '');
};
?>

<div class="page-header">
    <div class="heading-icon-badge"><img src="<?php echo base_url('assets/images/error.png'); ?>" alt="Team Tasks — Duplicate Record"></div>
    <h1>Team Tasks — Duplicate Record</h1>
    <ul class="breadcrumb">
        <li><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
        <li>Team Tasks</li>
        <li>Duplicate Record</li>
    </ul>
</div>

<div class="box">
    <div class="box-header">
        <h3>Filters</h3>
        <div>
            <a class="btn btn-success btn-sm" href="<?php echo $buildUrl(['team'=>$team,'q'=>$search,'per_page'=>$perPage,'export'=>1]); ?>">Export CSV</a>
        </div>
    </div>
    <div class="box-body">
        <form method="get" action="<?php echo base_url('admin/team-tasks/duplicate-record'); ?>">
            <div class="form-row">
                <div class="form-group">
                    <label>Team</label>
                    <select class="form-control" name="team">
                        <option value="0" <?php echo ($team==0?'selected':''); ?>>All Teams</option>
                        <?php for($i=1;$i<=12;$i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo ($team==$i?'selected':''); ?>>Team <?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Search (Emp ID / Name / Voucher No)</label>
                    <input class="form-control" type="text" name="q" value="<?php echo htmlspecialchars($search); ?>" placeholder="Type to search..." />
                </div>
                <div class="form-group">
                    <label>Per Page</label>
                    <select class="form-control" name="per_page">
                        <?php foreach([25,50,100,200] as $pp): ?>
                            <option value="<?php echo $pp; ?>" <?php echo ($perPage==$pp?'selected':''); ?>><?php echo $pp; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Apply</button>
            <a class="btn btn-warning" href="<?php echo base_url('admin/team-tasks/duplicate-record'); ?>">Reset</a>
        </form>

        <div style="margin-top:12px;">
            <div class="alert alert-info">
                Showing: <strong><?php echo htmlspecialchars($teamMonthName); ?></strong> |
                Total duplicate records: <strong><?php echo (int)$total; ?></strong>
            </div>
        </div>

        <?php
            $teamToMonth = [1=>4,2=>5,3=>6,4=>7,5=>8,6=>9,7=>10,8=>11,9=>12,10=>1,11=>2,12=>3];
        ?>
        <div class="stats-row" style="margin-top:12px;">
            <?php for($t=1;$t<=12;$t++):
                $m = $teamToMonth[$t];
                $cnt = isset($duplicateCountsByTeam[$m]) ? (int)$duplicateCountsByTeam[$m] : 0;
            ?>
                <div class="stat-card red" style="max-width:220px;">
                    <div class="stat-info">
                        <h3><?php echo $cnt; ?></h3>
                        <p>Team <?php echo $t; ?> (<?php echo htmlspecialchars($monthNames[$m]); ?>)</p>
                    </div>
                    <div class="stat-icon">×</div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>

<div class="box">
    <div class="box-header">
        <h3>Records</h3>
        <div style="font-size:12px;color:#666;">
            Duplicate detected using: emp_td + voucher no/date + salary fields
        </div>
    </div>
    <div class="box-body">
        <?php if(empty($records)): ?>
            <div class="alert alert-success">No duplicate records found for the selected filters.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Emp TD</th>
                            <th>Employee Name</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Voucher No</th>
                            <th>Voucher Date</th>
                            <th>Basic</th>
                            <th>DA</th>
                            <th>Grade Pay</th>
                            <th>Total Salary</th>
                            <th>Ideal Contribution</th>
                            <th>Pay Center</th>
                            <th>Dup Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($records as $idx => $r):
                            $monthLabel = (isset($monthNames[(int)$r['for_month']])) ? $monthNames[(int)$r['for_month']] : '';
                            $rowStyle = ((int)$r['duplicate_count'] > 1) ? ' style="background:#f8d7da;"' : '';
                        ?>
                            <tr<?php echo $rowStyle; ?>>
                                <td><?php echo (int)(($page-1)*$perPage + $idx + 1); ?></td>
                                <td><?php echo htmlspecialchars($r['emp_td']); ?></td>
                                <td><?php echo htmlspecialchars($r['emp_name']); ?></td>
                                <td><?php echo htmlspecialchars($monthLabel ?: $r['for_month']); ?></td>
                                <td><?php echo htmlspecialchars($r['for_year']); ?></td>
                                <td><?php echo htmlspecialchars($r['recovered_DCPS_with_voucher_no']); ?></td>
                                <td><?php echo htmlspecialchars($r['recovered_DCPS_with_voucher_date']); ?></td>
                                <td><?php echo htmlspecialchars($r['basic']); ?></td>
                                <td><?php echo htmlspecialchars($r['da']); ?></td>
                                <td><?php echo htmlspecialchars($r['grade_pay']); ?></td>
                                <td><?php echo htmlspecialchars($r['total_salary']); ?></td>
                                <td><?php echo htmlspecialchars($r['Ideal_contribution_of_employee_for_DCPS']); ?></td>
                                <td><?php echo htmlspecialchars($r['pay_center']); ?></td>
                                <td><strong><?php echo (int)$r['duplicate_count']; ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php echo $pagination; ?>
        <?php endif; ?>
    </div>
</div>

