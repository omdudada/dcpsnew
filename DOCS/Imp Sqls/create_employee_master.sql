
INSERT INTO dpt_emp_master_new
(
    emp_name,
    emp_id,
    pay_center,
    joining_date,
    created_by,
    created_date,
    last_modified
)
SELECT
    d.emp_name,
    d.emp_td,
    d.pay_center,
    d.joining_date,
    1,
    NOW(),
    NOW()
FROM dpt_master_dcps d
INNER JOIN (
    SELECT emp_td, MAX(id) AS max_id
    FROM dpt_master_dcps
    GROUP BY emp_td
) x ON x.emp_td = d.emp_td AND x.max_id = d.id
ON DUPLICATE KEY UPDATE
    emp_name = VALUES(emp_name),
    pay_center = VALUES(pay_center),    
    last_modified = NOW();



UPDATE dpt_emp_master_new
SET emp_id = TRIM(emp_id)
WHERE emp_id <> TRIM(emp_id);
