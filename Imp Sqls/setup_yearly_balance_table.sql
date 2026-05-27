-- =====================================================================
-- Database Update Script for Yearly Opening/Closing Balances
-- =====================================================================
-- 
-- PURPOSE:
-- Initialize and maintain yearly opening and closing balances in 
-- dpt_yearly_interest table to support the new DB-driven ledger calculation.
--
-- The opening balance of FY (N) is the closing balance of FY (N-1).
-- After any deduction record edit, affected years are recalculated automatically
-- via the helper function in application/helpers/yearly_balance_helper.php
--
-- =====================================================================

-- Step 1: Ensure dpt_yearly_interest table has required columns
-- =====================================================================

ALTER TABLE `dpt_yearly_interest` 
ADD COLUMN IF NOT EXISTS `opening_balance` DECIMAL(15, 2) DEFAULT 0.00 COMMENT 'Opening balance = previous FY closing',
ADD COLUMN IF NOT EXISTS `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- =====================================================================
-- Step 2: Initialize opening balances for all employees
-- =====================================================================
-- 
-- For FY 2005-06, opening balance is 0 (starting year)
-- For FY 2006-07 onwards, opening balance = previous FY closing balance
--

UPDATE dpt_yearly_interest dyi1
SET dyi1.opening_balance = COALESCE(
    (SELECT dyi2.grand_total 
     FROM dpt_yearly_interest dyi2 
     WHERE dyi2.employee_id = dyi1.employee_id 
     AND dyi2.f_year = DATE_FORMAT(
         DATE_SUB(STR_TO_DATE(CONCAT(dyi1.f_year, '-01'), '%Y-%m-%d'), INTERVAL 1 YEAR), 
         '%Y-%m-%Y+1'
     )),
    0
)
WHERE dyi1.opening_balance = 0 OR dyi1.opening_balance IS NULL;

-- =====================================================================
-- Step 3: Verify the data - Check a sample employee's progression
-- =====================================================================

-- Uncomment to verify:
-- SELECT 
--     employee_id,
--     f_year,
--     opening_balance,
--     grand_total as closing_balance,
--     (grand_total - opening_balance) as net_contribution_and_interest
-- FROM dpt_yearly_interest
-- WHERE employee_id = 9255  -- Sample employee ID
-- ORDER BY f_year;

-- =====================================================================
-- Step 4: Test recalculation trigger
-- =====================================================================
-- 
-- When a deduction record is edited (via /admin/edit-dcps-deduction-record/ID):
-- 1. The record is updated in dpt_master_dcps table
-- 2. The ReportModel.updateDeductionRecord() calls the helper function
-- 3. The helper: recalculate_yearly_balances() updates dpt_yearly_interest
-- 4. Opening and closing balances are recalculated for all affected years
--
-- Debug logs: /application/logs/yearly_balance_recalc.txt

-- =====================================================================
-- Step 5: Manual recalculation script (if needed)
-- =====================================================================
-- 
-- If you need to manually trigger recalculation for an employee:
-- 1. Go to the admin panel
-- 2. Edit any deduction record for that employee
-- 3. Save the record - the helper function will automatically recalculate
--
-- Or execute PHP directly:
-- $this->load->model('admin/ReportModel', 'rModel');
-- $this->load->helper('yearly_balance');
-- $empId = 9255;
-- $startFY = 2005;
-- recalculate_yearly_balances($this->db, $empId, $startFY);

-- =====================================================================
-- Step 6: Validation Query
-- =====================================================================

SELECT 
    e.emp_id,
    e.emp_name,
    fy.f_year,
    fy.opening_balance,
    fy.emp_contri,
    fy.nmc_contri,
    fy.interest,
    fy.grand_total,
    (fy.grand_total - fy.opening_balance) as net_change
FROM dpt_yearly_interest fy
LEFT JOIN dpt_emp_master e ON e.emp_id = fy.employee_id
WHERE fy.employee_id = 9255
ORDER BY fy.f_year ASC
LIMIT 15;

-- =====================================================================
-- IMPORTANT NOTES:
-- =====================================================================
-- 
-- 1. AUTOMATIC RECALCULATION:
--    - When any deduction record is edited, the helper function automatically
--      recalculates yearly balances from that FY onward.
--    - All subsequent years are updated with new opening/closing balances.
--
-- 2. DEBUG LOGGING:
--    - Each recalculation writes detailed logs to:
--      /application/logs/yearly_balance_recalc.txt
--    - Review this file to verify recalculation success.
--
-- 3. CLOSING BALANCE OF FY(N-1) = OPENING BALANCE OF FY(N):
--    - This ensures seamless year-over-year balance continuity.
--
-- 4. FALLBACK:
--    - If database opening_balance is not found, the system falls back to 0.
--    - This is safe as it triggers a fresh calculation from that point.
--
-- 5. PERFORMANCE:
--    - The dpt_yearly_interest table is indexed by employee_id and f_year
--    - Lookups are O(1) - very fast database reads
--    - No more runtime FY-by-FY computations for each report view
--
-- =====================================================================
