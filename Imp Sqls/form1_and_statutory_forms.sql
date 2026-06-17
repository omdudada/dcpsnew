-- =====================================================================
-- DCPS - FORM-1 (PRAN Application) schema + permission seed rows
-- Migration-ready script. Safe to re-run (IF NOT EXISTS / INSERT IGNORE).
-- DB prefix used by the application config is `dpt_`.
-- Reference GRs: Finance Dept GR No.CPS 1007/18/SER-4 dated 07-Jul-2007
--                and GR dated 03-Apr-2010 (FORM-1 / FORM-2 / FORM-3).
-- =====================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- 1. FORM-1 master : employee application for Pension Account No. (PRAN)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dpt_form1_application` (
  `id`                    INT(11)        NOT NULL AUTO_INCREMENT,
  `pran_no`               VARCHAR(50)    DEFAULT NULL COMMENT 'Permanent Retirement/Pension Account No.',
  `emp_id`                VARCHAR(50)    DEFAULT NULL COMMENT 'Link to dpt_emp_master.emp_id / dpt_master_dcps.emp_td',
  `salutation`            VARCHAR(20)    DEFAULT NULL,
  `first_name`            VARCHAR(100)   NOT NULL,
  `middle_name`           VARCHAR(100)   DEFAULT NULL,
  `last_name`             VARCHAR(100)   DEFAULT NULL,
  `gender`                ENUM('Male','Female','Other') DEFAULT NULL,
  `dob`                   VARCHAR(20)    DEFAULT NULL COMMENT 'dd.mm.yyyy',
  `date_of_joining`       VARCHAR(20)    DEFAULT NULL COMMENT 'Date of joining Govt service (dd.mm.yyyy)',
  `date_of_appointment`   VARCHAR(20)    DEFAULT NULL COMMENT 'dd.mm.yyyy',
  `designation_id`        INT(11)        DEFAULT NULL COMMENT 'FK -> dpt_designation.id',
  `pay_scale`             VARCHAR(100)   DEFAULT NULL,
  `office_name`           VARCHAR(255)   DEFAULT NULL,
  `office_address`        TEXT           DEFAULT NULL,
  `residential_address`   TEXT           DEFAULT NULL,
  `phone_no`              VARCHAR(20)    DEFAULT NULL,
  `mobile_no`             VARCHAR(15)    DEFAULT NULL,
  `email`                 VARCHAR(150)   DEFAULT NULL,
  `pay_center`            VARCHAR(100)   DEFAULT NULL,
  `ddo_code`              VARCHAR(50)    DEFAULT NULL COMMENT 'Drawing & Disbursing Officer code',
  `dept_code`             VARCHAR(50)    DEFAULT NULL,
  `treasury_code`         VARCHAR(50)    DEFAULT NULL,
  `pao_code`              VARCHAR(50)    DEFAULT NULL COMMENT 'Pay & Accounts Office code',
  `prev_govt_service`     TINYINT(1)     NOT NULL DEFAULT 0 COMMENT '1 = previously in another DCPS office',
  `prev_service_details`  TEXT           DEFAULT NULL,
  `form_scan`             VARCHAR(255)   DEFAULT NULL COMMENT 'Uploaded scanned FORM-1 file name',
  -- audit / soft delete (matching dpt_master_dcps convention)
  `created_by`            INT(11)        DEFAULT NULL,
  `created_date`          VARCHAR(30)    DEFAULT NULL,
  `updated_by`            INT(11)        DEFAULT NULL,
  `updated_date`          VARCHAR(30)    DEFAULT NULL,
  `is_deleted`            TINYINT(4)     NOT NULL DEFAULT 0,
  `deleted_by`            INT(11)        DEFAULT NULL,
  `deleted_date`          VARCHAR(30)    DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_form1_emp_id`     (`emp_id`),
  KEY `idx_form1_pran`       (`pran_no`),
  KEY `idx_form1_desig`      (`designation_id`),
  KEY `idx_form1_is_deleted` (`is_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- 2. FORM-1 child : nominee(s) for the pension account (1..n)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `dpt_form1_nominee` (
  `id`                INT(11)        NOT NULL AUTO_INCREMENT,
  `form1_id`          INT(11)        NOT NULL COMMENT 'FK -> dpt_form1_application.id',
  `nominee_name`      VARCHAR(200)   NOT NULL,
  `nominee_address`   TEXT           DEFAULT NULL,
  `dob`               VARCHAR(20)    DEFAULT NULL COMMENT 'dd.mm.yyyy',
  `relationship`      VARCHAR(100)   DEFAULT NULL,
  `share_percentage`  DECIMAL(5,2)   NOT NULL DEFAULT 0.00,
  `guardian_name`     VARCHAR(200)   DEFAULT NULL COMMENT 'Guardian if nominee is a minor',
  `created_by`        INT(11)        DEFAULT NULL,
  `created_date`      VARCHAR(30)    DEFAULT NULL,
  `updated_by`        INT(11)        DEFAULT NULL,
  `updated_date`      VARCHAR(30)    DEFAULT NULL,
  `is_deleted`        TINYINT(4)     NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_nominee_form1` (`form1_id`),
  CONSTRAINT `fk_nominee_form1`
      FOREIGN KEY (`form1_id`) REFERENCES `dpt_form1_application` (`id`)
      ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- 3. Permission / menu seed rows (kept consistent with dpt_controller /
--    dpt_action role model even though the live header menu is static).
--    Uses INSERT IGNORE so re-running is safe; adjust ids if they clash.
-- ---------------------------------------------------------------------
INSERT IGNORE INTO `dpt_controller`
  ( `controller_name`, `controller_value`, `is_menu`, `has_submenu`, `is_master`, `order_no`, `icon_class`, `route_url`)
VALUES
  ('form1',          'DCPS Forms',       1, 1, 0, 12, NULL, 'form1'),
  ('statutoryforms', 'Statutory Forms',  1, 1, 0, 13, NULL, 'statutory-forms');

INSERT IGNORE INTO `dpt_action`
  (`id`, `controller_id`, `action_name`, `action_value`, `is_menu`, `is_permission`, `icon_class`, `order_no`, `route_url`)
VALUES
  (40, 87, 'index',         'FORM-1 List',      1, 0, NULL, 12, 'form1'),
  (41, 87, 'add',           'FORM-1 Add',       0, 1, NULL, 12, 'form1/add'),
  (42, 87, 'edit',          'FORM-1 Edit',      0, 1, NULL, 12, 'form1/edit'),
  (43, 87, 'view',          'FORM-1 View',      0, 1, NULL, 12, 'form1/view'),
  (44, 87, 'delete',        'FORM-1 Delete',    0, 1, NULL, 12, 'form1/delete'),
  (45, 88, 'form2Schedule', 'FORM-2 Schedule',  1, 0, NULL, 13, 'statutory-forms/form2'),
  (46, 88, 'formR2',        'FORM-R-2',         1, 0, NULL, 13, 'statutory-forms/form-r2'),
  (47, 88, 'form3Register', 'FORM-3 Register',  1, 0, NULL, 13, 'statutory-forms/form3-register'),
  (48, 88, 'dayBook',       'Treasury Day Book',1, 0, NULL, 13, 'statutory-forms/day-book');

SET FOREIGN_KEY_CHECKS = 1;
