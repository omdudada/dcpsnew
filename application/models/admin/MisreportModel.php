<?php if (!defined('BASEPATH'))
	exit('no direct script Access allowed');

class MisreportModel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getMasterDataOld($empId = "")
	{
		$this->db->select('*');
		$this->db->from('emp_master');
		if (isset($empId) && $empId != "") {
			$this->db->where("emp_id", $empId);
		}
		$query = $this->db->get();
		if ($query) {
			return $query->result_array();
		}
		return false;
	}

	public function getMasterData($empId = "", $payCenter = "")
	{
		$this->db->select('*');
		$this->db->from('dpt_emp_master');

		if (!empty($empId)) {
			$this->db->where("emp_td", $empId);
		}

		if (!empty($payCenter)) {
			$this->db->where("pay_center", $payCenter);
		}
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query ? $query->result_array() : false;
	}


	public function gerMasterDetails($empId = "", $payCenter = "")
	{
		$this->db->select('emp_name, emp_td as emp_id');
		$this->db->from('dpt_master_dcps');

		if (!empty($empId)) {
			$this->db->where("emp_td", $empId);
		}

		if (!empty($payCenter)) {
			$this->db->where("pay_center", $payCenter);
		}
		$this->db->group_by("emp_td"); // <-- Grouping by emp_td  
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query ? $query->result_array() : false;
	}

	public function getPayCenterData()
	{
		$this->db->select('pay_center');
		$this->db->from('dpt_master_dcps');
		$this->db->where('pay_center is not null and pay_center != "NA" and pay_center != "" and pay_center != 0');
		$this->db->group_by("pay_center");
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if ($query) {
			return $query->result_array();
		}
		return false;
	}


	public function getdcpsDetails($data)
	{
		$sql = "SELECT `emp_td`, 
			(sum(`emp_DCPS_contribution`)+sum(emp_DCPS_supplimentory_contribution)) as emp_DCPS_contribution, 
			(sum(`NMC_DCPS_contribution`)+sum(NMC_supplimentory_DCPS_contribution)) as `NMC_DCPS_contribution`, 
			((sum(`emp_DCPS_contribution`)+sum(emp_DCPS_supplimentory_contribution))+(sum(`NMC_DCPS_contribution`)+sum(NMC_supplimentory_DCPS_contribution))+sum(loan_installment_paid_through_salary)) as total_contribution, 
			sum(`loan_installment_paid_through_salary`) as loan_installment_paid_through_salary, 
			sum(`DCPS_loan_taken_by_an_employee`) as `DCPS_loan_taken_by_an_employee`, 
			`for_month`, 
			`for_year` 
			FROM `dpt_master_dcps` where is_deleted = 0 ";
		if (isset($data['emp_id']) && $data['emp_id'] != "") {
			$sql .= " AND `emp_td` = " . $data['emp_id'];
		}
		if (isset($data['first_year']) && $data['first_year'] != "" && isset($data['second_year']) && $data['second_year'] != "") {
			$sql .= " and  ((`for_month` >= 4 and `for_month` <= 12 && `for_year` = " . $data['first_year'] . ") Or (`for_month` >= 1 and `for_month` <= 3 && `for_year` = " . $data['second_year'] . ")) ";
		} elseif (isset($data['first_year']) && $data['first_year'] != "") {
			$sql .= " and  ((`for_month` >= 4 and `for_month` <= 12 && `for_year` = " . $data['first_year'] . ")) ";
		} elseif (isset($data['second_year']) && $data['second_year'] != "") {
			$sql .= " and  ((`for_month` >= 1 and `for_month` <= 3 && `for_year` = " . $data['second_year'] . ")) ";
		}

		//$sql .=" and emp_td = 8967 ";

		if (isset($data['emp_id']) && $data['emp_id'] != "") {
			$sql .= " group by for_month, emp_td, for_year ";
		} else {
			$sql .= " group by for_month, for_year ";
		}



		// Debugging: Log the constructed SQL query
		$debugLog = APPPATH . 'logs/final_ledger_model_debug.txt';
		//file_put_contents($debugLog, "\nConstructed SQL Query:\n$sql\n", FILE_APPEND);

		$query = $this->db->query($sql);
		$result = $query->result_array();

		// Debugging: Log the number of rows fetched
		$rowCount = count($result);
		//file_put_contents($debugLog, "Rows Fetched: $rowCount\n", FILE_APPEND);

		return $result;
	}

	public function getdcpsDetailsNewOriginal($data)
	{
		$sql = "SELECT mst.`emp_td`, em.emp_name, em.joining_date, em.pay_center, em.fixed_pay, em.salary_type,
			sum(`mst.Ideal_contribution_of_employee_for_DCPS`) as ideal_contribution, 
			sum(`mst.emp_DCPS_contribution`) as emp_DCPS_contribution, 
			sum(mst.emp_DCPS_supplimentory_contribution) as emp_DCPS_supplimentory_contribution, 
			sum(`mst.NMC_DCPS_contribution`) as `NMC_DCPS_contribution`, 
			sum(mst.NMC_supplimentory_DCPS_contribution) as `NMC_supplimentory_DCPS_contribution`,  		((sum(`mst.emp_DCPS_contribution`)+sum(mst.emp_DCPS_supplimentory_contribution))+(sum(mst.`NMC_DCPS_contribution`)+sum(mst.NMC_supplimentory_DCPS_contribution))+sum(mst.loan_installment_paid_through_salary)) as total_contribution, 
			sum(mst.`loan_installment_paid_through_salary`) as loan_installment_paid_through_salary, 
			sum(mst.`DCPS_loan_taken_by_an_employee`) as `DCPS_loan_taken_by_an_employee`, 
			mst.`for_month`, 
			mst.`for_year` 
			FROM `dpt_master_dcps_new_19012025` as mst where mst.is_deleted = 0 
			inner join dpt_emp_master as em on em.emp_id = mst.emp_td ";
		if (isset($data['emp_id']) && $data['emp_id'] != "") {
			$sql .= " AND mst.`emp_td` = " . $data['emp_id'];
		}
		if (isset($data['first_year']) && $data['first_year'] != "" && isset($data['second_year']) && $data['second_year'] != "") {
			$sql .= " and  ((mst.`for_month` >= 4 and mst.`for_month` <= 12 && mst.`for_year` = " . $data['first_year'] . ") Or (mst.`for_month` >= 1 and mst.`for_month` <= 3 && mst.`for_year` = " . $data['second_year'] . ")) ";
		} elseif (isset($data['first_year']) && $data['first_year'] != "") {
			$sql .= " and  ((mst.`for_month` >= 4 and mst.`for_month` <= 12 && mst.`for_year` = " . $data['first_year'] . ")) ";
		} elseif (isset($data['second_year']) && $data['second_year'] != "") {
			$sql .= " and  ((mst.`for_month` >= 1 and mst.`for_month` <= 3 && mst.`for_year` = " . $data['second_year'] . ")) ";
		}

		$sql .= " and mst.emp_td = 8967 ";

		if (isset($data['emp_id']) && $data['emp_id'] != "") {
			$sql .= " group by mst.for_month, mst.emp_td, mst.for_year ";
		} else {
			$sql .= " group by mst.for_month, mst.for_year ";
		}



		// Debugging: Log the constructed SQL query
		$debugLog = APPPATH . 'logs/final_ledger_model_debug.txt';
		//file_put_contents($debugLog, "\nConstructed SQL Query:\n$sql\n", FILE_APPEND);

		$query = $this->db->query($sql);
		$result = $query->result_array();

		// Debugging: Log the number of rows fetched
		$rowCount = count($result);
		//file_put_contents($debugLog, "Rows Fetched: $rowCount\n", FILE_APPEND);

		return $result;
	}

	public function getdcpsDetailsNew($data)
	{
		if (!empty($data)) {
			//echo "<pre>"; print_r($data); exit;
			$sql = "SELECT 
				mst.`emp_td`, 
				dd.designation_name, 
				em.emp_name, 
				mst.salary_type,
				em.joining_date, 
				mst.pay_center, 
				SUM(mst.`Ideal_contribution_of_employee_for_DCPS`) AS ideal_contribution, 
				SUM(mst.`emp_DCPS_contribution`) AS emp_DCPS_contribution, 
				SUM(mst.emp_DCPS_supplimentory_contribution) AS emp_DCPS_supplimentory_contribution, 
				SUM(mst.`NMC_DCPS_contribution`) AS NMC_DCPS_contribution, 
				SUM(mst.NMC_supplimentory_DCPS_contribution) AS NMC_supplimentory_DCPS_contribution,
				(
				SUM(mst.`emp_DCPS_contribution`) + 
				SUM(mst.emp_DCPS_supplimentory_contribution) + 
				SUM(mst.`NMC_DCPS_contribution`) + 
				SUM(mst.NMC_supplimentory_DCPS_contribution) + 
				SUM(mst.loan_installment_paid_through_salary)
				) AS total_contribution, 
				SUM(mst.`loan_installment_paid_through_salary`) AS loan_installment_paid_through_salary, 
				SUM(mst.`DCPS_loan_taken_by_an_employee`) AS DCPS_loan_taken_by_an_employee, 
				mst.`for_month`, 
				mst.`for_year` 
				FROM 
				`dpt_master_dcps` AS mst 
				LEFT JOIN 
				dpt_emp_master AS em 
				ON 
				em.emp_id = mst.emp_td 
				LEFT JOIN 
				dpt_designation AS dd 
				ON 
				dd.id = mst.designation_id 	
				WHERE 
				mst.is_deleted = 0 and mst.emp_td > 0 ";

			// Add conditions dynamically based on input
			if (isset($data['emp_id']) && $data['emp_id'] != "") {
				$sql .= " AND mst.`emp_td` = " . (int) $data['emp_id'];
			}

			if (isset($data['voucher_date']) && $data['voucher_date'] != "") {
				$sql .= " AND mst.`recovered_DCPS_with_voucher_date` = " . $this->db->escape($data['voucher_date']);
			}

			if (isset($data['voucher_no']) && $data['voucher_no'] != "") {
				$sql .= " AND mst.`recovered_DCPS_with_voucher_no` = " . $this->db->escape($data['voucher_no']);
			}

			if (isset($data['first_year']) && $data['first_year'] != "" && isset($data['second_year']) && $data['second_year'] != "") {
				$sql .= " AND (
                    (mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = " . (int) $data['first_year'] . ") 
                    OR 
                    (mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = " . (int) $data['second_year'] . ")
					)";
			} elseif (isset($data['first_year']) && $data['first_year'] != "") {
				$sql .= " AND mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = " . (int) $data['first_year'];
			} elseif (isset($data['second_year']) && $data['second_year'] != "") {
				$sql .= " AND mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = " . (int) $data['second_year'];
			}

			// Additional hardcoded filter
			//$sql .= " AND mst.emp_td = 8967 and for_month=6 and for_year=2008";

			// Group by condition
			if (isset($data['emp_id']) && $data['emp_id'] != "") {
				$sql .= " GROUP BY mst.for_month, mst.emp_td, mst.for_year";
			} else {
				$sql .= " GROUP BY mst.emp_td, mst.for_month, mst.for_year";
			}

			// **Order By condition added here**
			$sql .= " ORDER BY mst.pay_center ASC, mst.emp_td ASC";

			// Execute the query
			$query = $this->db->query($sql);

			if ($query) {
				return $query->result_array();
			}
			return 0;
		}
		return 0;
	}

	public function getdcpsDetailsNewFinalLedger($data)
	{
		if (!empty($data)) {
			$sql = "SELECT 
				mst.`emp_td`, 
				dd.designation_name, 
				em.emp_name, 
				mst.salary_type,
				em.joining_date, 
				mst.pay_center, 
				SUM(mst.`Ideal_contribution_of_employee_for_DCPS`) AS ideal_contribution, 
				SUM(mst.`emp_DCPS_contribution`) AS emp_DCPS_contribution, 
				SUM(mst.emp_DCPS_supplimentory_contribution) AS emp_DCPS_supplimentory_contribution, 
				SUM(mst.`NMC_DCPS_contribution`) AS NMC_DCPS_contribution, 
				SUM(mst.NMC_supplimentory_DCPS_contribution) AS NMC_supplimentory_DCPS_contribution,
				(
				SUM(mst.`emp_DCPS_contribution`) + 
				SUM(mst.emp_DCPS_supplimentory_contribution) + 
				SUM(mst.`NMC_DCPS_contribution`) + 
				SUM(mst.NMC_supplimentory_DCPS_contribution) + 
				SUM(mst.loan_installment_paid_through_salary)
				) AS total_contribution, 
				SUM(mst.`loan_installment_paid_through_salary`) AS loan_installment_paid_through_salary, 
				SUM(mst.`DCPS_loan_taken_by_an_employee`) AS DCPS_loan_taken_by_an_employee, 
				mst.`for_month`, 
				mst.`for_year` 
				FROM 
				`dpt_master_dcps` AS mst 
				LEFT JOIN 
				dpt_emp_master AS em 
				ON 
				em.emp_id = mst.emp_td 
				LEFT JOIN 
				dpt_designation AS dd 
				ON 
				dd.id = mst.designation_id 	
				WHERE 
				mst.is_deleted = 0 and mst.emp_td > 0 ";

			if (isset($data['emp_id']) && $data['emp_id'] != "") {
				$sql .= " AND mst.`emp_td` = " . (int) $data['emp_id'];
			}

			if (isset($data['voucher_date']) && $data['voucher_date'] != "") {
				$sql .= " AND mst.`recovered_DCPS_with_voucher_date` = " . $this->db->escape($data['voucher_date']);
			}

			if (isset($data['voucher_no']) && $data['voucher_no'] != "") {
				$sql .= " AND mst.`recovered_DCPS_with_voucher_no` = " . $this->db->escape($data['voucher_no']);
			}

			$fyStart = 0;
			$fyEnd = 0;
			if (isset($data['first_year']) && $data['first_year'] != "" && isset($data['second_year']) && $data['second_year'] != "") {
				$fyStart = (int) $data['first_year'];
				$fyEnd = (int) $data['second_year'];
			} elseif (isset($data['first_year']) && $data['first_year'] != "") {
				$fyStart = (int) $data['first_year'];
				$fyEnd = $fyStart + 1;
			} elseif (isset($data['second_year']) && $data['second_year'] != "") {
				$fyEnd = (int) $data['second_year'];
				$fyStart = $fyEnd - 1;
			}

			if ($fyStart > 0 && $fyEnd > 0) {
				$startDate = sprintf('%04d-04-01', $fyStart);
				$endDate   = sprintf('%04d-03-31', $fyEnd);
				$sql .= " AND (
					(
						mst.`recovered_DCPS_with_voucher_date` IS NOT NULL 
						AND mst.`recovered_DCPS_with_voucher_date` != '' 
						AND COALESCE(
							STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%d-%m-%Y'),
							STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%Y-%m-%d'),
							STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%d/%m/%Y')
						) >= '{$startDate}' 
						AND COALESCE(
							STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%d-%m-%Y'),
							STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%Y-%m-%d'),
							STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%d/%m/%Y')
						) <= '{$endDate}'
					)
					OR
					(
						(mst.`recovered_DCPS_with_voucher_date` IS NULL OR mst.`recovered_DCPS_with_voucher_date` = '')
						AND (
							(mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = {$fyStart})
							OR
							(mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = {$fyEnd})
						)
					)
				) ";
			}

			if (isset($data['emp_id']) && $data['emp_id'] != "") {
				$sql .= " GROUP BY mst.for_month, mst.emp_td, mst.for_year";
			} else {
				$sql .= " GROUP BY mst.emp_td, mst.for_month, mst.for_year";
			}

			$sql .= " ORDER BY mst.pay_center ASC, mst.emp_td ASC";

			$query = $this->db->query($sql);

			if ($query) {
				return $query->result_array();
			}
			return 0;
		}
		return 0;
	}


	public function getdcpsAllDetails($data)
	{
		$sql = "SELECT 
			mst.*, 
			dd.designation_name, 
			em.emp_name, 
			em.joining_date, 
			em.fixed_pay
			FROM 
			`dpt_master_dcps_new_19012025` AS mst 
			LEFT JOIN 
			dpt_emp_master AS em 
			ON 
			em.emp_id = mst.emp_td 
			LEFT JOIN 
			dpt_designation AS dd 
			ON 
			dd.id = mst.designation_id 	
			WHERE 
			mst.is_deleted = 0 and mst.emp_td > 0 ";

		// Add conditions dynamically based on input
		if (isset($data['emp_id']) && $data['emp_id'] != "") {
			$sql .= " AND mst.`emp_td` = " . (int) $data['emp_id'];
		}

		$fyStart = 0;
		$fyEnd = 0;
		if (isset($data['first_year']) && $data['first_year'] != "" && isset($data['second_year']) && $data['second_year'] != "") {
			$fyStart = (int) $data['first_year'];
			$fyEnd = (int) $data['second_year'];
		} elseif (isset($data['first_year']) && $data['first_year'] != "") {
			$fyStart = (int) $data['first_year'];
			$fyEnd = $fyStart + 1;
		} elseif (isset($data['second_year']) && $data['second_year'] != "") {
			$fyEnd = (int) $data['second_year'];
			$fyStart = $fyEnd - 1;
		}

		if ($fyStart > 0 && $fyEnd > 0) {
			$startDate = sprintf('%04d-04-01', $fyStart);
			$endDate   = sprintf('%04d-03-31', $fyEnd);
			$sql .= " AND (
				(
					mst.`recovered_DCPS_with_voucher_date` IS NOT NULL 
					AND mst.`recovered_DCPS_with_voucher_date` != '' 
					AND COALESCE(
						STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%d-%m-%Y'),
						STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%Y-%m-%d'),
						STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%d/%m/%Y')
					) >= '{$startDate}' 
					AND COALESCE(
						STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%d-%m-%Y'),
						STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%Y-%m-%d'),
						STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%d/%m/%Y')
					) <= '{$endDate}'
				)
				OR
				(
					(mst.`recovered_DCPS_with_voucher_date` IS NULL OR mst.`recovered_DCPS_with_voucher_date` = '')
					AND (
						(mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = {$fyStart})
						OR
						(mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = {$fyEnd})
					)
				)
			) ";
		}

		// Additional hardcoded filter
		//$sql .= " AND mst.emp_td = 8967 and for_month=6 and for_year=2008";

		// Group by condition
		if (isset($data['emp_id']) && $data['emp_id'] != "") {
			$sql .= " GROUP BY mst.for_month, mst.emp_td, mst.for_year";
		} else {
			$sql .= " GROUP BY mst.emp_td, mst.for_month, mst.for_year";
		}

		// **Order By condition added here**
		$sql .= " ORDER BY mst.pay_center ASC, mst.emp_td ASC";

		// Execute the query
		$query = $this->db->query($sql);

		// Debugging (optional, remove for production)
		//echo "<br/>" . $sql;   exit;

		// Return results
		if ($query) {
			return $query->result_array();
		}
		return 0;
	}


	public function getdcpsAllDetailsForDeduction($data)
	{
		//echo "<pre>"; print_r($data); exit;
		if (!empty($data)) {
			$sql = "SELECT 
				mst.*, 
				dd.designation_name, 
				em.emp_name, 
				em.joining_date
				FROM 
				`dpt_master_dcps` AS mst 
				LEFT JOIN 
				dpt_emp_master AS em 
				ON 
				em.emp_id = mst.emp_td 
				LEFT JOIN 
				dpt_designation AS dd 
				ON 
				dd.id = mst.designation_id 	
				WHERE 
				mst.is_deleted in (0, 3) and mst.emp_td > 0 ";

			// Add conditions dynamically based on input
			if (isset($data['pay_center']) && $data['pay_center'] != "") {
				$sql .= " AND mst.`pay_center` = " . $data['pay_center'];
			}

			if (isset($data['emp_id']) && $data['emp_id'] != "") {
				$sql .= " AND mst.`emp_td` = " . (int) $data['emp_id'];
			}

			if (isset($data['voucher_date']) && $data['voucher_date'] != "") {
				$sql .= " AND mst.`recovered_DCPS_with_voucher_date` = " . $this->db->escape($data['voucher_date']);
			}

			if (isset($data['voucher_no']) && $data['voucher_no'] != "") {
				$sql .= " AND mst.`recovered_DCPS_with_voucher_no` = " . $this->db->escape($data['voucher_no']);
			}


			if (isset($data['from_month']) && $data['from_month'] != "" && isset($data['to_month']) && $data['to_month'] != "") {
				$sql .= " AND mst.`for_month` >= " . (int) $data['from_month'];
				$sql .= " AND mst.`for_month` <= " . (int) $data['to_month'];
			} else {
				if (isset($data['from_month']) && $data['from_month'] != "") {
					$sql .= " AND mst.`for_month` = " . (int) $data['from_month'];
				} elseif (isset($data['to_month']) && $data['to_month'] != "") {
					$sql .= " AND mst.`for_month` = " . (int) $data['to_month'];
				}
			}

			if (isset($data['first_year']) && $data['first_year'] != "" && isset($data['second_year']) && $data['second_year'] != "") {
				$sql .= " AND (
                    (mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = " . (int) $data['first_year'] . ") 
                    OR 
                    (mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = " . (int) $data['second_year'] . ")
					)";
			} elseif (isset($data['first_year']) && $data['first_year'] != "") {
				$sql .= " AND mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = " . (int) $data['first_year'];
			} elseif (isset($data['second_year']) && $data['second_year'] != "") {
				$sql .= " AND mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = " . (int) $data['second_year'];
			}

			// Additional hardcoded filter
			//$sql .= " AND mst.emp_td = 8967 and for_month=6 and for_year=2008";

			// Group by condition
			/*if (isset($data['emp_id']) && $data['emp_id'] != "") {
				$sql .= " GROUP BY mst.for_month, mst.emp_td, mst.for_year";
				} else {
				$sql .= " GROUP BY mst.emp_td, mst.for_month, mst.for_year";
			}*/

			// **Order By condition added here**
			$sql .= " ORDER BY mst.pay_center ASC, CAST(mst.emp_td AS UNSIGNED) ASC";

			// Execute the query
			$query = $this->db->query($sql);

			// Debugging (optional, remove for production)
			//echo "<br/>" . $sql;   exit;

			// Return results
			if ($query) {
				return $query->result_array();
			}
		}
		return 0;
	}


	public function getdcpsAllDetailsForLedger($data)
	{
		//echo "<pre>"; print_r($data); exit;
		if (!empty($data)) {
			$sql = "SELECT 
				mst.*, 
				dd.designation_name, 
				em.emp_name, 
				em.joining_date
				FROM 
				`dpt_master_dcps` AS mst 
				LEFT JOIN 
				dpt_emp_master AS em 
				ON 
				em.emp_id = mst.emp_td 
				LEFT JOIN 
				dpt_designation AS dd 
				ON 
				dd.id = mst.designation_id 	
				WHERE 
				mst.is_deleted in (0) and mst.emp_td > 0 ";

			// Add conditions dynamically based on input
			if (isset($data['pay_center']) && $data['pay_center'] != "") {
				$sql .= " AND mst.`pay_center` = " . $data['pay_center'];
			}

			if (isset($data['emp_id']) && $data['emp_id'] != "") {
				$sql .= " AND mst.`emp_td` = " . (int) $data['emp_id'];
			}

			if (isset($data['voucher_date']) && $data['voucher_date'] != "") {
				$sql .= " AND mst.`recovered_DCPS_with_voucher_date` = " . $this->db->escape($data['voucher_date']);
			}

			if (isset($data['voucher_no']) && $data['voucher_no'] != "") {
				$sql .= " AND mst.`recovered_DCPS_with_voucher_no` = " . $this->db->escape($data['voucher_no']);
			}


			if (isset($data['from_month']) && $data['from_month'] != "" && isset($data['to_month']) && $data['to_month'] != "") {
				$sql .= " AND mst.`for_month` >= " . (int) $data['from_month'];
				$sql .= " AND mst.`for_month` <= " . (int) $data['to_month'];
			} else {
				if (isset($data['from_month']) && $data['from_month'] != "") {
					$sql .= " AND mst.`for_month` = " . (int) $data['from_month'];
				} elseif (isset($data['to_month']) && $data['to_month'] != "") {
					$sql .= " AND mst.`for_month` = " . (int) $data['to_month'];
				}
			}

			if (isset($data['first_year']) && $data['first_year'] != "" && isset($data['second_year']) && $data['second_year'] != "") {
				$sql .= " AND (
                    (mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = " . (int) $data['first_year'] . ") 
                    OR 
                    (mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = " . (int) $data['second_year'] . ")
					)";
			} elseif (isset($data['first_year']) && $data['first_year'] != "") {
				$sql .= " AND mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = " . (int) $data['first_year'];
			} elseif (isset($data['second_year']) && $data['second_year'] != "") {
				$sql .= " AND mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = " . (int) $data['second_year'];
			}

			// Additional hardcoded filter
			//$sql .= " AND mst.emp_td = 8967 and for_month=6 and for_year=2008";

			// Group by condition
			/*if (isset($data['emp_id']) && $data['emp_id'] != "") {
				$sql .= " GROUP BY mst.for_month, mst.emp_td, mst.for_year";
				} else {
				$sql .= " GROUP BY mst.emp_td, mst.for_month, mst.for_year";
			}*/

			// **Order By condition added here**
			// Case 2: year + from_month + to_month -> sort by voucher date (descending), then voucher no and file no ascending
			if (isset($data['first_year']) && $data['first_year'] != "" && isset($data['from_month']) && $data['from_month'] != "" && isset($data['to_month']) && $data['to_month'] != "") {
				$sql .= " ORDER BY mst.recovered_DCPS_with_voucher_date DESC, mst.recovered_DCPS_with_voucher_no ASC, mst.file_no ASC";
			}
			// Case 1: only year selected (financial year) -> sort employees by joining month in financial-year order (April->March) then joining date, then pay center, then emp_td
			elseif ((isset($data['first_year']) && $data['first_year'] != "" && (!isset($data['from_month']) || $data['from_month'] == "") && (!isset($data['to_month']) || $data['to_month'] == "")) || (isset($data['second_year']) && $data['second_year'] != "" && (!isset($data['from_month']) || $data['from_month'] == "") && (!isset($data['to_month']) || $data['to_month'] == ""))) {
				$sql .= " ORDER BY (CASE WHEN MONTH(em.joining_date) >= 4 THEN MONTH(em.joining_date) - 3 ELSE MONTH(em.joining_date) + 9 END) ASC, em.joining_date ASC, mst.pay_center ASC, CAST(mst.emp_td AS UNSIGNED) ASC";
			} else {
				$sql .= " ORDER BY mst.pay_center ASC, CAST(mst.emp_td AS UNSIGNED) ASC";
			}

			// Execute the query
			$query = $this->db->query($sql);

			if ($query) {
				return $query->result_array();
			}
		}
		return 0;
	}

	public function getdcpsAllDetailsForFinalLedger($data)
	{
		if (!empty($data)) {
			$sql = "SELECT 
				mst.*, 
				dd.designation_name, 
				em.emp_name, 
				em.joining_date
				FROM 
				`dpt_master_dcps` AS mst 
				LEFT JOIN 
				dpt_emp_master AS em 
				ON 
				em.emp_id = mst.emp_td 
				LEFT JOIN 
				dpt_designation AS dd 
				ON 
				dd.id = mst.designation_id 	
				WHERE 
				mst.is_deleted in (0) and mst.emp_td > 0 ";

			if (isset($data['pay_center']) && $data['pay_center'] != "") {
				$sql .= " AND mst.`pay_center` = " . $data['pay_center'];
			}

			if (isset($data['emp_id']) && $data['emp_id'] != "") {
				$sql .= " AND mst.`emp_td` = " . (int) $data['emp_id'];
			}

			if (isset($data['voucher_date']) && $data['voucher_date'] != "") {
				$sql .= " AND mst.`recovered_DCPS_with_voucher_date` = " . $this->db->escape($data['voucher_date']);
			}

			if (isset($data['voucher_no']) && $data['voucher_no'] != "") {
				$sql .= " AND mst.`recovered_DCPS_with_voucher_no` = " . $this->db->escape($data['voucher_no']);
			}

			if (isset($data['from_month']) && $data['from_month'] != "" && isset($data['to_month']) && $data['to_month'] != "") {
				$sql .= " AND mst.`for_month` >= " . (int) $data['from_month'];
				$sql .= " AND mst.`for_month` <= " . (int) $data['to_month'];
			} else {
				if (isset($data['from_month']) && $data['from_month'] != "") {
					$sql .= " AND mst.`for_month` = " . (int) $data['from_month'];
				} elseif (isset($data['to_month']) && $data['to_month'] != "") {
					$sql .= " AND mst.`for_month` = " . (int) $data['to_month'];
				}
			}

			$fyStart = 0;
			$fyEnd = 0;
			if (isset($data['first_year']) && $data['first_year'] != "" && isset($data['second_year']) && $data['second_year'] != "") {
				$fyStart = (int) $data['first_year'];
				$fyEnd = (int) $data['second_year'];
			} elseif (isset($data['first_year']) && $data['first_year'] != "") {
				$fyStart = (int) $data['first_year'];
				$fyEnd = $fyStart + 1;
			} elseif (isset($data['second_year']) && $data['second_year'] != "") {
				$fyEnd = (int) $data['second_year'];
				$fyStart = $fyEnd - 1;
			}

			if ($fyStart > 0 && $fyEnd > 0) {
				$startDate = sprintf('%04d-04-01', $fyStart);
				$endDate   = sprintf('%04d-03-31', $fyEnd);
				$sql .= " AND (
					(
						mst.`recovered_DCPS_with_voucher_date` IS NOT NULL 
						AND mst.`recovered_DCPS_with_voucher_date` != '' 
						AND COALESCE(
							STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%d-%m-%Y'),
							STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%Y-%m-%d'),
							STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%d/%m/%Y')
						) >= '{$startDate}' 
						AND COALESCE(
							STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%d-%m-%Y'),
							STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%Y-%m-%d'),
							STR_TO_DATE(mst.`recovered_DCPS_with_voucher_date`, '%d/%m/%Y')
						) <= '{$endDate}'
					)
					OR
					(
						(mst.`recovered_DCPS_with_voucher_date` IS NULL OR mst.`recovered_DCPS_with_voucher_date` = '')
						AND (
							(mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = {$fyStart})
							OR
							(mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = {$fyEnd})
						)
					)
				) ";
			}

			if (isset($data['first_year']) && $data['first_year'] != "" && isset($data['from_month']) && $data['from_month'] != "" && isset($data['to_month']) && $data['to_month'] != "") {
				$sql .= " ORDER BY mst.recovered_DCPS_with_voucher_date DESC, mst.recovered_DCPS_with_voucher_no ASC, mst.file_no ASC";
			} elseif ((isset($data['first_year']) && $data['first_year'] != "" && (!isset($data['from_month']) || $data['from_month'] == "") && (!isset($data['to_month']) || $data['to_month'] == "")) || (isset($data['second_year']) && $data['second_year'] != "" && (!isset($data['from_month']) || $data['from_month'] == "") && (!isset($data['to_month']) || $data['to_month'] == ""))) {
				$sql .= " ORDER BY (CASE WHEN MONTH(em.joining_date) >= 4 THEN MONTH(em.joining_date) - 3 ELSE MONTH(em.joining_date) + 9 END) ASC, em.joining_date ASC, mst.pay_center ASC, CAST(mst.emp_td AS UNSIGNED) ASC";
			} else {
				$sql .= " ORDER BY mst.pay_center ASC, CAST(mst.emp_td AS UNSIGNED) ASC";
			}

			$query = $this->db->query($sql);

			if ($query) {
				return $query->result_array();
			}
			return 0;
		}
		return 0;
	}

	public function getYearlyInterestNew($data = array())
	{
		if ($data['emp_id'] || $data['f_year']) {
			$this->db->select('*');
			$this->db->from('yearly_interest');
			if (isset($data['emp_id']) && $data['emp_id'] != "") {
				$this->db->where("employee_id", $data['emp_id']);
			}
			if (isset($data['f_year']) && $data['f_year'] != "") {
				$this->db->where("f_year", $data['f_year']);
			}
			$query = $this->db->get();
			//echo $this->db->last_query(); exit;
			if ($query) {
				return $query->result_array();
			}
			return false;
		}
		return 0;
	}

	public function getYearlyInterest($data = array())
	{
		if ($data['emp_id'] && $data['f_year']) {
			$this->db->select('*');
			$this->db->from('yearly_interest');
			if (isset($data['emp_id']) && $data['emp_id'] != "") {
				$this->db->where("employee_id", $data['emp_id']);
			}
			if (isset($data['f_year']) && $data['f_year'] != "") {
				$this->db->where("f_year", $data['f_year']);
			}
			$query = $this->db->get();
			if ($query) {
				return $query->row_array();
			}
			return false;
		}
		return 0;
	}

	public function getInterestRates($firstYear = "", $secondYear = "")
	{
		$interestRateByMonths = array();
		$monthSql = "SELECT gr_month, gr_percentage FROM `dpt_gr_management` where  ((gr_month >= 4 && gr_month <= 12 and gr_year =" . $firstYear . ") or (gr_month >= 1 && gr_month <= 3 and gr_year =" . $secondYear . "))";
		//$monthSql = "SELECT gr_month, gr_percentage FROM `dpt_gr_management`";
		//echo $monthSql; exit;
		$query = $this->db->query($monthSql);
		//echo $this->db->last_query(); exit;
		if ($query) {
			//echo "<pre>"; print_r($query->result()); exit;
			foreach ($query->result() as $mresult) {
				$interestRateByMonths[$mresult->gr_month] = $mresult->gr_percentage;
			}
			return $interestRateByMonths;
		}

	}


	/**
	 * Final Ledger (Excel-style) month-wise cumulative interest calculation.
	 *
	 * Key points (matches provided Excel):
	 * - Maintain running bases (Employee / NMC / Total) month-wise.
	 * - Opening balance is added only once at FY start and is part of Employee + Total bases.
	 * - Monthly interest is calculated on the running bases:
	 *   interest = ROUND((base * rate%) / 12, 0)
	 * - Interest is NOT added back into the base for subsequent months (no compounding).
	 */

	public function getFinalLedgerCumulativeRows($data = array())
	{
		if (empty($data)) {
			return array();
		}

		$firstYear = isset($data['first_year']) ? (int) $data['first_year'] : (isset($data['year']) ? (int) $data['year'] : 0);
		if (!$firstYear) {
			return array();
		}
		$secondYear = isset($data['second_year']) ? (int) $data['second_year'] : ($firstYear + 1);
		$fYear = $firstYear . "-" . $secondYear;

		$monthsOrder = array(4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3);

		$rates = $this->getInterestRates($firstYear, $secondYear);
		
		if (!is_array($rates)) {
			$rates = array();
		}

		$dcpsRows = $this->getdcpsAllDetailsForFinalLedger($data);

		$byEmpMonth = array();
		$empIds = array();
		if (is_array($dcpsRows)) {
			foreach ($dcpsRows as $r) {
				$empId = (int) $r['emp_td'];
				$m = (int) $r['for_month'];
				if ($m < 1 || $m > 12) {
					$dt = isset($r['recovered_DCPS_with_voucher_date']) ? (DateTime::createFromFormat('d-m-Y', $r['recovered_DCPS_with_voucher_date']) ?: DateTime::createFromFormat('Y-m-d', $r['recovered_DCPS_with_voucher_date'])) : null;
					$m = $dt ? (int) $dt->format('n') : 4;
				}
				if (!isset($byEmpMonth[$empId][$m])) {
					$byEmpMonth[$empId][$m] = array();
				}
				$byEmpMonth[$empId][$m][] = $r;
				$empIds[$empId] = true;
			}
		}
		$empIds = array_keys($empIds);

		$openingByEmp = array();
		$ecOpeningByEmp = array(); // NEW (additive): employee contribution opening
		foreach ($empIds as $empId) {
			//$openingByEmp[$empId] = (int) $this->getFinalLedgerOpeningBalanceRuntime($empId, $firstYear);
			list($opening, $ecOpening) = $this->getFinalLedgerEmployeeContributionOpeningBalanceRuntime($empId, $firstYear);

			$openingByEmp[$empId] = (int)$opening;
			$ecOpeningByEmp[$empId] = (int)$ecOpening;
			//$ecOpeningByEmp[$empId] = (int) $this->getFinalLedgerEmployeeContributionOpeningBalanceRuntime($empId, $firstYear);
		}

		$_dbg_model_log = APPPATH . 'logs/final_ledger_model_debug.txt';
		$_dbg_month_names = array(
			1 => 'January',
			2 => 'February',
			3 => 'March',
			4 => 'April',
			5 => 'May',
			6 => 'June',
			7 => 'July',
			8 => 'August',
			9 => 'September',
			10 => 'October',
			11 => 'November',
			12 => 'December'
		);

		$out = array();
		foreach ($empIds as $empId) {
			$opening = isset($ecOpeningByEmp[$empId]) ? (int) $ecOpeningByEmp[$empId] : 0;

			/*file_put_contents($_dbg_model_log,
			"\n" . str_repeat('*', 80) . "\n" .
			"[MODEL-CUMUL] getFinalLedgerCumulativeRows  FY: {$fYear}  EmpId: {$empId}" .
			"  Current Year Opening (from previous FY closing): {$opening}\n" .
			str_repeat('*', 80) . "\n",
			FILE_APPEND
			);*/

			$empBase = (int) $opening;
			$nmcBase = (int) $opening;
			$totalBase = (int) $opening;

			$totals = array(
				'emp_regular' => 0,
				'emp_supp' => 0,
				'nmc_regular' => 0,
				'nmc_supp' => 0,
				'loan_installment' => 0,
				'total_deposit' => 0,
				'loan_taken' => 0,
				'emp_interest' => 0,
				'nmc_interest' => 0,
				'total_interest' => 0,
			);

			$rows = array();

			foreach ($monthsOrder as $m) {
				$monthRecords = isset($byEmpMonth[$empId][$m]) ? $byEmpMonth[$empId][$m] : array();


				if (!empty($monthRecords) && is_array($monthRecords)) {
					usort($monthRecords, function ($a, $b) {
						$dateA = isset($a['recovered_DCPS_with_voucher_date']) ? $a['recovered_DCPS_with_voucher_date'] : '';
						$dateB = isset($b['recovered_DCPS_with_voucher_date']) ? $b['recovered_DCPS_with_voucher_date'] : '';
						$dtA = DateTime::createFromFormat('d-m-Y', $dateA) ?: null;
						$dtB = DateTime::createFromFormat('d-m-Y', $dateB) ?: null;
						$tsA = $dtA ? $dtA->getTimestamp() : 0;
						$tsB = $dtB ? $dtB->getTimestamp() : 0;
						if ($tsA !== $tsB) {
							return $tsA <=> $tsB;
						}
						$vnA = isset($a['recovered_DCPS_with_voucher_no']) ? (string) $a['recovered_DCPS_with_voucher_no'] : '';
						$vnB = isset($b['recovered_DCPS_with_voucher_no']) ? (string) $b['recovered_DCPS_with_voucher_no'] : '';
						if ($vnA !== $vnB) {
							return $vnA <=> $vnB;
						}
						$fnA = isset($a['file_no']) ? (string) $a['file_no'] : '';
						$fnB = isset($b['file_no']) ? (string) $b['file_no'] : '';
						return $fnA <=> $fnB;
					});
				}

				if (empty($monthRecords)) {
					$monthRecords = array(array());					
				}
				//echo "<pre>Line No. 715=>"; print_r($rates); exit;
				$rate = isset($rates[$m]) ?  $rates[$m] : 0;
				$yearForMonth = ($m >= 4 && $m <= 12) ? $firstYear : $secondYear;

				// ── Month-level interest accumulators ────────────────────────────
				$monthEmpInterest = 0;
				$monthNmcInterest = 0;

				
				//echo "<pre>Line No. 724=>"; print_r($monthRecords); exit;
				foreach ($monthRecords as $r) {		
					if($r['basic'] == 0 && $r['da'] == 0 && $r['grade_pay'] == 0) {
						$r = array(
							'salary_type' => '',
							'Ideal_contribution_of_employee_for_DCPS' => 0,
							'emp_DCPS_contribution' => 0,
							'emp_supplimentory_contribution' => 0,
							'NMC_DCPS_contribution' => 0,
							'NMC_supplimentory_DCPS_contribution' => 0,
							'loan_installment_paid_through_salary' => 0,
							'DCPS_loan_taken_by_an_employee' => 0,
							'bunch_no' => '',
						);
					}
					
					$salaryType = isset($r['salary_type']) ? (string) $r['salary_type'] : '';
					$ideal = isset($r['Ideal_contribution_of_employee_for_DCPS'])
						&& $r['Ideal_contribution_of_employee_for_DCPS'] !== ''
						? (int) $r['Ideal_contribution_of_employee_for_DCPS'] : 0;

					$empRegular = 0;
					$empSupp = 0;
					$nmcRegular = 0;
					$nmcSupp = 0;
					$loanInstallment = 0;
					$loanTaken = 0;

					if ($salaryType === 'Regular') {
						/*$empRegular = !empty($r['emp_DCPS_contribution'])
						? (int)$r['emp_DCPS_contribution'] : $ideal;
						$nmcRegular = !empty($r['NMC_DCPS_contribution'])
						? (int)$r['NMC_DCPS_contribution'] : $ideal;
						} elseif ($salaryType === 'Suplimentory') {
						$empSupp = !empty($r['emp_supplimentory_contribution'])
						? (int)$r['emp_supplimentory_contribution'] : $ideal;
						$nmcSupp = !empty($r['NMC_supplimentory_DCPS_contribution'])
						? (int)$r['NMC_supplimentory_DCPS_contribution'] : $ideal;*/


						$empRegular = $ideal;
						$nmcRegular = $ideal;
					} elseif ($salaryType === 'Suplimentory') {
						$empSupp = $ideal;
						$nmcSupp = $ideal;

					}

					$loanInstallment = !empty($r['loan_installment_paid_through_salary'])
						? (int) $r['loan_installment_paid_through_salary'] : 0;
					$loanTaken = !empty($r['DCPS_loan_taken_by_an_employee'])
						? (int) $r['DCPS_loan_taken_by_an_employee'] : 0;

					$totalDeposit = ($empRegular + $empSupp + $loanInstallment) + ($nmcRegular + $nmcSupp);

					// ── Update bases PER RECORD ──────────────────────────────────
					$empBase = $ideal > 0 ? ($empBase + $empRegular + $empSupp + $loanInstallment) - $loanTaken : 0;
					$nmcBase = $ideal > 0 ? ($nmcBase + $nmcRegular + $nmcSupp) : 0;
					$totalBase = $ideal > 0 ? ($totalBase + $totalDeposit) - $loanTaken : 0;

					// ── Interest calculated on updated base AFTER EACH RECORD ────
					$rowEmpInterest = round((($empBase * $rate) / 100 / 12), 0);
					$rowNmcInterest = round((($nmcBase * $rate) / 100 / 12), 0);

					// ── Accumulate into month totals ─────────────────────────────
					$monthEmpInterest += $rowEmpInterest;
					$monthNmcInterest += $rowNmcInterest;

					// ── Per-record debug log ─────────────────────────────────────
					$_dbg_month_label = isset($_dbg_month_names[$m]) ? $_dbg_month_names[$m] : $m;
					/*file_put_contents($_dbg_model_log,
					"[MODEL-CUMUL-ROW] FY: {$fYear}  EmpId: {$empId}  Month: {$_dbg_month_label} ({$m})" .
					"  SalaryType: {$salaryType}" .
					"  Emp Regular: {$empRegular}  Emp Supp: {$empSupp}" .
					"  NMC Regular: {$nmcRegular}  NMC Supp: {$nmcSupp}" .
					"  LoanInst: {$loanInstallment}  LoanTaken: {$loanTaken}" .
					"  Rate: {$rate}" .
					"  EmpBase After Row: {$empBase}  NMCBase After Row: {$nmcBase}" .
					"  Row EmpInterest: {$rowEmpInterest}  Row NMCInterest: {$rowNmcInterest}\n",
					FILE_APPEND
					);*/
					$rows[] = array(
						'month' => $m,
						'year' => $yearForMonth,
						'emp_regular' => $empRegular,
						'emp_supp' => $empSupp,
						'nmc_regular' => $nmcRegular,
						'nmc_supp' => $nmcSupp,
						'loan_installment' => $loanInstallment,
						'total_deposit' => $totalDeposit,
						'loan_taken' => $loanTaken,
						'emp_base' => $empBase,
						'nmc_base' => $nmcBase,
						'total_base' => $totalBase,
						'emp_interest' => $rowEmpInterest,
						'nmc_interest' => $rowNmcInterest,
						'total_interest' => ($rowEmpInterest + $rowNmcInterest),
						'rate' => $rate,
						'bunch_no' => isset($r['bunch_no']) ? $r['bunch_no'] : 0,
						'file_no' => isset($r['file_no']) ? $r['file_no'] : 0,
						'recovered_DCPS_with_voucher_no' => isset($r['recovered_DCPS_with_voucher_no']) ? $r['recovered_DCPS_with_voucher_no'] : '',
						'recovered_DCPS_with_voucher_date' => isset($r['recovered_DCPS_with_voucher_date']) ? $r['recovered_DCPS_with_voucher_date'] : '',
					);

					$totals['emp_regular'] += $empRegular;
					$totals['emp_supp'] += $empSupp;
					$totals['nmc_regular'] += $nmcRegular;
					$totals['nmc_supp'] += $nmcSupp;
					$totals['loan_installment'] += $loanInstallment;
					$totals['total_deposit'] += $totalDeposit;
					$totals['loan_taken'] += $loanTaken;
					$totals['emp_interest'] += $rowEmpInterest;
					$totals['nmc_interest'] += $rowNmcInterest;
					$totals['total_interest'] += ($rowEmpInterest + $rowNmcInterest);
				}

				// ── Month-level debug log ────────────────────────────────────────
				$_dbg_month_label = isset($_dbg_month_names[$m]) ? $_dbg_month_names[$m] : $m;
				$_dbg_monthly_closing = $empBase + $nmcBase;
				/*file_put_contents($_dbg_model_log,
				"[MODEL-CUMUL] FY: {$fYear}  EmpId: {$empId}  Month: {$_dbg_month_label} ({$m})" .
				"  Opening(FY): {$opening}" .
				"  Rate: {$rate}" .
				"  Emp Base (month-end): {$empBase}" .
				"  NMC Base (month-end): {$nmcBase}" .
				"  Month Emp Interest (sum of rows): {$monthEmpInterest}" .
				"  Month NMC Interest (sum of rows): {$monthNmcInterest}" .
				"  Monthly Closing (EmpBase+NmcBase): {$_dbg_monthly_closing}\n",
				FILE_APPEND
				);*/
			}

			$out[$empId] = array(
				'f_year' => $fYear,
				'opening_balance' => isset($openingByEmp[$empId]) ? (int) $openingByEmp[$empId] : 0,
				'ec_opening_balance' => isset($ecOpeningByEmp[$empId]) ? (int) $ecOpeningByEmp[$empId] : 0, // NEW (additive)
				'rows' => $rows,
				'totals' => $totals,
			);

			// ── Final closing debug log ──────────────────────────────────────────
			$_dbg_closing_cr = ($opening
				+ ($totals['emp_regular'] + $totals['emp_supp'] + $totals['loan_installment'])
				+ ($totals['nmc_regular'] + $totals['nmc_supp']))
				- $totals['loan_taken']
				+ $totals['total_interest'];

			/*file_put_contents($_dbg_model_log,
			"[MODEL-CUMUL] FY: {$fYear}  EmpId: {$empId}" .
			"  Opening: {$opening}" .
			"  Total Emp Regular: {$totals['emp_regular']}  Total Emp Supp: {$totals['emp_supp']}" .
			"  Total NMC Regular: {$totals['nmc_regular']}  Total NMC Supp: {$totals['nmc_supp']}" .
			"  Total Loan Inst: {$totals['loan_installment']}  Total Loan Taken: {$totals['loan_taken']}" .
			"  Total Emp Interest: {$totals['emp_interest']}  Total NMC Interest: {$totals['nmc_interest']}" .
			"  Total Interest: {$totals['total_interest']}" .
			"  >>> FINAL CLOSING (view formula): {$_dbg_closing_cr}\n" .
			str_repeat('*', 80) . "\n",
			FILE_APPEND
			);*/
		}
		//echo "<pre>Line No. 1015=>"; print_r($out); exit;
		return $out;
	}

	public function getProvisionalLedgerCumulativeRows($data = array())
	{
		if (empty($data)) {
			return array();
		}

		$firstYear = isset($data['first_year']) ? (int) $data['first_year'] : (isset($data['year']) ? (int) $data['year'] : 0);
		if (!$firstYear) {
			return array();
		}
		$secondYear = isset($data['second_year']) ? (int) $data['second_year'] : ($firstYear + 1);
		$fYear = $firstYear . "-" . $secondYear;

		$monthsOrder = array(4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3);

		$rates = $this->getInterestRates($firstYear, $secondYear);
		if (!is_array($rates)) {
			$rates = array();
		}

		$dcpsRows = $this->getdcpsAllDetailsForLedger($data);

		$byEmpMonth = array();
		$empIds = array();
		if (is_array($dcpsRows)) {
			foreach ($dcpsRows as $r) {
				$empId = (int) $r['emp_td'];
				$m = (int) $r['for_month'];
				if ($m < 1 || $m > 12) {
					$dt = isset($r['recovered_DCPS_with_voucher_date']) ? (DateTime::createFromFormat('d-m-Y', $r['recovered_DCPS_with_voucher_date']) ?: DateTime::createFromFormat('Y-m-d', $r['recovered_DCPS_with_voucher_date'])) : null;
					$m = $dt ? (int) $dt->format('n') : 4;
				}
				if (!isset($byEmpMonth[$empId][$m])) {
					$byEmpMonth[$empId][$m] = array();
				}
				$byEmpMonth[$empId][$m][] = $r;
				$empIds[$empId] = true;
			}
		}
		$empIds = array_keys($empIds);

		$openingByEmp = array();
		$ecOpeningByEmp = array(); // employee contribution opening (excludes NMC portion)
		foreach ($empIds as $empId) {
			$openingByEmp[$empId]   = (int) $this->getProvisionalLedgerOpeningBalanceRuntime($empId, $firstYear);
			$ecOpeningByEmp[$empId] = (int) $this->getFinalLedgerEmployeeContributionOpeningBalanceRuntime($empId, $firstYear);
		}

		$_dbg_model_log = APPPATH . 'logs/final_ledger_model_debug.txt';
		$_dbg_month_names = array(
			1 => 'January',
			2 => 'February',
			3 => 'March',
			4 => 'April',
			5 => 'May',
			6 => 'June',
			7 => 'July',
			8 => 'August',
			9 => 'September',
			10 => 'October',
			11 => 'November',
			12 => 'December'
		);

		$out = array();
		foreach ($empIds as $empId) {
			$opening   = isset($openingByEmp[$empId])   ? (int) $openingByEmp[$empId]   : 0;
			$ecOpening = isset($ecOpeningByEmp[$empId]) ? (int) $ecOpeningByEmp[$empId] : 0;

			/*file_put_contents($_dbg_model_log,
			"\n" . str_repeat('*', 80) . "\n" .
			"[MODEL-CUMUL] getProvisionalLedgerCumulativeRows  FY: {$fYear}  EmpId: {$empId}" .
			"  Current Year Opening (from previous FY closing): {$opening}\n" .
			str_repeat('*', 80) . "\n",
			FILE_APPEND
			);*/

			// empBase and nmcBase use the employee-contribution opening (previous FY's
			// new employee deposits + interest only), matching the Excel col I/J formula.
			$empBase   = (int) $ecOpening;
			$nmcBase   = (int) $ecOpening;
			$totalBase = (int) $opening;  // overall opening kept for total base display

			$totals = array(
				'emp_regular' => 0,
				'emp_supp' => 0,
				'nmc_regular' => 0,
				'nmc_supp' => 0,
				'loan_installment' => 0,
				'total_deposit' => 0,
				'loan_taken' => 0,
				'emp_interest' => 0,
				'nmc_interest' => 0,
				'total_interest' => 0,
				'emp_diff' => 0,
				'nmc_diff' => 0,
			);

			$rows = array();

			foreach ($monthsOrder as $m) {
				$monthRecords = isset($byEmpMonth[$empId][$m]) ? $byEmpMonth[$empId][$m] : array();

				if (!empty($monthRecords) && is_array($monthRecords)) {
					usort($monthRecords, function ($a, $b) {
						$dateA = isset($a['recovered_DCPS_with_voucher_date']) ? $a['recovered_DCPS_with_voucher_date'] : '';
						$dateB = isset($b['recovered_DCPS_with_voucher_date']) ? $b['recovered_DCPS_with_voucher_date'] : '';
						$dtA = DateTime::createFromFormat('d-m-Y', $dateA) ?: null;
						$dtB = DateTime::createFromFormat('d-m-Y', $dateB) ?: null;
						$tsA = $dtA ? $dtA->getTimestamp() : 0;
						$tsB = $dtB ? $dtB->getTimestamp() : 0;
						if ($tsA !== $tsB) {
							return $tsA <=> $tsB;
						}
						$vnA = isset($a['recovered_DCPS_with_voucher_no']) ? (string) $a['recovered_DCPS_with_voucher_no'] : '';
						$vnB = isset($b['recovered_DCPS_with_voucher_no']) ? (string) $b['recovered_DCPS_with_voucher_no'] : '';
						if ($vnA !== $vnB) {
							return $vnA <=> $vnB;
						}
						$fnA = isset($a['file_no']) ? (string) $a['file_no'] : '';
						$fnB = isset($b['file_no']) ? (string) $b['file_no'] : '';
						return $fnA <=> $fnB;
					});
				}

				if (empty($monthRecords)) {
					$monthRecords = array(array());
				}

				$rate = isset($rates[$m]) ? $rates[$m] : 0;
				$yearForMonth = ($m >= 4 && $m <= 12) ? $firstYear : $secondYear;

				// ── Month-level interest accumulators ────────────────────────────
				$monthEmpInterest = 0;
				$monthNmcInterest = 0;

				foreach ($monthRecords as $r) {
					$salaryType = isset($r['salary_type']) ? (string) $r['salary_type'] : '';
					$ideal = isset($r['Ideal_contribution_of_employee_for_DCPS'])
						&& $r['Ideal_contribution_of_employee_for_DCPS'] !== ''
						? (int) $r['Ideal_contribution_of_employee_for_DCPS'] : 0;

					$empRegular = 0;
					$empSupp = 0;
					$nmcRegular = 0;
					$nmcSupp = 0;
					$loanInstallment = 0;
					$loanTaken = 0;
					$empActual = 0;
					$nmcActual = 0;

					if ($salaryType === 'Regular') {
						$empRegular = !empty($r['emp_DCPS_contribution'])
							? (int) $r['emp_DCPS_contribution'] : 0;
						$nmcRegular = !empty($r['NMC_DCPS_contribution'])
							? (int) $r['NMC_DCPS_contribution'] : 0;
						$empActual = $empRegular;
						$nmcActual = $nmcRegular;
					} elseif ($salaryType === 'Suplimentory') {
						$empSupp = !empty($r['emp_supplimentory_contribution'])
							? (int) $r['emp_supplimentory_contribution'] : 0;
						$nmcSupp = !empty($r['NMC_supplimentory_DCPS_contribution'])
							? (int) $r['NMC_supplimentory_DCPS_contribution'] : 0;
						$empActual = $empSupp;
						$nmcActual = $nmcSupp;

					}

					// Difference: actual collected - ideal contribution
					$empDiff = $empActual - $ideal;
					$nmcDiff = $nmcActual - $ideal;

					$loanInstallment = !empty($r['loan_installment_paid_through_salary'])
						? (int) $r['loan_installment_paid_through_salary'] : 0;
					$loanTaken = !empty($r['DCPS_loan_taken_by_an_employee'])
						? (int) $r['DCPS_loan_taken_by_an_employee'] : 0;

					$totalDeposit = ($empRegular + $empSupp + $loanInstallment) + ($nmcRegular + $nmcSupp);

					// ── Update bases PER RECORD ──────────────────────────────────
					$empBase = ($empBase + $empRegular + $empSupp + $loanInstallment) - $loanTaken;
					$nmcBase = ($nmcBase + $nmcRegular + $nmcSupp);
					$totalBase = ($totalBase + $totalDeposit) - $loanTaken;

					// ── Interest calculated on updated base AFTER EACH RECORD ────
					$rowEmpInterest = round((($empBase * $rate) / 100 / 12), 0);
					$rowNmcInterest = round((($nmcBase * $rate) / 100 / 12), 0);

					// ── Accumulate into month totals ─────────────────────────────
					$monthEmpInterest += $rowEmpInterest;
					$monthNmcInterest += $rowNmcInterest;

					// ── Per-record debug log ─────────────────────────────────────
					$_dbg_month_label = isset($_dbg_month_names[$m]) ? $_dbg_month_names[$m] : $m;
					/*file_put_contents($_dbg_model_log,
					"[MODEL-CUMUL-ROW] FY: {$fYear}  EmpId: {$empId}  Month: {$_dbg_month_label} ({$m})" .
					"  SalaryType: {$salaryType}" .
					"  Emp Regular: {$empRegular}  Emp Supp: {$empSupp}" .
					"  NMC Regular: {$nmcRegular}  NMC Supp: {$nmcSupp}" .
					"  LoanInst: {$loanInstallment}  LoanTaken: {$loanTaken}" .
					"  Rate: {$rate}" .
					"  EmpBase After Row: {$empBase}  NMCBase After Row: {$nmcBase}" .
					"  Row EmpInterest: {$rowEmpInterest}  Row NMCInterest: {$rowNmcInterest}\n",
					FILE_APPEND
					);*/

					$rows[] = array(
						'month' => $m,
						'year' => $yearForMonth,
						'emp_regular' => $empRegular,
						'emp_supp' => $empSupp,
						'nmc_regular' => $nmcRegular,
						'nmc_supp' => $nmcSupp,
						'emp_diff' => $empDiff,
						'nmc_diff' => $nmcDiff,
						'loan_installment' => $loanInstallment,
						'total_deposit' => $totalDeposit,
						'loan_taken' => $loanTaken,
						'emp_base' => $empBase,
						'nmc_base' => $nmcBase,
						'total_base' => $totalBase,
						'emp_interest' => $rowEmpInterest,
						'nmc_interest' => $rowNmcInterest,
						'total_interest' => ($rowEmpInterest + $rowNmcInterest),
						'rate' => $rate,
						'bunch_no' => isset($r['bunch_no']) ? $r['bunch_no'] : 0,
						'file_no' => isset($r['file_no']) ? $r['file_no'] : 0,
						'recovered_DCPS_with_voucher_no' => isset($r['recovered_DCPS_with_voucher_no']) ? $r['recovered_DCPS_with_voucher_no'] : '',
						'recovered_DCPS_with_voucher_date' => isset($r['recovered_DCPS_with_voucher_date']) ? $r['recovered_DCPS_with_voucher_date'] : '',
					);

					$totals['emp_regular'] += $empRegular;
					$totals['emp_supp'] += $empSupp;
					$totals['nmc_regular'] += $nmcRegular;
					$totals['nmc_supp'] += $nmcSupp;
					$totals['emp_diff'] += $empDiff;
					$totals['nmc_diff'] += $nmcDiff;
					$totals['loan_installment'] += $loanInstallment;
					$totals['total_deposit'] += $totalDeposit;
					$totals['loan_taken'] += $loanTaken;
					$totals['emp_interest'] += $rowEmpInterest;
					$totals['nmc_interest'] += $rowNmcInterest;
					$totals['total_interest'] += ($rowEmpInterest + $rowNmcInterest);
				}

				// ── Month-level debug log ────────────────────────────────────────
				$_dbg_month_label = isset($_dbg_month_names[$m]) ? $_dbg_month_names[$m] : $m;
				$_dbg_monthly_closing = $empBase + $nmcBase;
				/*file_put_contents($_dbg_model_log,
				"[MODEL-CUMUL] FY: {$fYear}  EmpId: {$empId}  Month: {$_dbg_month_label} ({$m})" .
				"  Opening(FY): {$opening}" .
				"  Rate: {$rate}" .
				"  Emp Base (month-end): {$empBase}" .
				"  NMC Base (month-end): {$nmcBase}" .
				"  Month Emp Interest (sum of rows): {$monthEmpInterest}" .
				"  Month NMC Interest (sum of rows): {$monthNmcInterest}" .
				"  Monthly Closing (EmpBase+NmcBase): {$_dbg_monthly_closing}\n",
				FILE_APPEND
				);*/
			}

			$out[$empId] = array(
				'f_year' => $fYear,
				'opening_balance' => $opening,
				'ec_opening_balance' => $ecOpening,
				'rows' => $rows,
				'totals' => $totals,
			);

			// ── Final closing debug log ──────────────────────────────────────────
			$_dbg_closing_cr = ($opening
				+ ($totals['emp_regular'] + $totals['emp_supp'] + $totals['loan_installment'])
				+ ($totals['nmc_regular'] + $totals['nmc_supp']))
				- $totals['loan_taken']
				+ $totals['total_interest'];

			/*file_put_contents($_dbg_model_log,
			"[MODEL-CUMUL] FY: {$fYear}  EmpId: {$empId}" .
			"  Opening: {$opening}" .
			"  Total Emp Regular: {$totals['emp_regular']}  Total Emp Supp: {$totals['emp_supp']}" .
			"  Total NMC Regular: {$totals['nmc_regular']}  Total NMC Supp: {$totals['nmc_supp']}" .
			"  Total Loan Inst: {$totals['loan_installment']}  Total Loan Taken: {$totals['loan_taken']}" .
			"  Total Emp Interest: {$totals['emp_interest']}  Total NMC Interest: {$totals['nmc_interest']}" .
			"  Total Interest: {$totals['total_interest']}" .
			"  >>> FINAL CLOSING (view formula): {$_dbg_closing_cr}\n" .
			str_repeat('*', 80) . "\n",
			FILE_APPEND
			);*/
		}

		return $out;
	}

	/**
	 * Runtime opening balance = previous FY closing (March end).
	 *
	 * This computes FY-by-FY from 2005-06 up to (firstYear-1)-(firstYear),
	 * carrying forward the closing as next year's opening, matching the Excel pattern.
	 */
	public function getFinalLedgerOpeningBalanceRuntime($empId, $firstYear)
	{
		//echo "empId=>".$empId.", firstYear=>".$firstYear; exit;
		$empId = (int) $empId;
		$firstYear = (int) $firstYear;

		if ($empId <= 0 || $firstYear <= 2005) {
			return 0;
		}

		static $closingCache = array(); // [empId][fyStart] => closing

		$targetFYStart = $firstYear - 1;
		if (isset($closingCache[$empId][$targetFYStart])) {
			return (int) $closingCache[$empId][$targetFYStart];
		}

		$opening = 0;
		for ($fy = 2005; $fy <= $targetFYStart; $fy++) {
			if (isset($closingCache[$empId][$fy])) {
				$opening = (int) $closingCache[$empId][$fy];
				continue;
			}

			$closing = $this->_finalLedgerComputeClosingForFY($empId, $fy, $opening);

			//echo "<br/>empId=>".$empId.", firstYear=>".$fy.", Opening=>".$opening.", closing=>".$closing;

			$closingCache[$empId][$fy] = $closing;
			$opening = $closing;
		}

		return (int) $opening;
	}

	/**
	 * NEW (additive): Runtime Employee Contribution opening balance = previous FY
	 * Employee Contribution closing (March end).
	 *
	 * Mirrors getFinalLedgerOpeningBalanceRuntime() but tracks the independent
	 * Employee Contribution running balance (employee contribution + employee
	 * interest), carried forward FY-by-FY from 2005-06. Does NOT affect the
	 * existing opening/closing chain.
	 */
	public function getFinalLedgerEmployeeContributionOpeningBalanceRuntime($empId, $firstYear)
	{
		$empId = (int) $empId;
		$firstYear = (int) $firstYear;

		if ($empId <= 0 || $firstYear <= 2005) {
			return 0;
		}

		static $closingCache = array();   // [empId][fyStart] => main closing (carry forward only)
		static $ecClosingCache = array(); // [empId][fyStart] => employee contribution closing

		$targetFYStart = $firstYear - 1;
		if (isset($ecClosingCache[$empId][$targetFYStart])) {
			return (int) $ecClosingCache[$empId][$targetFYStart];
		}

		$opening = 0;
		$ecOpening = 0;
		for ($fy = 2005; $fy <= $targetFYStart; $fy++) {
			if (isset($closingCache[$empId][$fy]) && isset($ecClosingCache[$empId][$fy])) {
				$opening = (int) $closingCache[$empId][$fy];
				$ecOpening = (int) $ecClosingCache[$empId][$fy];
				continue;
			}

			$ecClosing = null;
			$closing = $this->_finalLedgerComputeClosingForFY($empId, $fy, $opening, $ecOpening, $ecClosing);

			$closingCache[$empId][$fy] = (int) $closing;
			$ecClosingCache[$empId][$fy] = (int) $ecClosing;
			$opening = (int) $closing;
			$ecOpening = (int) $ecClosing;
		}

		return array($opening, $ecOpening);
	}


	public function getProvisionalLedgerOpeningBalanceRuntime($empId, $firstYear)
	{
		//echo "empId=>".$empId.", firstYear=>".$firstYear; exit;
		$empId = (int) $empId;
		$firstYear = (int) $firstYear;

		if ($empId <= 0 || $firstYear <= 2005) {
			return 0;
		}

		static $closingCache = array(); // [empId][fyStart] => closing

		$targetFYStart = $firstYear - 1;
		if (isset($closingCache[$empId][$targetFYStart])) {
			return (int) $closingCache[$empId][$targetFYStart];
		}

		$opening = 0;
		for ($fy = 2005; $fy <= $targetFYStart; $fy++) {
			if (isset($closingCache[$empId][$fy])) {
				$opening = (int) $closingCache[$empId][$fy];
				continue;
			}
			if ($fy < 2008) {
				//continue;
			}
			$closing = $this->_provisionalLedgerComputeClosingForFY($empId, $fy, $opening);

			//echo "<br/>empId=>".$empId.", firstYear=>".$fy.", Opening=>".$opening.", closing=>".$closing;

			$closingCache[$empId][$fy] = $closing;
			$opening = $closing;
		}

		return (int) $opening;
	}

	/**
	 * Split an integer total across N displayed rows; returned integers sum exactly to $total.
	 * Used so duplicate month-rows each show a share of that month's interest.
	 */
	private function _splitIntegerAcrossRows($total, $n)
	{
		$total = (int) round((int) $total);
		$n = (int) $n;
		if ($n <= 0) {
			return array();
		}
		if ($n === 1) {
			return array($total);
		}
		$base = intdiv($total, $n);
		$rem = $total - ($base * $n);
		$out = array();
		for ($i = 0; $i < $n; $i++) {
			$out[] = $base + ($i < $rem ? 1 : 0);
		}
		return $out;
	}

	/**
	 * Compute closing for one FY (fyStart-fyStart+1) given opening.
	 */


	private function _finalLedgerComputeClosingForFY($empId, $fyStart, $opening, $employeeContributionOpening = 0, &$employeeContributionClosing = null)
	{
		$empId = (int) $empId;
		$fyStart = (int) $fyStart;
		$opening = (int) $opening;
		$employeeContributionOpening = (int) $employeeContributionOpening;

		$_dbg_model_log = APPPATH . 'logs/final_ledger_model_debug.txt';
		$_dbg_fy_label = $fyStart . '-' . ($fyStart + 1);
		/*file_put_contents($_dbg_model_log,
		"\n" . str_repeat('=', 80) . "\n" .
		"[MODEL] FY: {$_dbg_fy_label}  EmpId: {$empId}  Previous Year Closing / Current Year Opening: {$opening}\n" .
		str_repeat('-', 80) . "\n",
		FILE_APPEND
		);*/

		$data = array(
			'emp_id' => $empId,
			'first_year' => $fyStart,
			'second_year' => $fyStart + 1,
			'f_year' => $fyStart . "-" . ($fyStart + 1),
		);

		$monthsOrder = array(4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3);
		$rates = $this->getInterestRates($data['first_year'], $data['second_year']);
		//echo "<pre>".$data['first_year']."-".$data['second_year']; print_r($rates); echo "</pre><br>";
		if (!is_array($rates)) {
			$rates = array();
		}
		//echo "<pre>".$data['first_year']."-".$data['second_year']; print_r($rates); echo "</pre><br>";

		$dcpsRows = $this->getdcpsAllDetailsForFinalLedger($data);

		$byMonth = array();
		if (is_array($dcpsRows)) {
			foreach ($dcpsRows as $r) {
				$m = (int) $r['for_month'];
				if ($m < 1 || $m > 12) {
					$dt = isset($r['recovered_DCPS_with_voucher_date']) ? (DateTime::createFromFormat('d-m-Y', $r['recovered_DCPS_with_voucher_date']) ?: DateTime::createFromFormat('Y-m-d', $r['recovered_DCPS_with_voucher_date'])) : null;
					$m = $dt ? (int) $dt->format('n') : 4;
				}
				if (!isset($byMonth[$m])) {
					$byMonth[$m] = array();
				}
				$byMonth[$m][] = $r;
			}
		}

		$empBase = $employeeContributionOpening;
		$nmcBase = $employeeContributionOpening;

		$sumEmp = 0;
		$sumEmpSupp = 0;
		$sumNmc = 0;
		$sumNmcSupp = 0;
		$sumLoanInst = 0;
		$sumLoanTaken = 0;
		$sumInterest = 0;

		// Variables must be defined before the debug block that references them
		$empInterest = 0;
		$totalEmpInterest = 0;
		$nmcInterest = 0;
		$totalInterest = 0;

		foreach ($monthsOrder as $m) {
			$monthRecords = isset($byMonth[$m]) ? $byMonth[$m] : array();
			$empRegular = 0;
			$empSupp = 0;
			$nmcRegular = 0;
			$nmcSupp = 0;
			$loanInstallment = 0;
			$loanTaken = 0;
			$empInterest = 0;
			$nmcInterest = 0;

			$rate = (isset($rates[$m]) ? $rates[$m] : 0);


			// ── Sort records by voucher date, then voucher no, then file no ──────
			if (!empty($monthRecords) && is_array($monthRecords)) {
				usort($monthRecords, function ($a, $b) {
					$dateA = isset($a['recovered_DCPS_with_voucher_date']) ? $a['recovered_DCPS_with_voucher_date'] : '';
					$dateB = isset($b['recovered_DCPS_with_voucher_date']) ? $b['recovered_DCPS_with_voucher_date'] : '';
					$dtA = DateTime::createFromFormat('d-m-Y', $dateA) ?: null;
					$dtB = DateTime::createFromFormat('d-m-Y', $dateB) ?: null;
					$tsA = $dtA ? $dtA->getTimestamp() : 0;
					$tsB = $dtB ? $dtB->getTimestamp() : 0;
					if ($tsA !== $tsB) {
						return $tsA <=> $tsB;
					}
					$vnA = isset($a['recovered_DCPS_with_voucher_no']) ? (string) $a['recovered_DCPS_with_voucher_no'] : '';
					$vnB = isset($b['recovered_DCPS_with_voucher_no']) ? (string) $b['recovered_DCPS_with_voucher_no'] : '';
					if ($vnA !== $vnB) {
						return $vnA <=> $vnB;
					}
					$fnA = isset($a['file_no']) ? (string) $a['file_no'] : '';
					$fnB = isset($b['file_no']) ? (string) $b['file_no'] : '';
					return $fnA <=> $fnB;
				});
			}

			/*if (!empty($monthRecords)) {*/
				foreach ($monthRecords as $r) {
					if($r['basic'] == 0 && $r['da'] == 0 && $r['grade_pay'] == 0) {
						$r = array(
							'salary_type' => '',
							'Ideal_contribution_of_employee_for_DCPS' => 0,
							'emp_DCPS_contribution' => 0,
							'emp_supplimentory_contribution' => 0,
							'NMC_DCPS_contribution' => 0,
							'NMC_supplimentory_DCPS_contribution' => 0,
							'loan_installment_paid_through_salary' => 0,
							'DCPS_loan_taken_by_an_employee' => 0,
							'bunch_no' => '',
						);
					}
					$salaryType = isset($r['salary_type']) ? (string) $r['salary_type'] : '';
					$ideal = isset($r['Ideal_contribution_of_employee_for_DCPS'])
						&& $r['Ideal_contribution_of_employee_for_DCPS'] !== ''
						? (int) $r['Ideal_contribution_of_employee_for_DCPS'] : 0;

					$rowEmp = 0;
					$rowEmpSupp = 0;
					$rowNmc = 0;
					$rowNmcSupp = 0;
					$rowLoanInst = 0;
					$rowLoanTaken = 0;

					if ($salaryType === 'Regular') {
						/*$rowEmp  = !empty($r['emp_DCPS_contribution'])
						? (int)$r['emp_DCPS_contribution'] : $ideal;
						$rowNmc  = !empty($r['NMC_DCPS_contribution'])
						? (int)$r['NMC_DCPS_contribution'] : $ideal;
						} elseif ($salaryType === 'Suplimentory') {
						$rowEmpSupp = !empty($r['emp_supplimentory_contribution'])
						? (int)$r['emp_supplimentory_contribution'] : $ideal;
						$rowNmcSupp = !empty($r['NMC_supplimentory_DCPS_contribution'])
						? (int)$r['NMC_supplimentory_DCPS_contribution'] : $ideal;*/

						$rowEmp = $ideal;
						$rowNmc = $ideal;
					} elseif ($salaryType === 'Suplimentory') {
						$rowEmpSupp = $ideal;
						$rowNmcSupp = $ideal;
					}



					$rowLoanInst = !empty($r['loan_installment_paid_through_salary'])
						? (int) $r['loan_installment_paid_through_salary'] : 0;
					$rowLoanTaken = !empty($r['DCPS_loan_taken_by_an_employee'])
						? (int) $r['DCPS_loan_taken_by_an_employee'] : 0;

					// ── Update bases PER RECORD ──────────────────────────────────────
					$empBase = $ideal > 0 ? ($empBase + $rowEmp + $rowEmpSupp + $rowLoanInst) - $rowLoanTaken : 0;
					$nmcBase = $ideal > 0 ? ($nmcBase + $rowNmc + $rowNmcSupp) : 0;

					// ── Interest calculated on updated base after EACH record ────────
					//echo "<br/>empId=>".$empId.", firstYear=>".$fyStart.", Month=>".$m.", SalaryType=>".$salaryType.", EmpBase=>".$empBase.", NMCBase=>".$nmcBase.", Rate=>".$rate;
					$rowEmpInterest = round((($empBase * $rate) / 100) / 12, 0);
					$rowNmcInterest = round((($nmcBase * $rate) / 100) / 12, 0);

					// Accumulate per-record interest into month totals
					$empInterest += $rowEmpInterest;
					$nmcInterest += $rowNmcInterest;

					// Accumulate month-level totals for summing
					$empRegular += $rowEmp;
					$empSupp += $rowEmpSupp;
					$nmcRegular += $rowNmc;
					$nmcSupp += $rowNmcSupp;
					$loanInstallment += $rowLoanInst;
					$loanTaken += $rowLoanTaken;

					// ── Per-record debug log ─────────────────────────────────────────
					$_dbg_month_names = array(
						1 => 'January',
						2 => 'February',
						3 => 'March',
						4 => 'April',
						5 => 'May',
						6 => 'June',
						7 => 'July',
						8 => 'August',
						9 => 'September',
						10 => 'October',
						11 => 'November',
						12 => 'December'
					);
					$_dbg_month_label = isset($_dbg_month_names[$m]) ? $_dbg_month_names[$m] : $m;
					/*file_put_contents($_dbg_model_log,
					"[MODEL-ROW] FY: {$_dbg_fy_label}  Month: {$_dbg_month_label} ({$m})" .
					"  SalaryType: {$salaryType}" .
					"  Row Emp: {$rowEmp}  Row EmpSupp: {$rowEmpSupp}" .
					"  Row NMC: {$rowNmc}  Row NMCSupp: {$rowNmcSupp}" .
					"  Row LoanInst: {$rowLoanInst}  Row LoanTaken: {$rowLoanTaken}" .
					"  Rate: {$rate}" .
					"  EmpBase After Row: {$empBase}  NMCBase After Row: {$nmcBase}" .
					"  Row EmpInterest: {$rowEmpInterest}  Row NMCInterest: {$rowNmcInterest}\n",
					FILE_APPEND
					);*/
				}
			/*} else {
				// No records this month — still compute interest on carry-forward base
				$empInterest = round((($empBase * $rate) / 100), 0) / 12;
				$nmcInterest = round((($nmcBase * $rate) / 100), 0) / 12;
			}*/

			// ── Month-level debug log ────────────────────────────────────────────────
			$_dbg_month_names = array(
				1 => 'January',
				2 => 'February',
				3 => 'March',
				4 => 'April',
				5 => 'May',
				6 => 'June',
				7 => 'July',
				8 => 'August',
				9 => 'September',
				10 => 'October',
				11 => 'November',
				12 => 'December'
			);
			$_dbg_month_label     = isset($_dbg_month_names[$m]) ? $_dbg_month_names[$m] : $m;
			$_dbg_monthly_closing = ($empBase + $nmcBase);
			/*file_put_contents($_dbg_model_log,
			"[MODEL-COMPUTE] FY: {$_dbg_fy_label}  Month: {$_dbg_month_label} ({$m})" .
			"  Opening(FY): {$opening}" .
			"  Emp Regular: {$empRegular}  Emp Supp: {$empSupp}" .
			"  NMC Regular: {$nmcRegular}  NMC Supp: {$nmcSupp}" .
			"  Loan Installment: {$loanInstallment}  Loan Taken: {$loanTaken}" .
			"  Rate: {$rate}" .
			"  Emp Base: {$empBase}  NMC Base: {$nmcBase}" .
			"  Emp Interest (month total): {$empInterest}  NMC Interest (month total): {$nmcInterest}" .
			"  Monthly Closing (EmpBase+NmcBase): {$_dbg_monthly_closing}\n",
			FILE_APPEND
			);*/

			$sumInterest += ($empInterest + $nmcInterest);
			$totalEmpInterest += $empInterest;
			$sumEmp += $empRegular;
			$sumEmpSupp += $empSupp;
			$sumNmc += $nmcRegular;
			$sumNmcSupp += $nmcSupp;
			$sumLoanInst += $loanInstallment;
			$sumLoanTaken += $loanTaken;
		}

		$closing = ($opening
			+ ($sumEmp + $sumEmpSupp + $sumLoanInst)
			+ ($sumNmc + $sumNmcSupp)) - $sumLoanTaken
			+ ($sumInterest);

		
		// ── Employee Contribution running balance (carry-forward) ──────────────
		// ecClosing = current FY's employee deposits + current FY's employee interest.
		// The prior ecOpening is intentionally excluded from ecClosing so it does NOT
		// compound into the base for the next year. The prior ecOpening IS used above
		// to seed $empBase (so interest this FY is computed on the full running balance),
		// but only the current year's new increments carry forward as next year's opening.
		$employeeContributionClosing = (int) (($sumEmp + $sumEmpSupp + $sumLoanInst) - $sumLoanTaken + $totalEmpInterest);

		/*file_put_contents($_dbg_model_log,
		"[MODEL-COMPUTE] FY: {$_dbg_fy_label}  EmpId: {$empId}" .
		"  Sum Emp: {$sumEmp}  Sum EmpSupp: {$sumEmpSupp}" .
		"  Sum NMC: {$sumNmc}  Sum NMCSupp: {$sumNmcSupp}" .
		"  Sum LoanInst: {$sumLoanInst}  Sum LoanTaken: {$sumLoanTaken}" .
		"  Sum Interest: {$sumInterest}" .
		"  Opening: {$opening}  >>> FINAL CLOSING L.N. 1559: {$closing}\n" .
		str_repeat('-', 80) . "\n",
		FILE_APPEND
		);*/

		//$_dbg_closing_cr = ($opening + ($totals['emp_regular']+$totals['emp_supp']+$totals['loan_installment']) + ($totals['nmc_regular']+$totals['nmc_supp'])) - $totals['loan_taken'] + $totals['total_interest'];

		return (int) $closing;
	}

	private function _provisionalLedgerComputeClosingForFY($empId, $fyStart, $opening)
	{
		$empId = (int) $empId;
		$fyStart = (int) $fyStart;
		$opening = (int) $opening;

		$_dbg_model_log = APPPATH . 'logs/final_ledger_model_debug.txt';
		$_dbg_fy_label = $fyStart . '-' . ($fyStart + 1);
		/*file_put_contents($_dbg_model_log,
		"\n" . str_repeat('=', 80) . "\n" .
		"[MODEL] FY: {$_dbg_fy_label}  EmpId: {$empId}  Previous Year Closing / Current Year Opening: {$opening}\n" .
		str_repeat('-', 80) . "\n",
		FILE_APPEND
		);*/

		$data = array(
			'emp_id' => $empId,
			'first_year' => $fyStart,
			'second_year' => $fyStart + 1,
			'f_year' => $fyStart . "-" . ($fyStart + 1),
		);

		$monthsOrder = array(4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3);
		$rates = $this->getInterestRates($data['first_year'], $data['second_year']);
		if (!is_array($rates)) {
			$rates = array();
		}

		$dcpsRows = $this->getdcpsAllDetailsForLedger($data);

		$byMonth = array();
		if (is_array($dcpsRows)) {
			foreach ($dcpsRows as $r) {
				$m = (int) $r['for_month'];
				if ($m < 1 || $m > 12) {
					$dt = isset($r['recovered_DCPS_with_voucher_date']) ? (DateTime::createFromFormat('d-m-Y', $r['recovered_DCPS_with_voucher_date']) ?: DateTime::createFromFormat('Y-m-d', $r['recovered_DCPS_with_voucher_date'])) : null;
					$m = $dt ? (int) $dt->format('n') : 4;
				}
				if (!isset($byMonth[$m])) {
					$byMonth[$m] = array();
				}
				$byMonth[$m][] = $r;
			}
		}

		$empBase = $opening;
		$nmcBase = $opening;

		$sumEmp = 0;
		$sumEmpSupp = 0;
		$sumNmc = 0;
		$sumNmcSupp = 0;
		$sumLoanInst = 0;
		$sumLoanTaken = 0;
		$sumInterest = 0;

		// Variables must be defined before the debug block that references them
		$empInterest = 0;
		$nmcInterest = 0;
		$totalInterest = 0;

		foreach ($monthsOrder as $m) {
			$monthRecords = isset($byMonth[$m]) ? $byMonth[$m] : array();
			$empRegular = 0;
			$empSupp = 0;
			$nmcRegular = 0;
			$nmcSupp = 0;
			$loanInstallment = 0;
			$loanTaken = 0;
			$empInterest = 0;
			$nmcInterest = 0;

			$rate = round((isset($rates[$m]) ? (int) $rates[$m] : 0), 0);


			// ── Sort records by voucher date, then voucher no, then file no ──────
			if (!empty($monthRecords) && is_array($monthRecords)) {
				usort($monthRecords, function ($a, $b) {
					$dateA = isset($a['recovered_DCPS_with_voucher_date']) ? $a['recovered_DCPS_with_voucher_date'] : '';
					$dateB = isset($b['recovered_DCPS_with_voucher_date']) ? $b['recovered_DCPS_with_voucher_date'] : '';
					$dtA = DateTime::createFromFormat('d-m-Y', $dateA) ?: null;
					$dtB = DateTime::createFromFormat('d-m-Y', $dateB) ?: null;
					$tsA = $dtA ? $dtA->getTimestamp() : 0;
					$tsB = $dtB ? $dtB->getTimestamp() : 0;
					if ($tsA !== $tsB) {
						return $tsA <=> $tsB;
					}
					$vnA = isset($a['recovered_DCPS_with_voucher_no']) ? (string) $a['recovered_DCPS_with_voucher_no'] : '';
					$vnB = isset($b['recovered_DCPS_with_voucher_no']) ? (string) $b['recovered_DCPS_with_voucher_no'] : '';
					if ($vnA !== $vnB) {
						return $vnA <=> $vnB;
					}
					$fnA = isset($a['file_no']) ? (string) $a['file_no'] : '';
					$fnB = isset($b['file_no']) ? (string) $b['file_no'] : '';
					return $fnA <=> $fnB;
				});
			}

			if (!empty($monthRecords)) {
				foreach ($monthRecords as $r) {
					if($r['basic'] == 0 && $r['da'] == 0 && $r['grade_pay'] == 0) {
						$r = array(
							'salary_type' => '',
							'Ideal_contribution_of_employee_for_DCPS' => 0,
							'emp_DCPS_contribution' => 0,
							'emp_supplimentory_contribution' => 0,
							'NMC_DCPS_contribution' => 0,
							'NMC_supplimentory_DCPS_contribution' => 0,
							'loan_installment_paid_through_salary' => 0,
							'DCPS_loan_taken_by_an_employee' => 0,
							'bunch_no' => '',
						);
					}
					$salaryType = isset($r['salary_type']) ? (string) $r['salary_type'] : '';
					$ideal = isset($r['Ideal_contribution_of_employee_for_DCPS'])
						&& $r['Ideal_contribution_of_employee_for_DCPS'] !== ''
						? (int) $r['Ideal_contribution_of_employee_for_DCPS'] : 0;

					$rowEmp = 0;
					$rowEmpSupp = 0;
					$rowNmc = 0;
					$rowNmcSupp = 0;
					$rowLoanInst = 0;
					$rowLoanTaken = 0;

					if ($salaryType === 'Regular') {
						$empRegular = !empty($r['emp_DCPS_contribution'])
							? (int) $r['emp_DCPS_contribution'] : 0;
						$nmcRegular = !empty($r['NMC_DCPS_contribution'])
							? (int) $r['NMC_DCPS_contribution'] : 0;
					} elseif ($salaryType === 'Suplimentory') {
						$empSupp = !empty($r['emp_supplimentory_contribution'])
							? (int) $r['emp_supplimentory_contribution'] : 0;
						$nmcSupp = !empty($r['NMC_supplimentory_DCPS_contribution'])
							? (int) $r['NMC_supplimentory_DCPS_contribution'] : 0;

					}



					$rowLoanInst = !empty($r['loan_installment_paid_through_salary'])
						? (int) $r['loan_installment_paid_through_salary'] : 0;
					$rowLoanTaken = !empty($r['DCPS_loan_taken_by_an_employee'])
						? (int) $r['DCPS_loan_taken_by_an_employee'] : 0;

					// ── Update bases PER RECORD ──────────────────────────────────────
					$empBase = $ideal > 0 ? ($empBase + $rowEmp + $rowEmpSupp + $rowLoanInst) - $rowLoanTaken : 0;
					$nmcBase = $ideal > 0 ? ($nmcBase + $rowNmc + $rowNmcSupp) : 0;

					// ── Interest calculated on updated base after EACH record ────────
					$rowEmpInterest = round((($empBase * $rate) / 100) / 12, 0);
					$rowNmcInterest = round((($nmcBase * $rate) / 100) / 12, 0);

					// Accumulate per-record interest into month totals
					$empInterest += $rowEmpInterest;
					$nmcInterest += $rowNmcInterest;

					// Accumulate month-level totals for summing
					$empRegular += $rowEmp;
					$empSupp += $rowEmpSupp;
					$nmcRegular += $rowNmc;
					$nmcSupp += $rowNmcSupp;
					$loanInstallment += $rowLoanInst;
					$loanTaken += $rowLoanTaken;

					// ── Per-record debug log ─────────────────────────────────────────
					$_dbg_month_names = array(
						1 => 'January',
						2 => 'February',
						3 => 'March',
						4 => 'April',
						5 => 'May',
						6 => 'June',
						7 => 'July',
						8 => 'August',
						9 => 'September',
						10 => 'October',
						11 => 'November',
						12 => 'December'
					);
					$_dbg_month_label = isset($_dbg_month_names[$m]) ? $_dbg_month_names[$m] : $m;
					/*file_put_contents($_dbg_model_log,
					"[MODEL-ROW] FY: {$_dbg_fy_label}  Month: {$_dbg_month_label} ({$m})" .
					"  SalaryType: {$salaryType}" .
					"  Row Emp: {$rowEmp}  Row EmpSupp: {$rowEmpSupp}" .
					"  Row NMC: {$rowNmc}  Row NMCSupp: {$rowNmcSupp}" .
					"  Row LoanInst: {$rowLoanInst}  Row LoanTaken: {$rowLoanTaken}" .
					"  Rate: {$rate}" .
					"  EmpBase After Row: {$empBase}  NMCBase After Row: {$nmcBase}" .
					"  Row EmpInterest: {$rowEmpInterest}  Row NMCInterest: {$rowNmcInterest}\n",
					FILE_APPEND
					);*/
				}
			} else {
				// No records this month — still compute interest on carry-forward base
				$empInterest = round((($empBase * $rate) / 100), 0) / 12;
				$nmcInterest = round((($nmcBase * $rate) / 100), 0) / 12;
			}

			// ── Month-level debug log ────────────────────────────────────────────────
			$_dbg_month_names = array(
				1 => 'January',
				2 => 'February',
				3 => 'March',
				4 => 'April',
				5 => 'May',
				6 => 'June',
				7 => 'July',
				8 => 'August',
				9 => 'September',
				10 => 'October',
				11 => 'November',
				12 => 'December'
			);
			$_dbg_month_label     = isset($_dbg_month_names[$m]) ? $_dbg_month_names[$m] : $m;
			$_dbg_monthly_closing = ($empBase + $nmcBase);
			/*file_put_contents($_dbg_model_log,
			"[MODEL-COMPUTE] FY: {$_dbg_fy_label}  Month: {$_dbg_month_label} ({$m})" .
			"  Opening(FY): {$opening}" .
			"  Emp Regular: {$empRegular}  Emp Supp: {$empSupp}" .
			"  NMC Regular: {$nmcRegular}  NMC Supp: {$nmcSupp}" .
			"  Loan Installment: {$loanInstallment}  Loan Taken: {$loanTaken}" .
			"  Rate: {$rate}" .
			"  Emp Base: {$empBase}  NMC Base: {$nmcBase}" .
			"  Emp Interest (month total): {$empInterest}  NMC Interest (month total): {$nmcInterest}" .
			"  Monthly Closing (EmpBase+NmcBase): {$_dbg_monthly_closing}\n",
			FILE_APPEND
			);*/

			$sumInterest += ($empInterest + $nmcInterest);
			$sumEmp += $empRegular;
			$sumEmpSupp += $empSupp;
			$sumNmc += $nmcRegular;
			$sumNmcSupp += $nmcSupp;
			$sumLoanInst += $loanInstallment;
			$sumLoanTaken += $loanTaken;
		}

		$closing = ($opening
			+ ($sumEmp + $sumEmpSupp + $sumLoanInst)
			+ ($sumNmc + $sumNmcSupp)) - $sumLoanTaken
			+ ($sumInterest);

		/*file_put_contents($_dbg_model_log,
		"[MODEL-COMPUTE] FY: {$_dbg_fy_label}  EmpId: {$empId}" .
		"  Sum Emp: {$sumEmp}  Sum EmpSupp: {$sumEmpSupp}" .
		"  Sum NMC: {$sumNmc}  Sum NMCSupp: {$sumNmcSupp}" .
		"  Sum LoanInst: {$sumLoanInst}  Sum LoanTaken: {$sumLoanTaken}" .
		"  Sum Interest: {$sumInterest}" .
		"  Opening: {$opening}  >>> FINAL CLOSING L.N.1801: {$closing}\n" .
		str_repeat('-', 80) . "\n",
		FILE_APPEND
		);*/

		//$_dbg_closing_cr = ($opening + ($totals['emp_regular']+$totals['emp_supp']+$totals['loan_installment']) + ($totals['nmc_regular']+$totals['nmc_supp'])) - $totals['loan_taken'] + $totals['total_interest'];

		return (int) $closing;
	}



	/**
	 * Get Year-Wise Broad Sheet Summary (aggregated across all employees)
	 * Shows: Opening Balance, Total Contributions, Interest, Withdrawals, Closing Balance
	 */
	public function getYearWiseBroadSheetSummary($firstYear, $secondYear)
	{
		$firstYear = (int) $firstYear;
		$secondYear = (int) $secondYear;

		if ($firstYear <= 0) {
			return array();
		}

		// Get all employees' month-wise data for the financial year
		$data = array(
			'first_year' => $firstYear,
			'second_year' => $secondYear,
			'f_year' => $firstYear . "-" . $secondYear
		);

		$dcpsRows = $this->getdcpsAllDetailsForLedger($data);

		$summary = array(
			'financial_year' => $firstYear . "-" . $secondYear,
			'first_year' => $firstYear,
			'second_year' => $secondYear,
			'opening_balance' => 0,
			'emp_contribution_regular' => 0,
			'emp_contribution_supp' => 0,
			'total_emp_contribution' => 0,
			'nmc_contribution_regular' => 0,
			'nmc_contribution_supp' => 0,
			'total_corp_contribution' => 0,
			'loan_installment' => 0,
			'total_deposits' => 0,
			'loan_taken' => 0,
			'total_withdrawals' => 0,
			'total_interest' => 0,
			'closing_balance' => 0,
			'monthly_details' => array()
		);

		// Get opening balance (previous year's closing)
		//$summary['opening_balance'] = (int) $this->getYearWisePreviousClosingBalance($firstYear);

		$monthsOrder = array(4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3);
		$rates = $this->getInterestRates($firstYear, $secondYear);
		if (!is_array($rates)) {
			$rates = array();
		}

		// Group by month
		$byMonth = array();
		if (is_array($dcpsRows)) {
			foreach ($dcpsRows as $r) {
				$m = (int) $r['for_month'];
				if (!isset($byMonth[$m])) {
					$byMonth[$m] = array();
				}
				$byMonth[$m][] = $r;
			}
		}

		$runningBalance = $summary['opening_balance'];

		foreach ($monthsOrder as $m) {
			$monthRecords = isset($byMonth[$m]) ? $byMonth[$m] : array();

			$monthData = array(
				'month' => $m,
				'year' => ($m >= 4) ? $firstYear : $secondYear,
				'emp_regular' => 0,
				'emp_supp' => 0,
				'nmc_regular' => 0,
				'nmc_supp' => 0,
				'loan_installment' => 0,
				'loan_taken' => 0,
				'interest' => 0,
				'monthly_closing' => 0
			);

			$rate = isset($rates[$m]) ? (int) $rates[$m] : 0;

			// Sort by voucher date if records exist
			if (!empty($monthRecords) && is_array($monthRecords)) {
				usort($monthRecords, function ($a, $b) {
					$dateA = isset($a['recovered_DCPS_with_voucher_date']) ? $a['recovered_DCPS_with_voucher_date'] : '';
					$dateB = isset($b['recovered_DCPS_with_voucher_date']) ? $b['recovered_DCPS_with_voucher_date'] : '';
					$dtA = DateTime::createFromFormat('d-m-Y', $dateA) ?: null;
					$dtB = DateTime::createFromFormat('d-m-Y', $dateB) ?: null;
					$tsA = $dtA ? $dtA->getTimestamp() : 0;
					$tsB = $dtB ? $dtB->getTimestamp() : 0;
					if ($tsA !== $tsB) {
						return $tsA <=> $tsB;
					}
					return 0;
				});
			}

			// Aggregate all records for this month
			if (!empty($monthRecords)) {
				foreach ($monthRecords as $r) {
					$salaryType = isset($r['salary_type']) ? (string) $r['salary_type'] : '';

					$emp_reg = isset($r['emp_DCPS_contribution']) ? (int) $r['emp_DCPS_contribution'] : 0;
					$emp_supp = isset($r['emp_DCPS_supplimentory_contribution']) ? (int) $r['emp_DCPS_supplimentory_contribution'] : 0;
					$nmc_reg = isset($r['NMC_DCPS_contribution']) ? (int) $r['NMC_DCPS_contribution'] : 0;
					$nmc_supp = isset($r['NMC_supplimentory_DCPS_contribution']) ? (int) $r['NMC_supplimentory_DCPS_contribution'] : 0;
					$loan_inst = isset($r['loan_installment_paid_through_salary']) ? (int) $r['loan_installment_paid_through_salary'] : 0;
					$loan_taken = isset($r['DCPS_loan_taken_by_an_employee']) ? (int) $r['DCPS_loan_taken_by_an_employee'] : 0;

					$monthData['emp_regular'] += $emp_reg;
					$monthData['emp_supp'] += $emp_supp;
					$monthData['nmc_regular'] += $nmc_reg;
					$monthData['nmc_supp'] += $nmc_supp;
					$monthData['loan_installment'] += $loan_inst;
					$monthData['loan_taken'] += $loan_taken;
				}
			}

			// Calculate month totals
			$empTotal = $monthData['emp_regular'] + $monthData['emp_supp'];
			$nmcTotal = $monthData['nmc_regular'] + $monthData['nmc_supp'];
			$monthDeposits = $empTotal + $nmcTotal + $monthData['loan_installment'];
			$monthWithdrawals = $monthData['loan_taken'];

			// Calculate month-wise interest on running balance
			$monthInterest = 0;
			if ($rate > 0) {
				$balanceBeforeInterest = $runningBalance + $monthDeposits;
				$monthInterest = round(($balanceBeforeInterest * $rate / 100) / 12, 0);
			}

			$monthData['interest'] = $monthInterest;
			$monthData['monthly_closing'] = $runningBalance + $monthDeposits - $monthWithdrawals + $monthInterest;

			// Update running balance
			$runningBalance = $monthData['monthly_closing'];

			// Add to summary arrays
			$summary['emp_contribution_regular'] += $monthData['emp_regular'];
			$summary['emp_contribution_supp'] += $monthData['emp_supp'];
			$summary['nmc_contribution_regular'] += $monthData['nmc_regular'];
			$summary['nmc_contribution_supp'] += $monthData['nmc_supp'];
			$summary['loan_installment'] += $monthData['loan_installment'];
			$summary['loan_taken'] += $monthData['loan_taken'];
			$summary['total_interest'] += $monthInterest;

			$summary['monthly_details'][$m] = $monthData;
		}

		// Calculate final totals
		$summary['total_emp_contribution'] = $summary['emp_contribution_regular'] + $summary['emp_contribution_supp'];
		$summary['total_corp_contribution'] = $summary['nmc_contribution_regular'] + $summary['nmc_contribution_supp'];
		$summary['total_deposits'] = $summary['total_emp_contribution'] + $summary['total_corp_contribution'] + $summary['loan_installment'];
		$summary['total_withdrawals'] = $summary['loan_taken'];

		// Closing balance calculation
		$summary['closing_balance'] = $summary['opening_balance']
			+ $summary['total_deposits']
			- $summary['total_withdrawals']
			+ $summary['total_interest'];

		return $summary;
	}

	/**
	 * Get Year-Wise Previous Closing Balance (for opening balance of current year)
	 * Calculates closing balance of previous financial year across all employees
	 */
	public function getYearWisePreviousClosingBalance($firstYear)
	{
		$firstYear = (int) $firstYear;

		if ($firstYear <= 2005) {
			return 0;
		}

		// Previous FY starts one year before
		$prevFirstYear = $firstYear - 1;
		$prevSecondYear = $firstYear;

		// Get all employee closing balances for previous year
		$data = array(
			'first_year' => $prevFirstYear,
			'second_year' => $prevSecondYear
		);

		$dcpsRows = $this->getdcpsAllDetailsForLedger($data);

		if (empty($dcpsRows)) {
			return 0;
		}

		// Collect unique employee IDs
		$empIds = array();
		foreach ($dcpsRows as $r) {
			$empIds[(int) $r['emp_td']] = true;
		}

		// Calculate closing for each employee in previous year and sum
		$totalClosing = 0;
		foreach (array_keys($empIds) as $empId) {
			//$empClosing = (int) $this->getFinalLedgerOpeningBalanceRuntime($empId, $firstYear);			
			//$totalClosing += $empClosing;
		}

		return (int) $totalClosing;
	}

	/**
	 * Get Month-Wise Year Summary for Broad Sheet Report
	 * Returns array indexed by month with totals
	 */
	public function getYearWiseMonthlyBreakdown($firstYear, $secondYear)
	{
		$summary = $this->getYearWiseBroadSheetSummary($firstYear, $secondYear);

		if (empty($summary) || empty($summary['monthly_details'])) {
			return array();
		}

		return $summary['monthly_details'];
	}

	public function getYearwiseLedgerSummary($empId)
	{
		$empId = (int) $empId;
		if ($empId <= 0) {
			return array();
		}

		$monthsOrder = array(4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3);
		$yearlyData = array();

		// Loop through financial years from 2005 to 2014
		for ($fy = 2005; $fy <= 2014; $fy++) {

			// ── Get opening & ecOpening from the SAME authoritative method
			//    that the final_ledger_report uses (getFinalLedgerEmployeeContributionOpeningBalanceRuntime)
			//    This ensures opening balances and interest bases match the final ledger exactly.
			$authResult = $this->getFinalLedgerEmployeeContributionOpeningBalanceRuntime($empId, $fy);
			if (is_array($authResult)) {
				list($opening, $ecOpening) = $authResult;
			} else {
				$opening = (int) $authResult;
				$ecOpening = 0;
			}
			$opening = (int) $opening;
			$ecOpening = (int) $ecOpening;

			$data = array(
				'emp_id' => $empId,
				'first_year' => $fy,
				'second_year' => $fy + 1,
				'f_year' => $fy . "-" . ($fy + 1),
			);

			$rates = $this->getInterestRates($fy, $fy + 1);
			if (!is_array($rates)) {
				$rates = array();
			}

			$dcpsRows = $this->getdcpsAllDetailsForLedger($data);

			$byMonth = array();
			if (is_array($dcpsRows)) {
				foreach ($dcpsRows as $r) {
					$m = (int) $r['for_month'];
					if (!isset($byMonth[$m])) {
						$byMonth[$m] = array();
					}
					$byMonth[$m][] = $r;
				}
			}

			// Seed interest bases from ecOpening (matching getFinalLedgerCumulativeRows)
			$empBase = $ecOpening;
			$nmcBase = $ecOpening;

			$sumEmp = 0;
			$sumEmpSupp = 0;
			$sumNmc = 0;
			$sumNmcSupp = 0;
			$sumLoanInst = 0;
			$sumLoanTaken = 0;
			$totalEmpInterest = 0;
			$totalNmcInterest = 0;

			foreach ($monthsOrder as $m) {
				$monthRecords = isset($byMonth[$m]) ? $byMonth[$m] : array();
				$empRegular = 0;
				$empSupp = 0;
				$nmcRegular = 0;
				$nmcSupp = 0;
				$loanInstallment = 0;
				$loanTaken = 0;
				$empInterest = 0;
				$nmcInterest = 0;

				$rate = (isset($rates[$m]) ? $rates[$m] : 0);

				if (!empty($monthRecords) && is_array($monthRecords)) {
					usort($monthRecords, function ($a, $b) {
						$dateA = isset($a['recovered_DCPS_with_voucher_date']) ? $a['recovered_DCPS_with_voucher_date'] : '';
						$dateB = isset($b['recovered_DCPS_with_voucher_date']) ? $b['recovered_DCPS_with_voucher_date'] : '';
						$dtA = DateTime::createFromFormat('d-m-Y', $dateA) ?: null;
						$dtB = DateTime::createFromFormat('d-m-Y', $dateB) ?: null;
						$tsA = $dtA ? $dtA->getTimestamp() : 0;
						$tsB = $dtB ? $dtB->getTimestamp() : 0;
						if ($tsA !== $tsB) {
							return $tsA <=> $tsB;
						}
						$vnA = isset($a['recovered_DCPS_with_voucher_no']) ? (string) $a['recovered_DCPS_with_voucher_no'] : '';
						$vnB = isset($b['recovered_DCPS_with_voucher_no']) ? (string) $b['recovered_DCPS_with_voucher_no'] : '';
						if ($vnA !== $vnB) {
							return $vnA <=> $vnB;
						}
						$fnA = isset($a['file_no']) ? (string) $a['file_no'] : '';
						$fnB = isset($b['file_no']) ? (string) $b['file_no'] : '';
						return $fnA <=> $fnB;
					});
				}

				//echo "<pre>"; print_r($monthRecords); echo "</pre>";

				/*if (!empty($monthRecords)) {*/
					foreach ($monthRecords as $r) {
						// Zero-salary guard (matching getFinalLedgerCumulativeRows)
						if($r['basic'] == 0 && $r['da'] == 0 && $r['grade_pay'] == 0) {
							$r = array(
								'salary_type' => '',
								'Ideal_contribution_of_employee_for_DCPS' => 0,
								'emp_DCPS_contribution' => 0,
								'emp_supplimentory_contribution' => 0,
								'NMC_DCPS_contribution' => 0,
								'NMC_supplimentory_DCPS_contribution' => 0,
								'loan_installment_paid_through_salary' => 0,
								'DCPS_loan_taken_by_an_employee' => 0,
								'bunch_no' => '',
							);
							//continue;
							//echo "<br>2203: Zero-salary record found for empId {$empId} in FY {$fy}, month {$m}. Using zeroed contributions.";	
						}
						
						$salaryType = isset($r['salary_type']) ? (string) $r['salary_type'] : '';
						$ideal = isset($r['Ideal_contribution_of_employee_for_DCPS'])
							&& $r['Ideal_contribution_of_employee_for_DCPS'] !== ''
							? (int) $r['Ideal_contribution_of_employee_for_DCPS'] : 0;

						$rowEmp = 0;
						$rowEmpSupp = 0;
						$rowNmc = 0;
						$rowNmcSupp = 0;
						$rowLoanInst = 0;
						$rowLoanTaken = 0;

						if ($salaryType === 'Regular') {
							$rowEmp = $ideal;
							$rowNmc = $ideal;
						} elseif ($salaryType === 'Suplimentory') {
							$rowEmpSupp = $ideal;
							$rowNmcSupp = $ideal;
						}

						$rowLoanInst = !empty($r['loan_installment_paid_through_salary'])
							? (int) $r['loan_installment_paid_through_salary'] : 0;
						$rowLoanTaken = !empty($r['DCPS_loan_taken_by_an_employee'])
							? (int) $r['DCPS_loan_taken_by_an_employee'] : 0;

						// Base update with $ideal > 0 guard (matching getFinalLedgerCumulativeRows)
						$empBase = $ideal > 0 ? ($empBase + $rowEmp + $rowEmpSupp + $rowLoanInst) - $rowLoanTaken : 0;
						$nmcBase = $ideal > 0 ? ($nmcBase + $rowNmc + $rowNmcSupp) : 0;

						$rowEmpInterest = round((($empBase * $rate) / 100) / 12, 0);
						$rowNmcInterest = round((($nmcBase * $rate) / 100) / 12, 0);

						$empInterest += $rowEmpInterest;
						$nmcInterest += $rowNmcInterest;

						$empRegular += $rowEmp;
						$empSupp += $rowEmpSupp;
						$nmcRegular += $rowNmc;
						$nmcSupp += $rowNmcSupp;
						$loanInstallment += $rowLoanInst;
						$loanTaken += $rowLoanTaken;
					}
				/*} else {
					$empInterest = round((($empBase * $rate) / 100), 0) / 12;
					$nmcInterest = round((($nmcBase * $rate) / 100), 0) / 12;
				}*/

				$totalEmpInterest += $empInterest;
				$totalNmcInterest += $nmcInterest;
				$sumEmp += $empRegular;
				$sumEmpSupp += $empSupp;
				$sumNmc += $nmcRegular;
				$sumNmcSupp += $nmcSupp;
				$sumLoanInst += $loanInstallment;
				$sumLoanTaken += $loanTaken;
			}

			$sumInterest = ($totalEmpInterest + $totalNmcInterest);
			$closing = ($opening
				+ ($sumEmp + $sumEmpSupp + $sumLoanInst)
				+ ($sumNmc + $sumNmcSupp)) - $sumLoanTaken
				+ ($sumInterest);

			$yearlyData[$fy] = array(
				'opening_balance' => $opening,
				'employee_contribution' => ($sumEmp + $sumEmpSupp + $sumLoanInst) - $sumLoanTaken,
				'employee_interest' => $totalEmpInterest,
				'nmc_contribution' => ($sumNmc + $sumNmcSupp),
				'nmc_interest' => $totalNmcInterest,
				'closing_balance' => $closing
			);
		}

		return $yearlyData;
	}

}
?>