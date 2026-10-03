<?php
// Month names (Marathi/English bilingual)
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

/* ---- Charts Grid ---- */
.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(420px, 1fr));
    gap: 22px;
    margin-bottom: 28px;
}
.chart-box {
    background: #fff;
    border-radius: 14px;
    box-shadow: var(--card-shadow);
    padding: 20px 22px;
}
.chart-box h3 { font-size: 14px; color: #555; margin-bottom: 14px; font-weight: 600; }
.chart-canvas { width: 100% !important; }

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
                <div class="num" id="kpiTotalRecords"><?php echo number_format($total_records); ?></div>
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

    <!-- ===================== CHARTS ===================== -->
    <div class="charts-grid">
        <!-- Month-wise record count -->
        <div class="chart-box">
            <h3>📈 Month-wise Record Count</h3>
            <canvas id="chartMonthWise" class="chart-canvas" height="220"></canvas>
        </div>
        <!-- Duplicate trend by year -->
        <div class="chart-box">
            <h3>🔁 Duplicate Groups by Year</h3>
            <canvas id="chartDupTrend" class="chart-canvas" height="220"></canvas>
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

<!-- =========================================================
     CHART.JS (CDN)
========================================================== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // ================================================================
    // CHART DATA FROM PHP (SAFE)
    // ================================================================
    const monthWiseData = <?php
        $labels  = [];
        $counts  = [];

        if (!empty($month_wise_counts)) {
            foreach ($month_wise_counts as $r) {
                $mName = isset($monthNames[$r['for_month']]) ? $monthNames[$r['for_month']] : $r['for_month'];
                $labels[] = $mName . ' ' . $r['for_year'];
                $counts[] = (int)$r['record_count'];
            }
        }

        echo json_encode([
            'labels' => $labels,
            'counts' => $counts
        ], JSON_NUMERIC_CHECK);
    ?>;

    const dupTrendData = <?php
        $dtLabels = [];
        $dtCounts = [];

        if (!empty($duplicate_trend)) {
            foreach ($duplicate_trend as $r) {
                $dtLabels[] = $r['for_year'];
                $dtCounts[] = (int)$r['dup_groups'];
            }
        }

        echo json_encode([
            'labels' => $dtLabels,
            'counts' => $dtCounts
        ], JSON_NUMERIC_CHECK);
    ?>;

    // ================================================================
    // MONTH-WISE CHART
    // ================================================================
    const monthCanvas = document.getElementById('chartMonthWise');
    if (monthCanvas) {
        new Chart(monthCanvas, {
            type: 'bar',
            data: {
                labels: monthWiseData.labels,
                datasets: [{
                    label: 'Records',
                    data: monthWiseData.counts,
                    backgroundColor: 'rgba(0,51,102,0.65)',
                    borderColor: '#003366',
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness: 25
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        ticks: {
                            font: { size: 10 },
                            maxRotation: 60,
                            minRotation: 30
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: { size: 11 },
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    // ================================================================
    // DUPLICATE TREND CHART
    // ================================================================
    const dupCanvas = document.getElementById('chartDupTrend');
    if (dupCanvas) {
        new Chart(dupCanvas, {
            type: 'line',
            data: {
                labels: dupTrendData.labels,
                datasets: [{
                    label: 'Dup Groups',
                    data: dupTrendData.counts,
                    backgroundColor: 'rgba(198,40,40,0.15)',
                    borderColor: '#c62828',
                    borderWidth: 2,
                    pointBackgroundColor: '#c62828',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { ticks: { font: { size: 11 } } },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: { size: 11 },
                            precision: 0
                        }
                    }
                }
            }
        });
    }

});