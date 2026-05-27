-- =====================================================================
-- Validation Queries for Yearly Balance Implementation
-- =====================================================================
--
-- Use these queries to verify the correctness of the yearly balance
-- calculations and identify any data inconsistencies.
--
-- =====================================================================

-- =====================================================================
-- 1. CHECK TABLE STRUCTURE
-- =====================================================================
-- Verify that dpt_yearly_interest table has all required columns

SELECT 
    COLUMN_NAME,
    COLUMN_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT,
    COLUMN_COMMENT
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = 'dpt_yearly_interest' AND TABLE_SCHEMA = DATABASE()
ORDER BY ORDINAL_POSITION;

-- Expected columns to exist:
-- - id
-- - employee_id
-- - emp_name
-- - f_year
-- - opening_balance (required)
-- - emp_contri
-- - nmc_contri
-- - interest
-- - grand_total
-- - is_calculated
-- - updated_at (required)

-- =====================================================================
-- 2. COUNT RECORDS BY FISCAL YEAR
-- =====================================================================
-- How many employees have records for each fiscal year?

SELECT 
    f_year,
    COUNT(DISTINCT employee_id) as employee_count,
    MIN(opening_balance) as min_opening,
    MAX(opening_balance) as max_opening,
    AVG(opening_balance) as avg_opening,
    MIN(grand_total) as min_closing,
    MAX(grand_total) as max_closing,
    AVG(grand_total) as avg_closing
FROM dpt_yearly_interest
GROUP BY f_year
ORDER BY f_year;

-- =====================================================================
-- 3. VERIFY BALANCE CONTINUITY
-- =====================================================================
-- Check if opening balance of year N = closing balance of year N-1
-- This is critical for data integrity

SELECT 
    a.employee_id,
    a.emp_name,
    a.f_year as 'FY N-1',
    b.f_year as 'FY N',
    a.grand_total as 'FY(N-1) Closing',
    b.opening_balance as 'FY(N) Opening',
    (a.grand_total - b.opening_balance) as 'Difference',
    ABS(a.grand_total - b.opening_balance) as 'Abs Difference'
FROM dpt_yearly_interest a
JOIN dpt_yearly_interest b ON a.employee_id = b.employee_id
WHERE a.f_year LIKE CONCAT(YEAR(CURDATE()), '-%')
    OR a.f_year IN (
        SELECT DISTINCT f_year FROM dpt_yearly_interest 
        ORDER BY f_year DESC LIMIT 2
    )
HAVING ABS(a.grand_total - b.opening_balance) > 0.01
ORDER BY a.employee_id, a.f_year;

-- If this query returns NO rows, continuity is correct ✓
-- If this query returns rows, there are discontinuities ✗

-- =====================================================================
-- 4. FIND DISCONTINUITIES FOR EACH EMPLOYEE
-- =====================================================================
-- Identify specific employees and years with balance breaks

SELECT 
    a.employee_id,
    MAX(de.emp_name) as emp_name,
    a.f_year,
    a.grand_total as previous_closing,
    (SELECT opening_balance FROM dpt_yearly_interest d2 
     WHERE d2.employee_id = a.employee_id 
     AND d2.f_year > a.f_year 
     LIMIT 1) as next_opening,
    (a.grand_total - COALESCE((SELECT opening_balance FROM dpt_yearly_interest d2 
     WHERE d2.employee_id = a.employee_id 
     AND d2.f_year > a.f_year 
     LIMIT 1), 0)) as difference
FROM dpt_yearly_interest a
LEFT JOIN dpt_emp_master de ON de.emp_id = a.employee_id
GROUP BY a.employee_id, a.f_year
HAVING difference > 0.01
ORDER BY a.employee_id, a.f_year;

-- =====================================================================
-- 5. CHECK FOR ZERO OPENING BALANCES
-- =====================================================================
-- Find employees with zero opening balance in years other than 2005-2006

SELECT 
    employee_id,
    emp_name,
    f_year,
    opening_balance,
    grand_total,
    COUNT(*) as record_count
FROM dpt_yearly_interest
WHERE f_year NOT IN ('2005-2006')
    AND opening_balance = 0
GROUP BY employee_id, f_year
ORDER BY employee_id, f_year;

-- If employee has data in 2008-2009 but opening_balance is 0 in 2009-2010,
-- this indicates a missing previous year or calculation error.

-- =====================================================================
-- 6. VERIFY CONTRIBUTIONS ARE BEING CAPTURED
-- =====================================================================
-- Check if employees with contributions have non-zero values in dpt_yearly_interest

SELECT 
    ye.employee_id,
    ye.emp_name,
    ye.f_year,
    ye.opening_balance,
    ye.emp_contri,
    ye.nmc_contri,
    ye.interest,
    ye.grand_total,
    (SELECT COUNT(*) FROM dpt_master_dcps m
     WHERE m.emp_td = ye.employee_id
     AND ((m.for_month >= 4 AND m.for_month <= 12 AND m.for_year = CAST(LEFT(ye.f_year, 4) AS UNSIGNED))
          OR (m.for_month >= 1 AND m.for_month <= 3 AND m.for_year = CAST(RIGHT(ye.f_year, 4) AS UNSIGNED)))
     AND m.is_deleted = 0
    ) as contribution_records
FROM dpt_yearly_interest ye
WHERE ye.f_year >= '2008-2009'
    AND ye.grand_total > 0
LIMIT 50;

-- =====================================================================
-- 7. SAMPLE EMPLOYEE FULL PROGRESSION
-- =====================================================================
-- Display complete balance progression for a sample employee (change 9255 to test employee)

SELECT 
    employee_id,
    f_year,
    opening_balance,
    emp_contri,
    nmc_contri,
    interest,
    grand_total,
    (grand_total - opening_balance) as net_change,
    ROUND(((grand_total - opening_balance) / NULLIF(opening_balance, 0) * 100), 2) as growth_percent,
    is_calculated
FROM dpt_yearly_interest
WHERE employee_id = 9255
ORDER BY f_year;

-- =====================================================================
-- 8. CHECK FOR DUPLICATE RECORDS
-- =====================================================================
-- Find employees with duplicate entries for the same fiscal year

SELECT 
    employee_id,
    f_year,
    COUNT(*) as duplicate_count,
    GROUP_CONCAT(id SEPARATOR ',') as record_ids
FROM dpt_yearly_interest
GROUP BY employee_id, f_year
HAVING COUNT(*) > 1
ORDER BY employee_id, f_year;

-- If this returns rows, there are duplicate records that need cleanup.

-- =====================================================================
-- 9. VERIFY INTEREST CALCULATION PATTERNS
-- =====================================================================
-- Check if interest amounts seem reasonable (typically 5-10% of balance)

SELECT 
    f_year,
    COUNT(DISTINCT employee_id) as emp_count,
    MIN(interest) as min_interest,
    MAX(interest) as max_interest,
    AVG(interest) as avg_interest,
    MIN(grand_total) as min_balance,
    MAX(grand_total) as max_balance,
    ROUND(AVG(interest) / AVG(NULLIF(grand_total, 0)) * 100, 2) as avg_interest_rate_percent
FROM dpt_yearly_interest
WHERE interest IS NOT NULL
GROUP BY f_year
ORDER BY f_year;

-- Interest rates should typically be in range 7-10% based on government rates.

-- =====================================================================
-- 10. FIND EMPLOYEES WITH MISSING YEARS
-- =====================================================================
-- Identify gaps in the year sequence for any employee

SELECT DISTINCT
    ye1.employee_id,
    ye1.emp_name,
    ye1.f_year as 'Has This Year',
    (SELECT GROUP_CONCAT(DISTINCT f_year ORDER BY f_year) 
     FROM dpt_yearly_interest ye3 
     WHERE ye3.employee_id = ye1.employee_id) as all_years
FROM dpt_yearly_interest ye1
ORDER BY ye1.employee_id, ye1.f_year;

-- Manually review if employees should have complete 2005-2025 coverage
-- or if their employment started later.

-- =====================================================================
-- 11. SUMMARY STATISTICS
-- =====================================================================
-- Overall summary of the yearly_interest table

SELECT 
    'Total Records' as metric,
    COUNT(*) as value
FROM dpt_yearly_interest
UNION ALL
SELECT 'Total Employees', COUNT(DISTINCT employee_id) FROM dpt_yearly_interest
UNION ALL
SELECT 'Total Fiscal Years', COUNT(DISTINCT f_year) FROM dpt_yearly_interest
UNION ALL
SELECT 'Records with opening_balance = 0', 
    COUNT(*) FROM dpt_yearly_interest WHERE opening_balance = 0 OR opening_balance IS NULL
UNION ALL
SELECT 'Records with grand_total > 0', 
    COUNT(*) FROM dpt_yearly_interest WHERE grand_total > 0
UNION ALL
SELECT 'Total Opening Balance Sum', 
    SUM(opening_balance) FROM dpt_yearly_interest
UNION ALL
SELECT 'Total Closing Balance Sum', 
    SUM(grand_total) FROM dpt_yearly_interest;

-- =====================================================================
-- 12. IDENTIFY POTENTIAL DATA QUALITY ISSUES
-- =====================================================================
-- Flag rows that may have calculation errors or data entry issues

SELECT 
    id,
    employee_id,
    f_year,
    opening_balance,
    emp_contri,
    nmc_contri,
    interest,
    grand_total,
    CASE 
        WHEN opening_balance IS NULL THEN 'NULL opening_balance'
        WHEN grand_total IS NULL THEN 'NULL grand_total'
        WHEN grand_total < opening_balance THEN 'Negative net contribution'
        WHEN interest > (grand_total * 0.15) THEN 'Interest > 15% (high)'
        WHEN grand_total = 0 AND opening_balance = 0 THEN 'All zeros'
        ELSE 'OK'
    END as data_quality_flag
FROM dpt_yearly_interest
WHERE (grand_total < opening_balance 
   OR interest > (grand_total * 0.15)
   OR opening_balance IS NULL 
   OR grand_total IS NULL)
ORDER BY employee_id, f_year;

-- =====================================================================
-- 13. COMPARE WITH LIVE DEDUCTION DATA
-- =====================================================================
-- Spot-check: verify that yearly totals match deduction record sums

SELECT 
    'Yearly Interest Table' as source,
    9255 as emp_id,
    '2008-2009' as fy,
    SUM(emp_contri) as emp_contrib,
    SUM(nmc_contri) as nmc_contrib,
    SUM(interest) as interest
FROM dpt_yearly_interest
WHERE employee_id = 9255 AND f_year = '2008-2009'
UNION ALL
SELECT 
    'Live Deduction Records' as source,
    9255 as emp_id,
    '2008-2009' as fy,
    SUM(emp_DCPS_contribution + emp_DCPS_supplimentory_contribution) as emp_contrib,
    SUM(NMC_DCPS_contribution + NMC_supplimentory_DCPS_contribution) as nmc_contrib,
    0 as interest  -- Interest not in deduction records
FROM dpt_master_dcps
WHERE emp_td = 9255
    AND is_deleted = 0
    AND ((for_month >= 4 AND for_month <= 12 AND for_year = 2008)
         OR (for_month >= 1 AND for_month <= 3 AND for_year = 2009));

-- These should show matching contribution amounts (interest only in yearly_interest).

-- =====================================================================
-- 14. CHECK LAST UPDATE TIMESTAMPS
-- =====================================================================
-- See when records were last updated

SELECT 
    f_year,
    COUNT(*) as record_count,
    MIN(updated_at) as oldest_update,
    MAX(updated_at) as latest_update,
    DATEDIFF(MAX(updated_at), MIN(updated_at)) as days_span
FROM dpt_yearly_interest
GROUP BY f_year
ORDER BY latest_update DESC
LIMIT 20;

-- =====================================================================
-- NOTES FOR ANALYSIS:
-- =====================================================================
-- 
-- 1. Balance Continuity: Most important validation
--    Query #3 should return NO rows if data is consistent
--
-- 2. Interest Rates: Should typically be 8-10% for DCPS
--    Query #9 helps verify this
--
-- 3. Missing Years: If an employee has records for 2008-09 but not 2007-08,
--    this could be correct (if they didn't work then) or data might be incomplete
--
-- 4. Duplicates: Query #8 - if any duplicates found, cleanup needed before proceeding
--
-- 5. Zero Balances: Query #5 - employees with data should not have zero opening
--    in non-initial years. This indicates recalculation needed.
--
-- =====================================================================
