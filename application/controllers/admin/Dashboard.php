<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/DashboardModel', 'dModel');
        $this->load->library('session');
    }

    // =========================================================================
    // MAIN DASHBOARD INDEX
    // =========================================================================
    public function index()
    {
        $data['title'] = 'Dashboard - DCPS Nashik';

        // --- Summary Counts ---
        $data['total_records'] = $this->dModel->getTotalRecords();
        $data['total_employees'] = $this->dModel->getTotalEmployees();
        $data['total_emp_master'] = $this->dModel->getTotalEmployeesInMaster();
        $data['duplicate_count'] = $this->dModel->getDuplicateRecordsCount();
        $data['duplicate_groups'] = $this->dModel->getDuplicateCount();

        // --- Filter dropdowns ---
        $data['employee_list'] = $this->dModel->getEmployeeList();
        $data['year_list'] = $this->dModel->getYearList();

        // --- Missing months: computed via AJAX to avoid page-load timeout ---
        // Count only — much lighter than computing all records
        $data['missing_count'] = 0; // loaded via AJAX button in the view
        $data['missing_records'] = [];

        // --- Chart data ---
        $monthWise = $this->dModel->getMonthWiseRecordCount();
        $data['month_wise_counts'] = is_array($monthWise) ? $monthWise : [];
        $dupTrend = $this->dModel->getDuplicateTrend();
        $data['duplicate_trend'] = is_array($dupTrend) ? $dupTrend : [];

        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/dashboard_new', $data);
        $this->load->view('admin/common/footer');
    }

    // =========================================================================
    // AJAX: Duplicate Records (DataTable server-side friendly)
    // =========================================================================
    public function getDuplicates()
    {
        $limit = (int) ($this->input->get('length') ?: 100);
        $offset = (int) ($this->input->get('start') ?: 0);

        $records = $this->dModel->getDuplicateRecords($limit, $offset);
        $total = $this->dModel->getDuplicateRecordsCount();

        echo json_encode([
            'draw' => (int) $this->input->get('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $records,
        ]);
    }

    // =========================================================================
    // AJAX: Missing Months (JSON response)
    // =========================================================================
    public function getMissingMonths()
    {
        $missing = $this->_computeMissingMonths();
        echo json_encode([
            'count' => $missing['count'],
            'records' => array_slice($missing['records'], 0, 500),
        ]);
    }

    // =========================================================================
    // HELPER: Compute missing months for every employee
    // Logic: Find the span of months each employee has records for (min→max in
    //        financial-year order: Apr=4 ... Mar=3 of next year) and flag gaps.
    // =========================================================================
    private function _computeMissingMonths()
    {
        $rows = $this->dModel->getExistingMonthYearByEmp();
        $employees = $this->dModel->getEmployeesWithJoiningDate();

        // Build a lookup: emp_td → set of "year-month" strings
        $empMonths = [];
        foreach ($rows as $row) {
            $empMonths[$row['emp_td']][$row['for_year']][$row['for_month']] = true;
        }

        // Build emp info map
        $empInfo = [];
        foreach ($employees as $emp) {
            $empInfo[$emp['emp_td']] = $emp;
        }

        // Financial year month order: 4,5,6,7,8,9,10,11,12,1,2,3
        // For each employee determine the range: earliest financial year → latest
        $missing = [];
        $totalMissing = 0;

        foreach ($empMonths as $empId => $yearData) {
            $allYears = array_keys($yearData);
            $minYear = min($allYears);
            $maxYear = max($allYears);

            $empName = isset($empInfo[$empId]) ? $empInfo[$empId]['emp_name'] : "EMP-{$empId}";

            // Iterate every financial year in range
            for ($fy = $minYear; $fy <= $maxYear; $fy++) {
                // April–December of $fy
                for ($m = 4; $m <= 12; $m++) {
                    if (!isset($yearData[$fy][$m])) {
                        $missing[] = [
                            'emp_td' => $empId,
                            'emp_name' => $empName,
                            'for_year' => $fy,
                            'for_month' => $m,
                            'f_year' => $fy . '-' . ($fy + 1),
                        ];
                        $totalMissing++;
                    }
                }
                // Jan–March of ($fy+1)
                $nextYear = $fy + 1;
                for ($m = 1; $m <= 3; $m++) {
                    if (!isset($yearData[$nextYear][$m]) && $nextYear <= $maxYear) {
                        $missing[] = [
                            'emp_td' => $empId,
                            'emp_name' => $empName,
                            'for_year' => $nextYear,
                            'for_month' => $m,
                            'f_year' => $fy . '-' . $nextYear,
                        ];
                        $totalMissing++;
                    }
                }
            }
        }

        return ['count' => $totalMissing, 'records' => $missing];
    }

    // =========================================================================
    // AJAX: Ledger Summary (filtered)
    // =========================================================================
    public function ledgerSummary()
    {
        $filters = [
            'emp_id' => $this->input->get_post('emp_id'),
            'for_year' => $this->input->get_post('for_year'),
        ];
        $records = $this->dModel->getLedgerSummary($filters);
        echo json_encode($records);
    }

    // =========================================================================
    // AJAX: Deduction Summary (filtered)
    // =========================================================================
    public function deductionSummary()
    {
        $filters = [
            'emp_id' => $this->input->get_post('emp_id'),
            'for_year' => $this->input->get_post('for_year'),
        ];
        $records = $this->dModel->getDeductionSummary($filters);
        echo json_encode($records);
    }

    // =========================================================================
    // PAGE: Records By Month & Year (linked from month-wise count table)
    // Opens full record listing for a given month+year — same layout as
    // admin/monthlyrecord/missing_month_year_listing so user can Edit records.
    // =========================================================================
    public function recordsByMonthYear($month = 0, $year = 0)
    {
        $month = (int) $month;
        $year = (int) $year;

        if ($month < 1 || $month > 12 || $year < 1900) {
            show_404();
        }

        $data['records'] = $this->dModel->getRecordsByMonthYear($month, $year);
        $data['for_month'] = $month;
        $data['for_year'] = $year;
        $data['title'] = 'Records — ' . date('F', mktime(0, 0, 0, $month, 1)) . ' ' . $year;

        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/dashboard_records_by_month', $data);
        $this->load->view('admin/common/footer');
    }
}
?>