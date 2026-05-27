<?php
/**
 * Yearly Balance Helper
 * 
 * Helper functions for calculating and updating yearly opening/closing balances
 * in the dpt_yearly_interest table.
 * 
 * When a deduction record is edited, this helper recalculates all affected
 * financial years and updates their opening/closing balances sequentially.
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Recalculate yearly opening and closing balances for an employee
 * starting from a specific financial year onward.
 * 
 * The closing balance of FY (N-1) becomes the opening balance of FY (N).
 * This ensures yearly balances are always in sync with the actual contributions.
 *
 * @param CI_DB_Query_Builder $db Database connection
 * @param int $empId Employee ID
 * @param int $startFY Starting fiscal year (e.g., 2007 for 2007-2008)
 * @param string $debugLogFile Optional debug log file path
 * @return bool True if update successful, False otherwise
 */
function recalculate_yearly_balances($db, $empId, $startFY, $debugLogFile = '') {
    $empId = (int)$empId;
    $startFY = (int)$startFY;
    
    if ($empId <= 0 || $startFY < 2005) {
        return false;
    }
    
    $debugLog = $debugLogFile ? $debugLogFile : APPPATH . 'logs/yearly_balance_recalc.txt';
    
    // Log the recalculation start
    $logMsg = "\n" . str_repeat('=', 100) . "\n";
    $logMsg .= "[YEARLY_BALANCE_RECALC] EmpId: {$empId}, Starting FY: {$startFY}, Time: " . date('Y-m-d H:i:s') . "\n";
    $logMsg .= str_repeat('=', 100) . "\n";
    file_put_contents($debugLog, $logMsg, FILE_APPEND);
    
    $processedYears = array();
    
    try {
        // Start from 2005 and process sequentially to the end of data
        for ($fy = 2005; $fy <= 2025; $fy++) {
            $fyLabel = $fy . '-' . ($fy + 1);
            
            // Get the yearly record for this employee and FY
            $yearlyRecord = $db->get_where('dpt_yearly_interest', array(
                'employee_id' => $empId,
                'f_year' => $fyLabel
            ))->row_array();
            
            if (!$yearlyRecord) {
                continue; // No record for this year, skip
            }
            
            // Calculate opening balance from previous FY closing
            $openingBalance = 0.0;
            if ($fy > 2005) {
                $prevFyLabel = ($fy - 1) . '-' . $fy;
                $prevRecord = $db->get_where('dpt_yearly_interest', array(
                    'employee_id' => $empId,
                    'f_year' => $prevFyLabel
                ))->row_array();
                
                if ($prevRecord && isset($prevRecord['grand_total'])) {
                    $openingBalance = (float)$prevRecord['grand_total'];
                }
            }
            
            // Get all contributions for this FY
            $contributions = get_yearly_contributions($db, $empId, $fy);
            
            // Get interest rates for this FY
            $rates = get_interest_rates_for_fy($db, $fy);
            
            // Calculate closing balance
            $closingBalance = calculate_closing_balance(
                $openingBalance,
                $contributions,
                $rates,
                $fy
            );
            
            // Update the dpt_yearly_interest record with new opening and closing
            $updateData = array(
                'opening_balance' => $openingBalance,
                'grand_total' => $closingBalance,
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            $db->where('id', $yearlyRecord['id']);
            $db->update('dpt_yearly_interest', $updateData);
            
            $processedYears[] = array(
                'fy' => $fyLabel,
                'opening' => $openingBalance,
                'closing' => $closingBalance,
                'contributions' => $contributions
            );
            
            // Log this FY's calculation
            $stepLog = "[FY {$fyLabel}] Opening: " . number_format($openingBalance, 2) . 
                      " | Closing: " . number_format($closingBalance, 2) . "\n";
            file_put_contents($debugLog, $stepLog, FILE_APPEND);
        }
        
        // Log completion
        $completeLog = "\n[YEARLY_BALANCE_RECALC] Recalculation completed for EmpId: {$empId}\n";
        $completeLog .= "Processed " . count($processedYears) . " years\n";
        $completeLog .= str_repeat('-', 100) . "\n";
        file_put_contents($debugLog, $completeLog, FILE_APPEND);
        
        return true;
    } catch (Exception $e) {
        $errorLog = "\n[ERROR] " . $e->getMessage() . "\n";
        file_put_contents($debugLog, $errorLog, FILE_APPEND);
        return false;
    }
}

/**
 * Get yearly contributions for an employee in a specific financial year
 * 
 * @param CI_DB_Query_Builder $db Database connection
 * @param int $empId Employee ID
 * @param int $fyStart Fiscal year start (e.g., 2007 for 2007-2008)
 * @return array Aggregated contributions
 */
function get_yearly_contributions($db, $empId, $fyStart) {
    $empId = (int)$empId;
    $fyStart = (int)$fyStart;
    $fyEnd = $fyStart + 1;
    
    $sql = "
        SELECT 
            SUM(emp_DCPS_contribution) as emp_regular,
            SUM(emp_DCPS_supplimentory_contribution) as emp_supp,
            SUM(NMC_DCPS_contribution) as nmc_regular,
            SUM(NMC_supplimentory_DCPS_contribution) as nmc_supp,
            SUM(loan_installment_paid_through_salary) as loan_installment,
            SUM(DCPS_loan_taken_by_an_employee) as loan_taken
        FROM dpt_master_dcps
        WHERE emp_td = {$empId}
          AND is_deleted = 0
          AND (
              (for_month >= 4 AND for_month <= 12 AND for_year = {$fyStart})
              OR
              (for_month >= 1 AND for_month <= 3 AND for_year = {$fyEnd})
          )
    ";
    
    $query = $db->query($sql);
    $result = $query->row_array();
    
    return array(
        'emp_regular' => (float)($result['emp_regular'] ?: 0),
        'emp_supp' => (float)($result['emp_supp'] ?: 0),
        'nmc_regular' => (float)($result['nmc_regular'] ?: 0),
        'nmc_supp' => (float)($result['nmc_supp'] ?: 0),
        'loan_installment' => (float)($result['loan_installment'] ?: 0),
        'loan_taken' => (float)($result['loan_taken'] ?: 0),
    );
}

/**
 * Get interest rates for a specific financial year
 * 
 * @param CI_DB_Query_Builder $db Database connection
 * @param int $fyStart Fiscal year start
 * @return array Interest rates by month
 */
function get_interest_rates_for_fy($db, $fyStart) {
    $fyStart = (int)$fyStart;
    $fyEnd = $fyStart + 1;
    
    $sql = "
        SELECT gr_month, gr_percentage
        FROM dpt_gr_management
        WHERE (
            (gr_month >= 4 AND gr_month <= 12 AND gr_year = {$fyStart})
            OR
            (gr_month >= 1 AND gr_month <= 3 AND gr_year = {$fyEnd})
        )
    ";
    
    $query = $db->query($sql);
    $rates = array();
    
    if ($query) {
        foreach ($query->result_array() as $row) {
            $rates[(int)$row['gr_month']] = (float)$row['gr_percentage'];
        }
    }
    
    return $rates;
}

/**
 * Calculate closing balance for a financial year
 * 
 * Closing = Opening + (All Contributions) - (Loans Taken) + (Interest Earned)
 *
 * @param float $openingBalance Opening balance from previous year
 * @param array $contributions Contributions for the year
 * @param array $rates Interest rates by month
 * @param int $fyStart Fiscal year start
 * @return float Calculated closing balance
 */
function calculate_closing_balance($openingBalance, $contributions, $rates, $fyStart) {
    $openingBalance = (float)$openingBalance;
    
    // Total contributions (employee + NMC contributions - loan taken)
    $empContributions = $contributions['emp_regular'] + $contributions['emp_supp'] + 
                        $contributions['loan_installment'];
    $nmcContributions = $contributions['nmc_regular'] + $contributions['nmc_supp'];
    $totalLoanTaken = $contributions['loan_taken'];
    
    // Base balance for interest calculation
    $baseBalance = $openingBalance + $empContributions + $nmcContributions - $totalLoanTaken;
    
    // Calculate interest
    $interest = calculate_interest($baseBalance, $rates);
    
    // Closing = Opening + Contributions - Loans + Interest
    $closing = $openingBalance + $empContributions + $nmcContributions - $totalLoanTaken + $interest;
    
    return (float)$closing;
}

/**
 * Calculate total interest for a financial year
 * 
 * Interest is calculated month-by-month on the balance at that month.
 *
 * @param float $baseBalance Base balance for interest calculation
 * @param array $rates Interest rates by month
 * @return float Total interest earned
 */
function calculate_interest($baseBalance, $rates) {
    $totalInterest = 0.0;
    $monthsOrder = array(4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3);
    
    foreach ($monthsOrder as $month) {
        if (isset($rates[$month])) {
            $monthlyInterest = ($baseBalance * $rates[$month]) / 100 / 12;
            $totalInterest += $monthlyInterest;
        }
    }
    
    return (float)$totalInterest;
}

/**
 * Get opening balance from database for a specific financial year
 * 
 * This is used by the ledger report view to display opening balance.
 *
 * @param CI_DB_Query_Builder $db Database connection
 * @param int $empId Employee ID
 * @param int $fyStart Fiscal year start
 * @return float Opening balance from dpt_yearly_interest
 */
function get_opening_balance_from_db($db, $empId, $fyStart) {
    $empId = (int)$empId;
    $fyStart = (int)$fyStart;
    $fyLabel = $fyStart . '-' . ($fyStart + 1);
    
    $record = $db->get_where('dpt_yearly_interest', array(
        'employee_id' => $empId,
        'f_year' => $fyLabel
    ))->row_array();
    
    if ($record && isset($record['opening_balance'])) {
        return (float)$record['opening_balance'];
    }
    
    return 0.0;
}

/* End of file yearly_balance_helper.php */
