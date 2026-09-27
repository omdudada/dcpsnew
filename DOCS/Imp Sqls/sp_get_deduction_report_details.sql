-- ====================================================================================
-- Stored Procedures for DCPS Deduction Report (Form R-3)
-- Calculations built into MySQL Stored Procedure for direct data fetching
-- ====================================================================================

-- 1. Detailed Monthly Deduction Report Stored Procedure
DELIMITER //

DROP PROCEDURE IF EXISTS `sp_get_deduction_report_details` //

CREATE PROCEDURE `sp_get_deduction_report_details` (
    IN p_emp_id INT,
    IN p_pay_center INT,
    IN p_first_year INT,
    IN p_second_year INT,
    IN p_from_month INT,
    IN p_to_month INT
)
BEGIN
    SELECT 
        mst.id,
        mst.emp_td AS emp_id,
        em.emp_name,
        em.joining_date,
        mst.pay_center,
        dd.designation_name,
        mst.bunch_no,
        mst.file_no,
        mst.recovered_DCPS_with_voucher_no AS voucher_no,
        mst.recovered_DCPS_with_voucher_date AS voucher_date,
        mst.for_month,
        mst.for_year,
        
        -- Financial Year Calculation (e.g. 2008-2009)
        CASE 
            WHEN mst.for_month >= 4 AND mst.for_month <= 12 THEN CONCAT(mst.for_year, '-', mst.for_year + 1)
            ELSE CONCAT(mst.for_year - 1, '-', mst.for_year)
        END AS financial_year_label,

        CASE 
            WHEN mst.for_month >= 4 AND mst.for_month <= 12 THEN mst.for_year
            ELSE mst.for_year - 1
        END AS fy_start_year,

        -- Salary Breakdown & Total Salary
        COALESCE(mst.basic, 0) AS basic,
        COALESCE(mst.grade_pay, 0) AS grade_pay,
        COALESCE(mst.da, 0) AS da,
        COALESCE(mst.total_salary, (COALESCE(mst.basic, 0) + COALESCE(mst.grade_pay, 0) + COALESCE(mst.da, 0))) AS total_salary,

        -- 10% Expected / Ideal Employee Contribution
        COALESCE(mst.Ideal_contribution_of_employee_for_DCPS, 0) AS ideal_contribution,

        -- Actual Employee Contribution Deducted (Regular vs Supplementary)
        CASE 
            WHEN mst.salary_type = 'Regular' THEN COALESCE(mst.emp_DCPS_contribution, 0)
            ELSE COALESCE(mst.emp_DCPS_supplimentory_contribution, 0)
        END AS actual_emp_contribution,

        -- Employee Contribution Difference (Actual - Expected)
        (
            CASE 
                WHEN mst.salary_type = 'Regular' THEN COALESCE(mst.emp_DCPS_contribution, 0)
                ELSE COALESCE(mst.emp_DCPS_supplimentory_contribution, 0)
            END - COALESCE(mst.Ideal_contribution_of_employee_for_DCPS, 0)
        ) AS contribution_difference,

        mst.salary_start_date,
        mst.salary_end_date,

        -- Calculated Salary Type (Regular vs Supplementary)
        CASE 
            WHEN (COALESCE(mst.basic, 0) > 0 AND COALESCE(mst.grade_pay, 0) = 0 AND COALESCE(mst.da, 0) = 0) THEN 'Supplementary'
            ELSE 'Regular'
        END AS calculated_salary_type,

        mst.remark,
        mst.reason,
        mst.is_deleted

    FROM `dpt_master_dcps` AS mst
    LEFT JOIN `dpt_emp_master` AS em ON em.emp_id = mst.emp_td
    LEFT JOIN `dpt_designation` AS dd ON dd.id = mst.designation_id

    WHERE mst.is_deleted IN (0, 3) 
      AND mst.emp_td > 0
      AND (p_pay_center IS NULL OR p_pay_center = 0 OR mst.pay_center = p_pay_center)
      AND (p_emp_id IS NULL OR p_emp_id = 0 OR mst.emp_td = p_emp_id)
      AND (
          (p_from_month IS NULL OR p_from_month = 0 OR mst.for_month >= p_from_month)
          AND (p_to_month IS NULL OR p_to_month = 0 OR mst.for_month <= p_to_month)
      )
      AND (
          (p_first_year IS NULL OR p_first_year = 0)
          OR (
              (p_second_year IS NOT NULL AND p_second_year > 0 AND (
                  (mst.for_month >= 4 AND mst.for_month <= 12 AND mst.for_year = p_first_year)
                  OR
                  (mst.for_month >= 1 AND mst.for_month <= 3 AND mst.for_year = p_second_year)
              ))
              OR
              ((p_second_year IS NULL OR p_second_year = 0) AND mst.for_year = p_first_year)
          )
      )

    ORDER BY 
        mst.pay_center ASC, 
        CAST(mst.emp_td AS UNSIGNED) ASC, 
        CASE WHEN mst.for_month >= 4 THEN mst.for_year ELSE mst.for_year - 1 END ASC,
        CASE WHEN mst.for_month >= 4 THEN mst.for_month - 3 ELSE mst.for_month + 9 END ASC;

END //

DELIMITER ;


-- 2. Aggregated Yearly Summary Stored Procedure
DELIMITER //

DROP PROCEDURE IF EXISTS `sp_get_deduction_report_summary` //

CREATE PROCEDURE `sp_get_deduction_report_summary` (
    IN p_emp_id INT,
    IN p_pay_center INT,
    IN p_first_year INT,
    IN p_second_year INT
)
BEGIN
    SELECT 
        mst.emp_td AS emp_id,
        em.emp_name,
        dd.designation_name,
        mst.pay_center,
        
        CASE 
            WHEN mst.for_month >= 4 AND mst.for_month <= 12 THEN mst.for_year
            ELSE mst.for_year - 1
        END AS fy_start_year,

        CONCAT(
            CASE WHEN mst.for_month >= 4 AND mst.for_month <= 12 THEN mst.for_year ELSE mst.for_year - 1 END,
            '-',
            CASE WHEN mst.for_month >= 4 AND mst.for_month <= 12 THEN mst.for_year + 1 ELSE mst.for_year END
        ) AS financial_year_label,

        SUM(CASE WHEN mst.is_deleted != 3 THEN COALESCE(mst.basic, 0) ELSE 0 END) AS total_basic,
        SUM(CASE WHEN mst.is_deleted != 3 THEN COALESCE(mst.grade_pay, 0) ELSE 0 END) AS total_grade_pay,
        SUM(CASE WHEN mst.is_deleted != 3 THEN COALESCE(mst.da, 0) ELSE 0 END) AS total_da,
        SUM(CASE WHEN mst.is_deleted != 3 THEN COALESCE(mst.total_salary, (COALESCE(mst.basic, 0) + COALESCE(mst.grade_pay, 0) + COALESCE(mst.da, 0))) ELSE 0 END) AS total_salary,
        SUM(CASE WHEN mst.is_deleted != 3 THEN COALESCE(mst.Ideal_contribution_of_employee_for_DCPS, 0) ELSE 0 END) AS total_ideal_contribution,
        
        SUM(CASE WHEN mst.is_deleted != 3 THEN 
            CASE WHEN mst.salary_type = 'Regular' THEN COALESCE(mst.emp_DCPS_contribution, 0) ELSE COALESCE(mst.emp_DCPS_supplimentory_contribution, 0) END 
        ELSE 0 END) AS total_actual_contribution,

        SUM(CASE WHEN mst.is_deleted != 3 THEN 
            (
                CASE WHEN mst.salary_type = 'Regular' THEN COALESCE(mst.emp_DCPS_contribution, 0) ELSE COALESCE(mst.emp_DCPS_supplimentory_contribution, 0) END 
                - COALESCE(mst.Ideal_contribution_of_employee_for_DCPS, 0)
            ) 
        ELSE 0 END) AS total_difference,

        SUM(CASE WHEN mst.is_deleted != 3 AND (
            (CASE WHEN mst.salary_type = 'Regular' THEN COALESCE(mst.emp_DCPS_contribution, 0) ELSE COALESCE(mst.emp_DCPS_supplimentory_contribution, 0) END) 
            - COALESCE(mst.Ideal_contribution_of_employee_for_DCPS, 0)
        ) < 0 THEN 
            (CASE WHEN mst.salary_type = 'Regular' THEN COALESCE(mst.emp_DCPS_contribution, 0) ELSE COALESCE(mst.emp_DCPS_supplimentory_contribution, 0) END) 
            - COALESCE(mst.Ideal_contribution_of_employee_for_DCPS, 0)
        ELSE 0 END) AS total_negative_difference,

        SUM(CASE WHEN mst.is_deleted != 3 AND (
            (CASE WHEN mst.salary_type = 'Regular' THEN COALESCE(mst.emp_DCPS_contribution, 0) ELSE COALESCE(mst.emp_DCPS_supplimentory_contribution, 0) END) 
            - COALESCE(mst.Ideal_contribution_of_employee_for_DCPS, 0)
        ) > 0 THEN 
            (CASE WHEN mst.salary_type = 'Regular' THEN COALESCE(mst.emp_DCPS_contribution, 0) ELSE COALESCE(mst.emp_DCPS_supplimentory_contribution, 0) END) 
            - COALESCE(mst.Ideal_contribution_of_employee_for_DCPS, 0)
        ELSE 0 END) AS total_positive_difference

    FROM `dpt_master_dcps` AS mst
    LEFT JOIN `dpt_emp_master` AS em ON em.emp_id = mst.emp_td
    LEFT JOIN `dpt_designation` AS dd ON dd.id = mst.designation_id

    WHERE mst.is_deleted IN (0, 3) 
      AND mst.emp_td > 0
      AND (p_pay_center IS NULL OR p_pay_center = 0 OR mst.pay_center = p_pay_center)
      AND (p_emp_id IS NULL OR p_emp_id = 0 OR mst.emp_td = p_emp_id)
      AND (
          (p_first_year IS NULL OR p_first_year = 0)
          OR (
              (p_second_year IS NOT NULL AND p_second_year > 0 AND (
                  (mst.for_month >= 4 AND mst.for_month <= 12 AND mst.for_year = p_first_year)
                  OR
                  (mst.for_month >= 1 AND mst.for_month <= 3 AND mst.for_year = p_second_year)
              ))
              OR
              ((p_second_year IS NULL OR p_second_year = 0) AND mst.for_year = p_first_year)
          )
      )

    GROUP BY 
        mst.emp_td, 
        fy_start_year

    ORDER BY 
        mst.pay_center ASC, 
        CAST(mst.emp_td AS UNSIGNED) ASC, 
        fy_start_year ASC;

END //

DELIMITER ;
