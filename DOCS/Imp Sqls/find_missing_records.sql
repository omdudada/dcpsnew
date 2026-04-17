SELECT
emp_td, pay_center, salary_type,
    recovered_DCPS_with_voucher_date,
    salary_start_date, salary_end_date, for_month, for_year, remark
FROM dpt_master_dcps
WHERE salary_type = 'Suplimentory' and for_month = 5 and for_year = 2014
  AND DATE_FORMAT(
        STR_TO_DATE(recovered_DCPS_with_voucher_date, '%d-%m-%Y'),
        '%Y-%m'
      ) =
      DATE_FORMAT(
        STR_TO_DATE(salary_start_date, '%d-%m-%Y'),
        '%Y-%m'
      )
	  and DATE_FORMAT(
        STR_TO_DATE(recovered_DCPS_with_voucher_date, '%d-%m-%Y'),
        '%d'
      ) not in (30,31)
and emp_td in (10024,10032,10035,10059,10063,10065,10070,10129,10135,10172,10180,10181,10198,5769,5914,8909,8912,9255,9427,9435,9444,9445,9506,9720,9725,9855,9873,9884,9943,9950,9971,9974)	  
	  ;
	  
	  

SELECT count(id) as cnt, 
emp_td, pay_center, salary_type,
recovered_DCPS_with_voucher_date,
salary_start_date, salary_end_date, for_month, for_year, remark
FROM dpt_master_dcps WHERE salary_type = 'Suplimentory' and for_month = 5 and for_year = 2009
AND DATE_FORMAT(
STR_TO_DATE(recovered_DCPS_with_voucher_date, '%d-%m-%Y'),
'%Y-%m'
) =
DATE_FORMAT(
STR_TO_DATE(salary_start_date, '%d-%m-%Y'),
'%Y-%m'
)
and DATE_FORMAT(
STR_TO_DATE(recovered_DCPS_with_voucher_date, '%d-%m-%Y'),
'%d'
) not in (30,31)


group by emp_td, for_month having cnt > 1 limit 10000






SELECT id,
emp_td, pay_center, salary_type,
    recovered_DCPS_with_voucher_date,
    salary_start_date, salary_end_date, for_month, for_year, remark
FROM dpt_master_dcps
WHERE salary_type = 'Suplimentory' and for_month = 5 and for_year = 2013
  AND DATE_FORMAT(
        STR_TO_DATE(recovered_DCPS_with_voucher_date, '%d-%m-%Y'),
        '%Y-%m'
      ) =
      DATE_FORMAT(
        STR_TO_DATE(salary_start_date, '%d-%m-%Y'),
        '%Y-%m'
      )
	  
and emp_td in (10024,10032,10035,10059,10063,10065,10070,10129,10135,10172,10180,10181,10198,8909,8912,9255,9427,9435,9444,9445,9506,9720,9725,9855,9873,9884,9943,9950,9971,9974);


-----------------------------------------------------------------------------Final ------------------------------------------------
SELECT 
d.id,
d.emp_td,
d.pay_center,
d.salary_type,
d.recovered_DCPS_with_voucher_date,
d.salary_start_date,
d.salary_end_date,
d.for_month,
d.for_year,
d.remark
FROM dpt_master_dcps d
WHERE d.salary_type = 'Suplimentory'
AND d.for_month = 6        -- May
AND d.for_year = 2007
AND d.emp_td IN (
	9067,9068,9069,9070,9071,9072,9073,9074,9075,9076,9079,9080,9081,9082,9083,9084,9087,9088,9089,9090,9091,9092,9093,9094,9095,9096,9097,9099,9100,9101,9106,9108,9109,9110,9111,9112,9113,9114,9115,9116,9117,9118,9119,9120,9121,9122,9123,9124,9125,9126,9127,9128,9129,9130,9131,9132,9133,9156,9360,9396,9403,9413,9483,9574,9618,9873
)
AND DATE_FORMAT(
	STR_TO_DATE(d.recovered_DCPS_with_voucher_date, '%d-%m-%Y'),
	'%Y-%m'
  ) =
  DATE_FORMAT(
	STR_TO_DATE(d.salary_start_date, '%d-%m-%Y'),
	'%Y-%m'
  )

AND NOT EXISTS (
	SELECT 1
	FROM dpt_master_dcps a
	WHERE a.emp_td = d.emp_td
	  AND a.for_month = 5
	  AND a.for_year = d.for_year
);

/*  --------------------------------------------*/
/*  Update query */
  
 

UPDATE dpt_master_dcps d
SET
    d.salary_start_date = '01-04-2012',
    d.salary_end_date   = '30-04-2012',
    d.for_month         = 4
WHERE d.salary_type = 'Suplimentory'
  AND d.for_month = 5
  AND d.for_year = 2012
  AND d.emp_td IN (
        10127,10129,10131,10132,10137,10151,10180,10181,5769,5914,8909,8912,9056,9198,9642,9644,9650,9657,9658,9659,9660,9661,9662,9666,9669,9670,9675,9679,9683,9698,9699,9704,9712,9713,9714,9715,9716,9717,9719,9723,9724,9727,9728,9732,9733,9737,9738,9748,9749,9750,9751,9752,9762,9767,9768,9772,9774,9783,9784,9786,9789,9790,9792,9793,9794,9795,9796,9804,9805,9807,9817,9826,9827,9828,9836,9837,9838,9839,9841,9843,9844,9847,9850,9851,9853,9854,9858,9864,9865,9868,9873,9874,9875,9876,9878,9881,9886,9888,9889,9890,9891,9892,9893,9901,9903,9904,9906,9907,9908,9909,9910,9911,9912,9914,9920,9921,9922,9923,9924,9927,9928,9930,9932
  )
  AND DATE_FORMAT(
        STR_TO_DATE(d.recovered_DCPS_with_voucher_date, '%d-%m-%Y'),
        '%Y-%m'
      ) =
      DATE_FORMAT(
        STR_TO_DATE(d.salary_start_date, '%d-%m-%Y'),
        '%Y-%m'
      )
  AND NOT EXISTS (
        SELECT 1
        FROM (
            SELECT emp_td, for_month, for_year
            FROM dpt_master_dcps
            WHERE for_month = 4
              AND for_year = 2012
        ) AS x
        WHERE x.emp_td = d.emp_td
  );
