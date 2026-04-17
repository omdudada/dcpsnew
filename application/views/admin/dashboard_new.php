<?php
// Month names
$monthNames = [
    1=>'January',2=>'February',3=>'March',4=>'April',
    5=>'May',6=>'June',7=>'July',8=>'August',
    9=>'September',10=>'October',11=>'November',12=>'December'
];
?>

<!-- =========================================================
     DASHBOARD ADDITIONAL STYLES
========================================================== -->
<style>
/* ---- Color Palette ---- */
:root {
    --dash-blue:    #003366;
    --dash-indigo:  #3949ab;
    --dash-teal:    #00796b;
    --dash-orange:  #e65100;
    --dash-red:     #c62828;
    --dash-green:   #2e7d32;
    --dash-purple:  #6a1b9a;
    --dash-bg:      #f0f2f5;
    --card-shadow:  0 4px 18px rgba(0,0,0,.10);
}

/* ---- Layout ---- */
.dash-page {
    background: var(--dash-bg);
    min-height: 100vh;
    padding: 24px;
}

/* ---- Page Header ---- */
.dash-heading {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 28px;
}
.dash-heading .icon-badge {
    width: 52px; height: 52px;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--dash-blue), var(--dash-indigo));
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 24px; flex-shrink: 0;
}
.dash-heading h1 { font-size: 24px; color: var(--dash-blue); margin: 0; font-weight: 700; }
.dash-heading p  { margin: 0; color: #666; font-size: 13px; }

/* ---- KPI Cards ---- */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 18px;
    margin-bottom: 28px;
}
.kpi-card {
    background: #fff;
    border-radius: 14px;
    padding: 22px 24px;
    box-shadow: var(--card-shadow);
    display: flex;
    align-items: center;
    gap: 18px;
    border-left: 5px solid var(--dash-blue);
    transition: transform .15s;
}
.kpi-card:hover { transform: translateY(-3px); }
.kpi-card.orange { border-left-color: var(--dash-orange); }
.kpi-card.red    { border-left-color: var(--dash-red);    }
.kpi-card.teal   { border-left-color: var(--dash-teal);   }
.kpi-card.purple { border-left-color: var(--dash-purple); }
.kpi-card.green  { border-left-color: var(--dash-green);  }

.kpi-icon {
    width: 56px; height: 56px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; flex-shrink: 0;
}
.kpi-icon.blue   { background: #e3eaf5; color: var(--dash-blue);   }
.kpi-icon.orange { background: #fce8d5; color: var(--dash-orange); }
.kpi-icon.red    { background: #fde0e0; color: var(--dash-red);    }
.kpi-icon.teal   { background: #d0f0ec; color: var(--dash-teal);   }
.kpi-icon.purple { background: #edd9f7; color: var(--dash-purple); }
.kpi-icon.green  { background: #d5eed6; color: var(--dash-green);  }

.kpi-info .num  { font-size: 32px; font-weight: 800; color: #1a1a2e; line-height: 1; }
.kpi-info .lbl  { font-size: 12px; color: #888; margin-top: 4px; text-transform: uppercase; letter-spacing: .5px; }

/* ---- Section Panels ---- */
.dash-panel {
    background: #fff;
    border-radius: 14px;
    box-shadow: var(--card-shadow);
    margin-bottom: 28px;
    overflow: hidden;
}
.dash-panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 22px;
    border-bottom: 2px solid #f0f2f5;
    background: linear-gradient(to right, #f8f9ff, #fff);
}
.dash-panel-header h2 {
    font-size: 16px; font-weight: 700;
    color: var(--dash-blue); margin: 0;
    display: flex; align-items: center; gap: 8px;
}
.dash-panel-body { padding: 20px 22px; }

/* ---- Month-wise Table ---- */
.monthwise-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.monthwise-table th {
    background: var(--dash-blue); color: #fff;
    padding: 10px 14px; text-align: left; white-space: nowrap;
}
.monthwise-table td {
    padding: 9px 14px; border-bottom: 1px solid #eef0f5;
    vertical-align: middle;
}
.monthwise-table tr:hover td { background: #f0f4ff; }
.monthwise-table tr:nth-child(even) td { background: #f8f9fc; }
.monthwise-table tr:nth-child(even):hover td { background: #f0f4ff; }

/* clickable count badge */
.count-link {
    display: inline-block;
    background: #e3eaf5;
    color: var(--dash-blue);
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 13px;
    text-decoration: none;
    transition: background .15s, color .15s;
}
.count-link:hover {
    background: var(--dash-blue);
    color: #fff;
    text-decoration: none;
}

/* ---- Filters Bar ---- */
.filter-bar {
    display: flex; flex-wrap: wrap; gap: 12px;
    align-items: flex-end; margin-bottom: 18px;
}
.filter-bar .fg { display: flex; flex-direction: column; gap: 4px; min-width: 170px; }
.filter-bar label { font-size: 12px; font-weight: 600; color: #555; text-transform: uppercase; }
.filter-bar select, .filter-bar input {
    padding: 7px 10px; border: 1px solid #ccc; border-radius: 6px;
    font-size: 13px; background: #fff;
}
.filter-bar .btn-filter {
    padding: 8px 22px; border-radius: 6px; border: none;
    background: var(--dash-blue); color: #fff;
    font-size: 13px; cursor: pointer; align-self: flex-end;
}
.filter-bar .btn-filter:hover { background: var(--dash-indigo); }
.filter-bar .btn-reset {
    padding: 8px 16px; border-radius: 6px; border: 1px solid #ccc;
    background: #fff; color: #555; font-size: 13px; cursor: pointer; align-self: flex-end;
}

/* ---- Tables ---- */
.dash-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.dash-table th {
    background: var(--dash-blue); color: #fff;
    padding: 10px 12px; text-align: left; white-space: nowrap;
}
.dash-table td {
    padding: 9px 12px; border-bottom: 1px solid #eef0f5;
    vertical-align: middle;
}
.dash-table tr:hover td { background: #f0f4ff; }
.dash-table tr:nth-child(even) td { background: #f8f9fc; }
.dash-table tr:nth-child(even):hover td { background: #f0f4ff; }

/* ---- Badges ---- */
.badge {
    display: inline-block; padding: 3px 9px; border-radius: 20px;
    font-size: 11px; font-weight: 700;
}
.badge-red    { background: #fde0e0; color: #c62828; }
.badge-orange { background: #fce8d5; color: #e65100; }
.badge-green  { background: #d5eed6; color: #2e7d32; }
.badge-blue   { background: #e3eaf5; color: #003366; }

/* ---- Tab Nav ---- */
.tab-nav { display: flex; gap: 0; border-bottom: 2px solid #e0e4f0; margin-bottom: 18px; }
.tab-btn {
    padding: 10px 22px; background: none; border: none;
    font-size: 13px; font-weight: 600; color: #888; cursor: pointer;
    border-bottom: 3px solid transparent; margin-bottom: -2px;
    transition: all .15s;
}
.tab-btn.active { color: var(--dash-blue); border-bottom-color: var(--dash-blue); }
.tab-btn:hover  { color: var(--dash-indigo); }
.tab-pane { display: none; }
.tab-pane.active { display: block; }

/* ---- Pulse Animation for counts ---- */
@keyframes countUp { from { opacity:0; transform: scale(.8); } to { opacity:1; transform: scale(1); } }
.kpi-info .num { animation: countUp .5s ease forwards; }

/* ---- Scrollable table container ---- */
.table-scroll { overflow-x: auto; }

/* ---- Loading spinner ---- */
.spinner-wrap { display: flex; justify-content: center; padding: 40px; }
.spinner {
    width: 40px; height: 40px; border: 4px solid #eee;
    border-top-color: var(--dash-blue); border-radius: 50%;
    animation: spin .8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* month search filter */
.monthwise-search {
    padding: 7px 12px; border: 1px solid #ccc; border-radius: 6px;
    font-size: 13px; min-width: 220px; margin-bottom: 14px;
}
</style>

<!-- =========================================================
     DASHBOARD CONTENT
========================================================== -->
<div class="dash-page">

    <!-- Page Heading -->
    <div class="dash-heading">
        <div class="icon-badge">📊</div>
        <div>
            <h1>DCPS Dashboard</h1>
            <p>Defined Contribution Pension Scheme — Nashik Municipal Corporation &nbsp;|&nbsp; <?php echo date('d M Y'); ?></p>
        </div>
    </div>

    <!-- ===================== KPI CARDS ===================== -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon blue">📋</div>
            <div class="kpi-info">
                <div class="num"><?php echo number_format($total_records); ?></div>
                <div class="lbl">Total Records</div>
            </div>
        </div>
        <div class="kpi-card teal">
            <div class="kpi-icon teal">👥</div>
            <div class="kpi-info">
                <div class="num"><?php echo number_format($total_employees); ?></div>
                <div class="lbl">Active Employees (with data)</div>
            </div>
        </div>
        <div class="kpi-card green">
            <div class="kpi-icon green">🏢</div>
            <div class="kpi-info">
                <div class="num"><?php echo number_format($total_emp_master); ?></div>
                <div class="lbl">Employees in Master</div>
            </div>
        </div>
        <div class="kpi-card red">
            <div class="kpi-icon red">⚠️</div>
            <div class="kpi-info">
                <div class="num"><?php echo number_format($duplicate_count); ?></div>
                <div class="lbl">Duplicate Records</div>
            </div>
        </div>
        <div class="kpi-card orange">
            <div class="kpi-icon orange">📅</div>
            <div class="kpi-info">
                <div class="num" id="kpiMissingCount">—</div>
                <div class="lbl">Missing Month-Entries</div>
                <button onclick="loadMissingMonths()" style="margin-top:6px;font-size:11px;padding:4px 10px;border:1px solid #e65100;border-radius:4px;background:#fff;color:#e65100;cursor:pointer;">Calculate</button>
            </div>
        </div>
    </div>

    <!-- ===================== MONTH-WISE RECORD COUNT TABLE ===================== -->
    <div class="dash-panel">
        <div class="dash-panel-header">
            <h2>📈 Month-wise Record Count</h2>
            <span style="font-size:12px;color:#888;">Click a count to view &amp; edit records for that month</span>
        </div>
        <div class="dash-panel-body">
            <?php if (!empty($month_wise_counts)): ?>
            <input type="text" class="monthwise-search" id="monthWiseSearch"
                   placeholder="🔍  Search month or year..." oninput="filterMonthTable()">
            <div class="table-scroll">
                <table class="monthwise-table" id="tblMonthWise">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Financial Year</th>
                            <th style="text-align:center;">Record Count</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $serial = 1;
                        foreach ($month_wise_counts as $r):
                            $mNum  = (int)$r['for_month'];
                            $yr    = (int)$r['for_year'];
                            $mName = isset($monthNames[$mNum]) ? $monthNames[$mNum] : $mNum;
                            // Financial year: Apr-Dec → FY = yr-(yr+1), Jan-Mar → FY = (yr-1)-yr
                            $fyStart = ($mNum >= 4) ? $yr : ($yr - 1);
                            $fyLabel = $fyStart . '-' . ($fyStart + 1);
                            // Link to monthly record listing filtered by month+year
                            $viewUrl = base_url('admin/monthly-record') . '?for_month=' . $mNum . '&for_year=' . $yr;
                        ?>
                        <tr>
                            <td><?php echo $serial++; ?></td>
                            <td><strong><?php echo $mName; ?></strong></td>
                            <td><?php echo $yr; ?></td>
                            <td><span class="badge badge-blue"><?php echo $fyLabel; ?></span></td>
                            <td style="text-align:center;">
                                <a href="<?php echo base_url('admin/dashboard/recordsByMonthYear/' . $mNum . '/' . $yr); ?>"
                                   class="count-link" target="_blank">
                                    <?php echo number_format((int)$r['record_count']); ?>
                                </a>
                            </td>
                            <td style="text-align:center;">
                                <a href="<?php echo base_url('admin/dashboard/recordsByMonthYear/' . $mNum . '/' . $yr); ?>"
                                   target="_blank"
                                   style="font-size:12px;color:var(--dash-blue);text-decoration:none;">
                                    View / Edit →
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div style="text-align:center;color:#888;padding:30px;">No month-wise data available.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ===================== TABBED TABLES ===================== -->
    <div class="dash-panel">
        <div class="dash-panel-header">
            <h2>📂 Detailed Analysis</h2>
        </div>
        <div class="dash-panel-body">

            <!-- Tab Nav -->
            <div class="tab-nav">
                <button class="tab-btn active" onclick="switchTab('tabDup',this)">⚠️ Duplicates</button>
                <button class="tab-btn" onclick="switchTab('tabMissing',this)">📅 Missing Months</button>
                <button class="tab-btn" onclick="switchTab('tabLedger',this)">📒 Ledger Summary</button>
                <button class="tab-btn" onclick="switchTab('tabDeduction',this)">📝 Deduction Summary</button>
            </div>

            <!-- ===== TAB: DUPLICATES ===== -->
            <div id="tabDup" class="tab-pane active">
                <div class="filter-bar" style="margin-bottom: 12px;">
                    <span style="font-size:13px;color:#888;">
                        Found <strong style="color:#c62828"><?php echo number_format($duplicate_count); ?></strong> duplicate records
                        across <strong style="color:#c62828"><?php echo number_format($duplicate_groups); ?></strong> duplicate groups.
                        Records sharing the same Voucher No, Date, Basic, Grade Pay, DA, Total Salary and Ideal Contribution are flagged.
                    </span>
                    <button class="btn-filter" style="margin-left:auto" onclick="loadDuplicates()">Load Records</button>
                </div>
                <div class="table-scroll">
                    <table class="dash-table" id="tblDuplicates">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Emp ID</th>
                                <th>Emp Name</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Voucher No</th>
                                <th>Voucher Date</th>
                                <th>Basic</th>
                                <th>Grade Pay</th>
                                <th>DA</th>
                                <th>Total Salary</th>
                                <th>Ideal Contribution</th>
                                <th>Emp Contribution</th>
                                <th>Salary Type</th>
                                <th>Dup Count</th>
                            </tr>
                        </thead>
                        <tbody id="bodyDuplicates">
                            <tr><td colspan="15" style="text-align:center;color:#888;padding:30px;">Click "Load Records" to fetch duplicate data.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ===== TAB: MISSING MONTHS ===== -->
            <div id="tabMissing" class="tab-pane">
                <div class="filter-bar" style="margin-bottom:14px;align-items:center;">
                    <span style="font-size:13px;color:#888;flex:1;">
                        Total <strong style="color:#e65100" id="missingTotalCount">—</strong> missing month-year entries.
                        Logic: For each employee, all months between their earliest and latest recorded year are checked; gaps are flagged.
                    </span>
                    <button class="btn-filter" onclick="loadMissingMonths()">📅 Load Missing Months</button>
                </div>
                <div class="filter-bar">
                    <div class="fg">
                        <label>Search Employee</label>
                        <input type="text" id="missingSearch" placeholder="Emp ID or Name..." oninput="filterMissingTable()">
                    </div>
                </div>
                <div id="missingSpinner" style="display:none;" class="spinner-wrap"><div class="spinner"></div></div>
                <div class="table-scroll">
                    <table class="dash-table" id="tblMissing">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Emp ID</th>
                                <th>Emp Name</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Financial Year</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="bodyMissing">
                            <tr><td colspan="7" style="text-align:center;color:#888;padding:30px;">Click "Load Missing Months" to calculate gaps.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ===== TAB: LEDGER SUMMARY ===== -->
            <div id="tabLedger" class="tab-pane">
                <div class="filter-bar">
                    <div class="fg">
                        <label>Employee</label>
                        <select id="ledgerEmp">
                            <option value="">All Employees</option>
                            <?php foreach ($employee_list as $emp): ?>
                            <option value="<?php echo $emp['emp_id']; ?>">
                                <?php echo htmlspecialchars($emp['emp_name']) . ' (' . $emp['emp_id'] . ')'; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="fg">
                        <label>Year</label>
                        <select id="ledgerYear">
                            <option value="">All Years</option>
                            <?php foreach ($year_list as $yr): ?>
                            <option value="<?php echo $yr['for_year']; ?>"><?php echo $yr['for_year']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn-filter" onclick="loadLedgerSummary()">Apply Filter</button>
                    <button class="btn-reset" onclick="resetLedger()">Reset</button>
                </div>
                <div id="ledgerSpinner" style="display:none;" class="spinner-wrap"><div class="spinner"></div></div>
                <div class="table-scroll">
                    <table class="dash-table" id="tblLedger">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Emp ID</th>
                                <th>Emp Name</th>
                                <th>Year</th>
                                <th>Months Covered</th>
                                <th>Emp Contribution</th>
                                <th>NMC Contribution</th>
                                <th>Loan Installment</th>
                                <th>Loan Taken</th>
                            </tr>
                        </thead>
                        <tbody id="bodyLedger">
                            <tr><td colspan="9" style="text-align:center;color:#888;padding:30px;">Apply a filter and click "Apply Filter" to load data.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ===== TAB: DEDUCTION SUMMARY ===== -->
            <div id="tabDeduction" class="tab-pane">
                <div class="filter-bar">
                    <div class="fg">
                        <label>Employee</label>
                        <select id="deductionEmp">
                            <option value="">All Employees</option>
                            <?php foreach ($employee_list as $emp): ?>
                            <option value="<?php echo $emp['emp_id']; ?>">
                                <?php echo htmlspecialchars($emp['emp_name']) . ' (' . $emp['emp_id'] . ')'; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="fg">
                        <label>Year</label>
                        <select id="deductionYear">
                            <option value="">All Years</option>
                            <?php foreach ($year_list as $yr): ?>
                            <option value="<?php echo $yr['for_year']; ?>"><?php echo $yr['for_year']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn-filter" onclick="loadDeductionSummary()">Apply Filter</button>
                    <button class="btn-reset" onclick="resetDeduction()">Reset</button>
                </div>
                <div id="deductionSpinner" style="display:none;" class="spinner-wrap"><div class="spinner"></div></div>
                <div class="table-scroll">
                    <table class="dash-table" id="tblDeduction">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Emp ID</th>
                                <th>Emp Name</th>
                                <th>Year</th>
                                <th>Months</th>
                                <th>Ideal Contribution</th>
                                <th>Actual (Emp)</th>
                                <th>Difference</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="bodyDeduction">
                            <tr><td colspan="9" style="text-align:center;color:#888;padding:30px;">Apply a filter and click "Apply Filter" to load data.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- /.dash-panel-body -->
    </div><!-- /.dash-panel -->

</div><!-- /.dash-page -->

<script>
// ================================================================
// MONTH TABLE SEARCH FILTER
// ================================================================
function filterMonthTable() {
    const val = document.getElementById('monthWiseSearch').value.toLowerCase();
    document.querySelectorAll('#tblMonthWise tbody tr').forEach(tr => {
        tr.style.display = tr.innerText.toLowerCase().includes(val) ? '' : 'none';
    });
}

// ================================================================
// TAB SWITCHING
// ================================================================
function switchTab(id, btn) {
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById(id).classList.add('active');
    btn.classList.add('active');
}

// ================================================================
// LOAD DUPLICATES (AJAX)
// ================================================================
function loadDuplicates() {
    const tbody = document.getElementById('bodyDuplicates');
    tbody.innerHTML = '<tr><td colspan="15" style="text-align:center;padding:30px;"><div class="spinner" style="margin:auto;"></div></td></tr>';

    const monthMap = {1:'Jan',2:'Feb',3:'Mar',4:'Apr',5:'May',6:'Jun',
                      7:'Jul',8:'Aug',9:'Sep',10:'Oct',11:'Nov',12:'Dec'};

    fetch('<?php echo base_url("admin/dashboard/getDuplicates?length=500&start=0&draw=1"); ?>')
        .then(r => r.json())
        .then(resp => {
            const rows = resp.data;
            if (!rows || rows.length === 0) {
                tbody.innerHTML = '<tr><td colspan="15" style="text-align:center;color:green;padding:30px;">✅ No duplicate records found!</td></tr>';
                return;
            }
            let html = '';
            rows.forEach((r, i) => {
                html += `<tr>
                    <td>${i+1}</td>
                    <td><b>${r.emp_td}</b></td>
                    <td>${r.emp_name}</td>
                    <td>${monthMap[r.for_month] || r.for_month}</td>
                    <td>${r.for_year}</td>
                    <td>${r.recovered_DCPS_with_voucher_no || '-'}</td>
                    <td>${r.recovered_DCPS_with_voucher_date || '-'}</td>
                    <td>${r.basic || 0}</td>
                    <td>${r.grade_pay || 0}</td>
                    <td>${r.da || 0}</td>
                    <td>${r.total_salary || 0}</td>
                    <td>${r.Ideal_contribution_of_employee_for_DCPS || 0}</td>
                    <td>${r.emp_DCPS_contribution || 0}</td>
                    <td>${r.salary_type || '-'}</td>
                    <td><span class="badge badge-red">${r.duplicate_count}x</span></td>
                </tr>`;
            });
            tbody.innerHTML = html;
        })
        .catch(() => {
            tbody.innerHTML = '<tr><td colspan="15" style="text-align:center;color:red;padding:20px;">Error loading data.</td></tr>';
        });
}

// ================================================================
// LOAD MISSING MONTHS (AJAX — triggered on demand)
// ================================================================
function loadMissingMonths() {
    const spinner = document.getElementById('missingSpinner');
    const tbody   = document.getElementById('bodyMissing');
    const kpi     = document.getElementById('kpiMissingCount');
    const counter = document.getElementById('missingTotalCount');
    const addUrl  = '<?php echo base_url("admin/add-edit-master-record"); ?>';

    spinner.style.display = 'flex';
    tbody.innerHTML = '';

    const monthMap = {1:'January',2:'February',3:'March',4:'April',5:'May',6:'June',
                      7:'July',8:'August',9:'September',10:'October',11:'November',12:'December'};

    fetch('<?php echo base_url("admin/dashboard/getMissingMonths"); ?>')
        .then(r => r.json())
        .then(resp => {
            spinner.style.display = 'none';
            const total = resp.count;
            kpi.textContent     = total.toLocaleString();
            counter.textContent = total.toLocaleString();

            const rows = resp.records || [];
            if (rows.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;color:green;padding:30px;">✅ No missing months detected!</td></tr>';
                return;
            }
            let html = '';
            rows.forEach((r, i) => {
                const fy = r.f_year;
                const mn = monthMap[r.for_month] || r.for_month;
                html += `<tr>
                    <td>${i+1}</td>
                    <td><b>${r.emp_td}</b></td>
                    <td>${r.emp_name}</td>
                    <td>${mn}</td>
                    <td>${r.for_year}</td>
                    <td><span class="badge badge-orange">${fy}</span></td>
                    <td><a href="${addUrl}?emp_id=${r.emp_td}&month=${r.for_month}&year=${r.for_year}"
                           style="color:var(--dash-blue);font-size:12px;text-decoration:none;" target="_blank">+ Add Record</a></td>
                </tr>`;
            });
            tbody.innerHTML = html;
            if (total > 500) {
                tbody.innerHTML += `<tr><td colspan="7" style="text-align:center;color:#888;font-size:12px;padding:8px;">
                    Showing first 500. Total missing: ${total.toLocaleString()}</td></tr>`;
            }
        })
        .catch(() => {
            spinner.style.display = 'none';
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;color:red;padding:20px;">Error loading missing months data.</td></tr>';
        });
}

// ================================================================
// FILTER MISSING TABLE
// ================================================================
function filterMissingTable() {
    const val = document.getElementById('missingSearch').value.toLowerCase();
    document.querySelectorAll('#bodyMissing tr').forEach(tr => {
        tr.style.display = tr.innerText.toLowerCase().includes(val) ? '' : 'none';
    });
}

// ================================================================
// LEDGER SUMMARY
// ================================================================
function loadLedgerSummary() {
    const emp  = document.getElementById('ledgerEmp').value;
    const year = document.getElementById('ledgerYear').value;
    const spinner = document.getElementById('ledgerSpinner');
    const tbody = document.getElementById('bodyLedger');

    spinner.style.display = 'flex';
    tbody.innerHTML = '';

    fetch(`<?php echo base_url('admin/dashboard/ledgerSummary'); ?>?emp_id=${emp}&for_year=${year}`)
        .then(r => r.json())
        .then(rows => {
            spinner.style.display = 'none';
            if (!rows || rows.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;color:#888;padding:20px;">No records found for the selected filter.</td></tr>';
                return;
            }
            let html = '';
            rows.forEach((r, i) => {
                html += `<tr>
                    <td>${i+1}</td>
                    <td><b>${r.emp_td}</b></td>
                    <td>${r.emp_name}</td>
                    <td>${r.for_year}</td>
                    <td><span class="badge badge-blue">${r.months_covered}</span></td>
                    <td>₹ ${parseFloat(r.total_emp_contribution||0).toFixed(2)}</td>
                    <td>₹ ${parseFloat(r.total_nmc_contribution||0).toFixed(2)}</td>
                    <td>₹ ${parseFloat(r.total_loan_installment||0).toFixed(2)}</td>
                    <td>₹ ${parseFloat(r.total_loan_taken||0).toFixed(2)}</td>
                </tr>`;
            });
            tbody.innerHTML = html;
        })
        .catch(() => {
            spinner.style.display = 'none';
            tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;color:red;">Error loading data.</td></tr>';
        });
}

function resetLedger() {
    document.getElementById('ledgerEmp').value  = '';
    document.getElementById('ledgerYear').value = '';
    document.getElementById('bodyLedger').innerHTML =
        '<tr><td colspan="9" style="text-align:center;color:#888;padding:30px;">Apply a filter and click "Apply Filter" to load data.</td></tr>';
}

// ================================================================
// DEDUCTION SUMMARY
// ================================================================
function loadDeductionSummary() {
    const emp  = document.getElementById('deductionEmp').value;
    const year = document.getElementById('deductionYear').value;
    const spinner = document.getElementById('deductionSpinner');
    const tbody = document.getElementById('bodyDeduction');

    spinner.style.display = 'flex';
    tbody.innerHTML = '';

    fetch(`<?php echo base_url('admin/dashboard/deductionSummary'); ?>?emp_id=${emp}&for_year=${year}`)
        .then(r => r.json())
        .then(rows => {
            spinner.style.display = 'none';
            if (!rows || rows.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;color:#888;padding:20px;">No records found for the selected filter.</td></tr>';
                return;
            }
            let html = '';
            rows.forEach((r, i) => {
                const diff = parseFloat(r.total_difference || 0);
                const badge = diff < 0
                    ? '<span class="badge badge-red">Short</span>'
                    : diff > 0
                        ? '<span class="badge badge-orange">Excess</span>'
                        : '<span class="badge badge-green">Match</span>';

                html += `<tr>
                    <td>${i+1}</td>
                    <td><b>${r.emp_td}</b></td>
                    <td>${r.emp_name}</td>
                    <td>${r.for_year}</td>
                    <td><span class="badge badge-blue">${r.months_covered}</span></td>
                    <td>₹ ${parseFloat(r.total_ideal_contribution||0).toFixed(2)}</td>
                    <td>₹ ${parseFloat(r.total_emp_actual||0).toFixed(2)}</td>
                    <td>₹ ${diff.toFixed(2)}</td>
                    <td>${badge}</td>
                </tr>`;
            });
            tbody.innerHTML = html;
        })
        .catch(() => {
            spinner.style.display = 'none';
            tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;color:red;">Error loading data.</td></tr>';
        });
}

function resetDeduction() {
    document.getElementById('deductionEmp').value  = '';
    document.getElementById('deductionYear').value = '';
    document.getElementById('bodyDeduction').innerHTML =
        '<tr><td colspan="9" style="text-align:center;color:#888;padding:30px;">Apply a filter and click "Apply Filter" to load data.</td></tr>';
}
</script>
