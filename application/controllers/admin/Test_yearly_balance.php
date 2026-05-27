<?php
/**
 * Test Script for Yearly Balance Calculation
 * 
 * This script tests the yearly balance calculation and update functionality.
 * Run this from the browser or CLI to verify the implementation.
 * 
 * Usage:
 * - From browser: http://your-site.com/admin/test-yearly-balance/employee_id/fiscal_year
 * - Example: http://your-site.com/admin/test-yearly-balance/9255/2005
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Test_yearly_balance extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('yearly_balance');
    }
    
    /**
     * Test recalculation for a specific employee and fiscal year
     * 
     * @param int $empId Employee ID
     * @param int $fyStart Fiscal year start (e.g., 2005 for 2005-2006)
     */
    public function index($empId = 0, $fyStart = 2005) {
        $empId = (int)$empId;
        $fyStart = (int)$fyStart;
        
        if ($empId <= 0) {
            $empId = 9255; // Default test employee
        }
        
        if ($fyStart < 2005) {
            $fyStart = 2005;
        }
        
        echo "<h1>Yearly Balance Calculation Test</h1>";
        echo "<hr>";
        
        // Display test parameters
        echo "<h2>Test Parameters</h2>";
        echo "<ul>";
        echo "<li>Employee ID: <strong>{$empId}</strong></li>";
        echo "<li>Starting Fiscal Year: <strong>{$fyStart}-" . ($fyStart + 1) . "</strong></li>";
        echo "<li>Time: <strong>" . date('Y-m-d H:i:s') . "</strong></li>";
        echo "</ul>";
        
        // Step 1: Get employee info
        echo "<h2>Step 1: Employee Information</h2>";
        $empData = $this->db->get_where('dpt_emp_master', array('emp_id' => $empId))->row_array();
        if ($empData) {
            echo "<p>Employee: <strong>" . htmlspecialchars($empData['emp_name']) . "</strong></p>";
            echo "<p>Joining Date: <strong>" . htmlspecialchars($empData['joining_date']) . "</strong></p>";
        } else {
            echo "<p style='color:red;'>ERROR: Employee not found</p>";
            return;
        }
        
        // Step 2: Test recalculation
        echo "<h2>Step 2: Running Recalculation...</h2>";
        $debugLog = APPPATH . 'logs/yearly_balance_recalc.txt';
        
        // Clear old logs for this test
        if (file_exists($debugLog)) {
            file_put_contents($debugLog, "\n\n" . str_repeat('=', 100) . "\n");
            file_put_contents($debugLog, "TEST RUN - " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        }
        
        $result = recalculate_yearly_balances($this->db, $empId, $fyStart, $debugLog);
        
        if ($result) {
            echo "<p style='color:green;'><strong>✓ Recalculation completed successfully</strong></p>";
        } else {
            echo "<p style='color:red;'><strong>✗ Recalculation failed</strong></p>";
        }
        
        // Step 3: Display yearly balances
        echo "<h2>Step 3: Updated Yearly Balances</h2>";
        
        $query = $this->db->query("
            SELECT 
                f_year,
                opening_balance,
                emp_contri,
                nmc_contri,
                interest,
                grand_total
            FROM dpt_yearly_interest
            WHERE employee_id = {$empId}
            ORDER BY f_year ASC
        ");
        
        $rows = $query->result_array();
        
        if (count($rows) > 0) {
            echo "<table border='1' cellpadding='10' style='border-collapse:collapse;'>";
            echo "<tr style='background-color:#f0f0f0;'>";
            echo "<th>Financial Year</th>";
            echo "<th>Opening Balance</th>";
            echo "<th>Emp Contributions</th>";
            echo "<th>NMC Contributions</th>";
            echo "<th>Interest</th>";
            echo "<th>Closing Balance</th>";
            echo "</tr>";
            
            foreach ($rows as $row) {
                $opening = (float)$row['opening_balance'];
                $closing = (float)$row['grand_total'];
                $change = $closing - $opening;
                $changeColor = ($change >= 0) ? '#90EE90' : '#FFB6C1';
                
                echo "<tr>";
                echo "<td><strong>" . htmlspecialchars($row['f_year']) . "</strong></td>";
                echo "<td style='text-align:right;'>" . number_format($opening, 2) . "</td>";
                echo "<td style='text-align:right;'>" . number_format((float)$row['emp_contri'], 2) . "</td>";
                echo "<td style='text-align:right;'>" . number_format((float)$row['nmc_contri'], 2) . "</td>";
                echo "<td style='text-align:right;'>" . number_format((float)$row['interest'], 2) . "</td>";
                echo "<td style='text-align:right; background-color:{$changeColor};'><strong>" . number_format($closing, 2) . "</strong></td>";
                echo "</tr>";
            }
            
            echo "</table>";
            echo "<p style='margin-top:15px;'><strong>Total Years Processed: " . count($rows) . "</strong></p>";
        } else {
            echo "<p style='color:orange;'>No yearly records found for this employee</p>";
        }
        
        // Step 4: Verify continuity
        echo "<h2>Step 4: Balance Continuity Verification</h2>";
        
        $continuityCheck = true;
        $prevClosing = 0;
        
        foreach ($rows as $row) {
            $opening = (float)$row['opening_balance'];
            $closing = (float)$row['grand_total'];
            
            // Check if opening matches previous closing
            if (abs($opening - $prevClosing) > 0.01) { // Allow small floating point errors
                echo "<p style='color:red;'>";
                echo "✗ Discontinuity found in " . htmlspecialchars($row['f_year']) . ": ";
                echo "Expected opening " . number_format($prevClosing, 2) . " but got " . number_format($opening, 2);
                echo "</p>";
                $continuityCheck = false;
            } else {
                echo "<p style='color:green;'>";
                echo "✓ " . htmlspecialchars($row['f_year']) . " is continuous (Opening: " . number_format($opening, 2) . " → Closing: " . number_format($closing, 2) . ")";
                echo "</p>";
            }
            
            $prevClosing = $closing;
        }
        
        if ($continuityCheck) {
            echo "<p style='color:green; font-weight:bold;'>✓ All years are continuous and properly linked</p>";
        } else {
            echo "<p style='color:red; font-weight:bold;'>✗ Some continuity issues detected - review above</p>";
        }
        
        // Step 5: Show debug logs
        echo "<h2>Step 5: Debug Logs</h2>";
        echo "<p><strong>Log file location:</strong> " . htmlspecialchars($debugLog) . "</p>";
        
        if (file_exists($debugLog)) {
            $logContent = file_get_contents($debugLog);
            $lastLines = array_slice(explode("\n", $logContent), -50); // Last 50 lines
            
            echo "<pre style='background-color:#f5f5f5; padding:10px; border:1px solid #ccc; max-height:400px; overflow:auto;'>";
            echo htmlspecialchars(implode("\n", $lastLines));
            echo "</pre>";
        }
        
        // Step 6: Helpful links and next steps
        echo "<h2>Step 6: Next Steps</h2>";
        echo "<ul>";
        echo "<li>View the full debug log: <code>" . htmlspecialchars($debugLog) . "</code></li>";
        echo "<li>Edit a deduction record to trigger automatic recalculation</li>";
        echo "<li>View the final ledger report to see updated opening balance</li>";
        echo "<li>Test with other employees: <a href='" . base_url("admin/test-yearly-balance/") . "'>Test with different employee</a></li>";
        echo "</ul>";
        
        echo "<hr>";
        echo "<p><a href='" . base_url('admin/misreport/final_ledger_report') . "'>← Back to Final Ledger Report</a></p>";
    }
    
    /**
     * Batch test for multiple employees
     * 
     * @param int $count Number of employees to test
     */
    public function batch($count = 5) {
        echo "<h1>Batch Yearly Balance Recalculation Test</h1>";
        echo "<hr>";
        
        $count = max(1, min((int)$count, 50)); // Limit to 50 max
        
        // Get sample employees
        $query = $this->db->query("
            SELECT DISTINCT emp_id 
            FROM dpt_emp_master 
            LIMIT {$count}
        ");
        
        $employees = $query->result_array();
        
        echo "<p>Testing " . count($employees) . " employees...</p>";
        echo "<table border='1' cellpadding='10' style='border-collapse:collapse;'>";
        echo "<tr style='background-color:#f0f0f0;'>";
        echo "<th>Employee ID</th>";
        echo "<th>Employee Name</th>";
        echo "<th>Status</th>";
        echo "<th>Years Processed</th>";
        echo "</tr>";
        
        foreach ($employees as $emp) {
            $empId = (int)$emp['emp_id'];
            
            // Get employee name
            $empData = $this->db->get_where('dpt_emp_master', array('emp_id' => $empId))->row_array();
            $empName = $empData ? htmlspecialchars($empData['emp_name']) : 'Unknown';
            
            // Run recalculation
            $this->load->helper('yearly_balance');
            $debugLog = APPPATH . 'logs/yearly_balance_recalc.txt';
            $result = recalculate_yearly_balances($this->db, $empId, 2005, $debugLog);
            
            // Count processed years
            $yearQuery = $this->db->query("
                SELECT COUNT(*) as cnt FROM dpt_yearly_interest WHERE employee_id = {$empId}
            ");
            $yearCount = $yearQuery->row()->cnt;
            
            $status = $result ? "<span style='color:green;'>✓ Success</span>" : "<span style='color:red;'>✗ Failed</span>";
            
            echo "<tr>";
            echo "<td>" . $empId . "</td>";
            echo "<td>" . $empName . "</td>";
            echo "<td>" . $status . "</td>";
            echo "<td>" . $yearCount . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        echo "<p><a href='" . base_url('admin/test-yearly-balance') . "'>← Back to Single Employee Test</a></p>";
    }
}

/* End of file test_yearly_balance.php */
