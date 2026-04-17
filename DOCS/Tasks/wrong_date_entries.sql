Some data are strored into the following format

Format 1:
41764
41765
41766
41768


Format 2:
28-06-2014
28-08-2010
28-09-2012


Format 3: 
4/13/2012
4/16/2012
4/23/2012
4/24/2012 


Create the mysql query to get the wrong data data which are not match to dd-mm-YYYY means 28-06-2014

Select the recovered_DCPS_with_voucher_date from dpt_master_dcps_new_19012025



SELECT * 
FROM dpt_master_dcps_new_19012025
WHERE recovered_DCPS_with_voucher_date != "" and recovered_DCPS_with_voucher_date != 0 and recovered_DCPS_with_voucher_date NOT REGEXP '^[0-3][0-9]-[0-1][0-9]-[0-9]{4}$';


SELECT * 
FROM dpt_master_dcps_new_19012025
WHERE salary_start_date != "" and salary_start_date != 0 and salary_start_date NOT REGEXP '^[0-3][0-9]-[0-1][0-9]-[0-9]{4}$';


SELECT * 
FROM dpt_master_dcps_new_19012025
WHERE salary_end_date != "" and salary_end_date != 0 and salary_end_date NOT REGEXP '^[0-3][0-9]-[0-1][0-9]-[0-9]{4}$';

SELECT * 
FROM dpt_master_dcps_new_19012025
WHERE to_be_recovered_for_voucher_date != "" and to_be_recovered_for_voucher_date != 0 and to_be_recovered_for_voucher_date NOT REGEXP '^[0-3][0-9]-[0-1][0-9]-[0-9]{4}$';

SELECT * 
FROM dpt_master_dcps_new_19012025
WHERE recovered_date != "" and recovered_date != 0 and recovered_date NOT REGEXP '^[0-3][0-9]-[0-1][0-9]-[0-9]{4}$';
