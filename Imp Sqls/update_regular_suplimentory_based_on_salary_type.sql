SELECT * FROM `dpt_master_dcps_12082025` WHERE `salary_type` = 'Regular' and emp_DCPS_supplimentory_contribution > 0 and emp_DCPS_contribution = 0; 



UPDATE dpt_master_dcps
SET 
    emp_DCPS_contribution = CASE
        WHEN salary_type = 'Regular' 
             AND (emp_DCPS_contribution = 0 OR emp_DCPS_contribution IS NULL)
             AND emp_DCPS_supplimentory_contribution > 0
        THEN emp_DCPS_supplimentory_contribution
        ELSE emp_DCPS_contribution
    END,
    
    emp_DCPS_supplimentory_contribution = CASE
        WHEN salary_type = 'Regular'              
             AND emp_DCPS_supplimentory_contribution > 0
        THEN 0
        ELSE emp_DCPS_supplimentory_contribution
    END,
    
    NMC_DCPS_contribution = CASE
        WHEN salary_type = 'Regular' 
             AND (NMC_DCPS_contribution = 0 OR NMC_DCPS_contribution IS NULL)
             AND NMC_supplimentory_DCPS_contribution > 0
        THEN NMC_supplimentory_DCPS_contribution
        ELSE NMC_DCPS_contribution
    END,
    
    NMC_supplimentory_DCPS_contribution = CASE
        WHEN salary_type = 'Regular' 
             AND NMC_supplimentory_DCPS_contribution > 0
        THEN 0
        ELSE NMC_supplimentory_DCPS_contribution
    END
WHERE 1;
--------------------------------------

SELECT * FROM `dpt_master_dcps` WHERE `salary_type` = 'Regular' and emp_DCPS_supplimentory_contribution = 0 and emp_DCPS_contribution > 0; 

------------------------------------------------------------------------------------------
SELECT * FROM `dpt_master_dcps_12082025` WHERE `salary_type` = 'Suplimentory' and (emp_DCPS_contribution > 0 or emp_DCPS_supplimentory_contribution = 0); 



UPDATE dpt_master_dcps
SET 
    emp_DCPS_supplimentory_contribution = CASE
        WHEN salary_type = 'Suplimentory' 
             AND (emp_DCPS_supplimentory_contribution = 0 OR emp_DCPS_supplimentory_contribution IS NULL)
             AND emp_DCPS_contribution > 0
        THEN emp_DCPS_contribution
        ELSE emp_DCPS_supplimentory_contribution
    END,
    
    emp_DCPS_contribution = CASE
        WHEN salary_type = 'Suplimentory' 
             AND emp_DCPS_contribution > 0
        THEN 0
        ELSE emp_DCPS_contribution
    END,
    
    NMC_supplimentory_DCPS_contribution = CASE
        WHEN salary_type = 'Suplimentory' 
             AND (NMC_supplimentory_DCPS_contribution = 0 OR NMC_supplimentory_DCPS_contribution IS NULL)
             AND NMC_DCPS_contribution > 0
        THEN NMC_DCPS_contribution
        ELSE NMC_supplimentory_DCPS_contribution
    END,
    
    NMC_DCPS_contribution = CASE
        WHEN salary_type = 'Suplimentory' 
             AND NMC_DCPS_contribution > 0
        THEN 0
        ELSE NMC_DCPS_contribution
    END
WHERE 1;


SELECT * FROM `dpt_master_dcps` WHERE `salary_type` = 'Suplimentory' and (emp_DCPS_supplimentory_contribution > 0); 

