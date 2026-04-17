<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class DashboardModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
    }

    // =====================================================================
    // SUMMARY CARD COUNTS
    // =====================================================================

    /** Total non-deleted DCPS records */
    public function getTotalRecords() {
        $query = $this->db->query(
            "SELECT COUNT(*) as cnt FROM dpt_master_dcps WHERE is_deleted = 0 AND emp_td > 0"
        );
        return $query ? (int)$query->row()->cnt : 0;
    }

    /** Total unique employees */
    public function getTotalEmployees() {
        $query = $this->db->query(
            "SELECT COUNT(DISTINCT emp_td) as cnt FROM dpt_master_dcps WHERE is_deleted = 0 AND emp_td > 0"
        );
        return $query ? (int)$query->row()->cnt : 0;
    }

    /** Total employees in emp_master */
    public function getTotalEmployeesInMaster() {
        $query = $this->db->query("SELECT COUNT(*) as cnt FROM dpt_emp_master");
        return $query ? (int)$query->row()->cnt : 0;
    }

    // =====================================================================
    // DUPLICATE RECORDS DETECTION
    // =====================================================================

    /**
     * Count of groups that have more than one record with identical key fields.
     */
    public function getDuplicateCount() {
        $sql = "
            SELECT COUNT(*) as total FROM (
                SELECT emp_td, recovered_DCPS_with_voucher_no, recovered_DCPS_with_voucher_date,
                       basic, grade_pay, da, total_salary, Ideal_contribution_of_employee_for_DCPS,
                       COUNT(*) AS cnt
                FROM dpt_master_dcps
                WHERE is_deleted = 0 AND emp_td > 0
                GROUP BY emp_td, recovered_DCPS_with_voucher_no, recovered_DCPS_with_voucher_date,
                         basic, grade_pay, da, total_salary, Ideal_contribution_of_employee_for_DCPS
                HAVING COUNT(*) > 1
            ) AS dup_groups
        ";
        $query = $this->db->query($sql);
        return $query ? (int)$query->row()->total : 0;
    }

    /**
     * Total number of DUPLICATE records (not just groups).
     */
    public function getDuplicateRecordsCount() {
        $sql = "
            SELECT SUM(cnt) as total FROM (
                SELECT COUNT(*) AS cnt
                FROM dpt_master_dcps
                WHERE is_deleted = 0 AND emp_td > 0
                GROUP BY emp_td, recovered_DCPS_with_voucher_no, recovered_DCPS_with_voucher_date,
                         basic, grade_pay, da, total_salary, Ideal_contribution_of_employee_for_DCPS
                HAVING COUNT(*) > 1
            ) AS dup_groups
        ";
        $query = $this->db->query($sql);
        return $query ? (int)$query->row()->total : 0;
    }

    /**
     * Detailed list of duplicate records (all fields + emp name)
     */
    public function getDuplicateRecords($limit = 500, $offset = 0) {
        $sql = "
            SELECT 
                mst.id,
                mst.emp_td,
                COALESCE(em.emp_name, 'N/A') AS emp_name,
                mst.for_month,
                mst.for_year,
                mst.recovered_DCPS_with_voucher_no,
                mst.recovered_DCPS_with_voucher_date,
                mst.basic,
                mst.grade_pay,
                mst.da,
                mst.total_salary,
                mst.Ideal_contribution_of_employee_for_DCPS,
                mst.emp_DCPS_contribution,
                mst.NMC_DCPS_contribution,
                mst.salary_type,
                mst.remark,
                dup.cnt AS duplicate_count
            FROM dpt_master_dcps mst
            LEFT JOIN dpt_emp_master em ON em.emp_id = mst.emp_td
            INNER JOIN (
                SELECT emp_td, recovered_DCPS_with_voucher_no, recovered_DCPS_with_voucher_date,
                       basic, grade_pay, da, total_salary, Ideal_contribution_of_employee_for_DCPS,
                       COUNT(*) AS cnt
                FROM dpt_master_dcps
                WHERE is_deleted = 0 AND emp_td > 0
                GROUP BY emp_td, recovered_DCPS_with_voucher_no, recovered_DCPS_with_voucher_date,
                         basic, grade_pay, da, total_salary, Ideal_contribution_of_employee_for_DCPS
                HAVING COUNT(*) > 1
            ) AS dup 
                ON dup.emp_td = mst.emp_td
                AND COALESCE(dup.recovered_DCPS_with_voucher_no,'') = COALESCE(mst.recovered_DCPS_with_voucher_no,'')
                AND COALESCE(dup.recovered_DCPS_with_voucher_date,'') = COALESCE(mst.recovered_DCPS_with_voucher_date,'')
                AND COALESCE(dup.basic,0) = COALESCE(mst.basic,0)
                AND COALESCE(dup.grade_pay,0) = COALESCE(mst.grade_pay,0)
                AND COALESCE(dup.da,0) = COALESCE(mst.da,0)
                AND COALESCE(dup.total_salary,0) = COALESCE(mst.total_salary,0)
                AND COALESCE(dup.Ideal_contribution_of_employee_for_DCPS,0) = COALESCE(mst.Ideal_contribution_of_employee_for_DCPS,0)
            WHERE mst.is_deleted = 0
            ORDER BY mst.emp_td ASC, mst.for_year ASC, mst.for_month ASC
            LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        $query = $this->db->query($sql);
        return $query ? $query->result_array() : [];
    }

    // =====================================================================
    // MISSING MONTH DETECTION
    // =====================================================================

    /**
     * Get all (emp_td, for_month, for_year) combinations that exist.
     * Used to detect missing months across each employee's tenure.
     */
    public function getExistingMonthYearByEmp() {
        $sql = "
            SELECT emp_td, for_month, for_year
            FROM dpt_master_dcps
            WHERE is_deleted = 0 AND emp_td > 0
            GROUP BY emp_td, for_month, for_year
            ORDER BY emp_td, for_year, for_month
        ";
        $query = $this->db->query($sql);
        return $query ? $query->result_array() : [];
    }

    /**
     * Get employees with their joining date (to know starting month/year)
     */
    public function getEmployeesWithJoiningDate() {
        $sql = "
            SELECT DISTINCT mst.emp_td,
                COALESCE(em.emp_name, CONCAT('EMP-', mst.emp_td)) AS emp_name,
                em.joining_date,
                MIN(mst.for_year) AS min_year,
                MIN(mst.for_month) AS first_month
            FROM dpt_master_dcps mst
            LEFT JOIN dpt_emp_master em ON em.emp_id = mst.emp_td
            WHERE mst.is_deleted = 0 AND mst.emp_td > 0
            GROUP BY mst.emp_td, em.emp_name, em.joining_date
            ORDER BY mst.emp_td
        ";
        $query = $this->db->query($sql);
        return $query ? $query->result_array() : [];
    }

    // =====================================================================
    // MONTH-WISE RECORD COUNT (for charts)
    // =====================================================================

    public function getMonthWiseRecordCount() {
        $sql = "
            SELECT for_year, for_month, COUNT(*) AS record_count
            FROM dpt_master_dcps
            WHERE is_deleted = 0 AND emp_td > 0
            GROUP BY for_year, for_month
            ORDER BY for_year ASC, for_month ASC
        ";
        $query = $this->db->query($sql);
        return $query ? $query->result_array() : [];
    }

    // =====================================================================
    // LEDGER SUMMARY (for dashboard summary table)
    // =====================================================================

    public function getLedgerSummary($filters = []) {
        $sql = "
            SELECT 
                mst.emp_td,
                COALESCE(em.emp_name, 'N/A') AS emp_name,
                mst.for_year,
                SUM(mst.emp_DCPS_contribution + mst.emp_DCPS_supplimentory_contribution) AS total_emp_contribution,
                SUM(mst.NMC_DCPS_contribution + mst.NMC_supplimentory_DCPS_contribution) AS total_nmc_contribution,
                SUM(mst.loan_installment_paid_through_salary) AS total_loan_installment,
                SUM(mst.DCPS_loan_taken_by_an_employee) AS total_loan_taken,
                COUNT(*) AS months_covered
            FROM dpt_master_dcps mst
            LEFT JOIN dpt_emp_master em ON em.emp_id = mst.emp_td
            WHERE mst.is_deleted = 0 AND mst.emp_td > 0
        ";
        if (!empty($filters['emp_id'])) {
            $sql .= " AND mst.emp_td = " . (int)$filters['emp_id'];
        }
        if (!empty($filters['for_year'])) {
            $sql .= " AND mst.for_year = " . (int)$filters['for_year'];
        }
        $sql .= " GROUP BY mst.emp_td, mst.for_year, em.emp_name ORDER BY mst.emp_td, mst.for_year LIMIT 200";
        $query = $this->db->query($sql);
        return $query ? $query->result_array() : [];
    }

    // =====================================================================
    // DEDUCTION SUMMARY (for dashboard summary table)
    // =====================================================================

    public function getDeductionSummary($filters = []) {
        $sql = "
            SELECT 
                mst.emp_td,
                COALESCE(em.emp_name, 'N/A') AS emp_name,
                mst.for_year,
                SUM(mst.Ideal_contribution_of_employee_for_DCPS) AS total_ideal_contribution,
                SUM(mst.emp_DCPS_contribution) AS total_emp_regular,
                SUM(mst.emp_DCPS_supplimentory_contribution) AS total_emp_supplementary,
                SUM(mst.emp_DCPS_contribution + mst.emp_DCPS_supplimentory_contribution) AS total_emp_actual,
                SUM(mst.emp_DCPS_contribution + mst.emp_DCPS_supplimentory_contribution - mst.Ideal_contribution_of_employee_for_DCPS) AS total_difference,
                COUNT(*) AS months_covered
            FROM dpt_master_dcps mst
            LEFT JOIN dpt_emp_master em ON em.emp_id = mst.emp_td
            WHERE mst.is_deleted = 0 AND mst.emp_td > 0
        ";
        if (!empty($filters['emp_id'])) {
            $sql .= " AND mst.emp_td = " . (int)$filters['emp_id'];
        }
        if (!empty($filters['for_year'])) {
            $sql .= " AND mst.for_year = " . (int)$filters['for_year'];
        }
        $sql .= " GROUP BY mst.emp_td, mst.for_year, em.emp_name ORDER BY mst.emp_td, mst.for_year LIMIT 200";
        $query = $this->db->query($sql);
        return $query ? $query->result_array() : [];
    }

    // =====================================================================
    // EMPLOYEE LIST (for filter dropdown)
    // =====================================================================

    public function getEmployeeList() {
        $sql = "
            SELECT DISTINCT mst.emp_td as emp_id, 
                COALESCE(em.emp_name, CONCAT('EMP-', mst.emp_td)) AS emp_name
            FROM dpt_master_dcps mst
            LEFT JOIN dpt_emp_master em ON em.emp_id = mst.emp_td
            WHERE mst.is_deleted = 0 AND mst.emp_td > 0
            ORDER BY mst.emp_td ASC
        ";
        $query = $this->db->query($sql);
        return $query ? $query->result_array() : [];
    }

    // =====================================================================
    // YEAR LIST (for filter dropdown)
    // =====================================================================

    public function getYearList() {
        $sql = "
            SELECT DISTINCT for_year
            FROM dpt_master_dcps
            WHERE is_deleted = 0 AND emp_td > 0 AND for_year > 0
            ORDER BY for_year ASC
        ";
        $query = $this->db->query($sql);
        return $query ? $query->result_array() : [];
    }

    // =====================================================================
    // DUPLICATE TREND (year-wise duplicate groups)
    // =====================================================================

    public function getDuplicateTrend() {
        $sql = "
            SELECT for_year, COUNT(*) AS dup_groups
            FROM (
                SELECT for_year, emp_td, recovered_DCPS_with_voucher_no, recovered_DCPS_with_voucher_date,
                       basic, grade_pay, da, total_salary, Ideal_contribution_of_employee_for_DCPS,
                       COUNT(*) AS cnt
                FROM dpt_master_dcps
                WHERE is_deleted = 0 AND emp_td > 0
                GROUP BY for_year, emp_td, recovered_DCPS_with_voucher_no, recovered_DCPS_with_voucher_date,
                         basic, grade_pay, da, total_salary, Ideal_contribution_of_employee_for_DCPS
                HAVING COUNT(*) > 1
            ) AS d
            GROUP BY for_year
            ORDER BY for_year ASC
        ";
        $query = $this->db->query($sql);
        return $query ? $query->result_array() : [];
    }
}
?>