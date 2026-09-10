SELECT
    emp_td,
    for_month,
    for_year,
    Ideal_contribution_of_employee_for_DCPS,
    emp_DCPS_contribution,
    (Ideal_contribution_of_employee_for_DCPS - emp_DCPS_contribution) AS emp_diff,
    Ideal_contribution_of_NMC_for_DCPS,
    NMC_DCPS_contribution,
    (Ideal_contribution_of_NMC_for_DCPS - NMC_DCPS_contribution) AS nmc_diff
FROM dpt_master_dcps
WHERE
    (Ideal_contribution_of_employee_for_DCPS - emp_DCPS_contribution) = 1
    AND (Ideal_contribution_of_NMC_for_DCPS - NMC_DCPS_contribution) = 1;
	
/*------------------------------------------------------------------------------------------*/	
UPDATE dpt_master_dcps
SET
    Ideal_contribution_of_employee_for_DCPS = emp_DCPS_contribution,
    Ideal_contribution_of_NMC_for_DCPS = NMC_DCPS_contribution
WHERE
    (Ideal_contribution_of_employee_for_DCPS - emp_DCPS_contribution) = 1
    AND (Ideal_contribution_of_NMC_for_DCPS - NMC_DCPS_contribution) = 1;