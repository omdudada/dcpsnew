UPDATE dpt_master_dcps
SET 
    for_month = MONTH(salary_end_date),
    for_year = YEAR(salary_end_date)
WHERE salary_end_date = '31-12-2006' and id =1;



UPDATE dpt_master_dcps
SET 
    for_month = MONTH(STR_TO_DATE(salary_end_date, '%d-%m-%Y')),
    for_year = YEAR(STR_TO_DATE(salary_end_date, '%d-%m-%Y'))
WHERE salary_end_date = '31-12-2006' and id =1;


UPDATE dpt_master_dcps
SET 
    for_month = MONTH(STR_TO_DATE(salary_end_date, '%d-%m-%Y')),
    for_year = YEAR(STR_TO_DATE(salary_end_date, '%d-%m-%Y'))
WHERE salary_end_date is not null and salary_end_date != "";
---------------------------------------------------------------------------


UPDATE dpt_master_dcps AS main
JOIN dpt_master_dcps_12082025_1 AS backup 
    ON main.id = backup.id
SET 
    main.for_month = backup.for_month,
    main.for_year  = backup.for_year
WHERE 1;




