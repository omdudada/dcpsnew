DELIMITER $$

CREATE PROCEDURE update_missing_pay_centers()
BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE v_emp_id INT;
    DECLARE cur CURSOR FOR 
        SELECT DISTINCT emp_td FROM dpt_master_dcps_new_19012025;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    OPEN cur;

    emp_loop: LOOP
        FETCH cur INTO v_emp_id;
        IF done THEN 
            LEAVE emp_loop;
        END IF;

        -- Loop for year 2005 to 2015
        DECLARE v_year INT DEFAULT 2005;
        WHILE v_year <= 2015 DO
            -- Get existing non-null pay_center for the year
            DECLARE v_pay_center INT;
            SELECT pay_center INTO v_pay_center
            FROM dpt_master_dcps_new_19012025
            WHERE emp_td = v_emp_id AND for_year = v_year AND pay_center IS NOT NULL AND pay_center != ''
            LIMIT 1;

            -- If pay_center found, then update other months
            IF v_pay_center IS NOT NULL THEN
                UPDATE dpt_master_dcps_new_19012025
                SET pay_center = v_pay_center
                WHERE emp_td = v_emp_id 
                    AND for_year = v_year
                    AND (pay_center IS NULL OR pay_center = '');
            END IF;

            SET v_year = v_year + 1;
        END WHILE;

    END LOOP;

    CLOSE cur;
END$$

DELIMITER ;
