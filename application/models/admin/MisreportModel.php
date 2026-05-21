<?php if(!defined('BASEPATH')) exit('no direct script Access allowed'); 

class MisreportModel extends CI_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getMasterDataOld($empId = ""){ 
	    $this->db->select('*');
		$this->db->from('emp_master');
		if(isset($empId) && $empId != ""){
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


    public function gerMasterDetails($empId = "", $payCenter = ""){
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
	
	public function getPayCenterData(){ 
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

	
	public function getdcpsDetails($data){ 
	   $sql = "SELECT `emp_td`, 
		(sum(`emp_DCPS_contribution`)+sum(emp_DCPS_supplimentory_contribution)) as emp_DCPS_contribution, 
		(sum(`NMC_DCPS_contribution`)+sum(NMC_supplimentory_DCPS_contribution)) as `NMC_DCPS_contribution`, 
		((sum(`emp_DCPS_contribution`)+sum(emp_DCPS_supplimentory_contribution))+(sum(`NMC_DCPS_contribution`)+sum(NMC_supplimentory_DCPS_contribution))+sum(loan_installment_paid_through_salary)) as total_contribution, 
		sum(`loan_installment_paid_through_salary`) as loan_installment_paid_through_salary, 
		sum(`DCPS_loan_taken_by_an_employee`) as `DCPS_loan_taken_by_an_employee`, 
		`for_month`, 
		`for_year` 
		FROM `dpt_master_dcps` where is_deleted = 0 ";
		if(isset($data['emp_id']) && $data['emp_id'] !=""){
		    $sql.=" AND `emp_td` = ".$data['emp_id'];
		}
		if(isset($data['first_year']) && $data['first_year'] !="" && isset($data['second_year']) && $data['second_year'] !="" ){
		    $sql .=" and  ((`for_month` >= 4 and `for_month` <= 12 && `for_year` = ".$data['first_year'].") Or (`for_month` >= 1 and `for_month` <= 3 && `for_year` = ".$data['second_year'].")) ";
		}
		elseif(isset($data['first_year']) && $data['first_year'] !="" ){
		    $sql .=" and  ((`for_month` >= 4 and `for_month` <= 12 && `for_year` = ".$data['first_year'].")) ";
		}
		elseif(isset($data['second_year']) && $data['second_year'] !="" ){
		    $sql .=" and  ((`for_month` >= 1 and `for_month` <= 3 && `for_year` = ".$data['second_year'].")) ";
		}
		
		//$sql .=" and emp_td = 8967 ";
		
		if(isset($data['emp_id']) && $data['emp_id'] !=""){
		    $sql.=" group by for_month, emp_td, for_year ";
		}
		else{
		    $sql.=" group by for_month, for_year ";
		}
		
		
		
		$query = $this->db->query($sql);
		//echo "<br/>". $sql; exit; 
	
		$dcpsRow = array();
		if ($query) {
			return $query->result_array();
		}
		return 0;
	}
	
	public function getdcpsDetailsNewOriginal($data){ 
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
		if(isset($data['emp_id']) && $data['emp_id'] !=""){
		    $sql.=" AND mst.`emp_td` = ".$data['emp_id'];
		}
		if(isset($data['first_year']) && $data['first_year'] !="" && isset($data['second_year']) && $data['second_year'] !="" ){
		    $sql .=" and  ((mst.`for_month` >= 4 and mst.`for_month` <= 12 && mst.`for_year` = ".$data['first_year'].") Or (mst.`for_month` >= 1 and mst.`for_month` <= 3 && mst.`for_year` = ".$data['second_year'].")) ";
		}
		elseif(isset($data['first_year']) && $data['first_year'] !="" ){
		    $sql .=" and  ((mst.`for_month` >= 4 and mst.`for_month` <= 12 && mst.`for_year` = ".$data['first_year'].")) ";
		}
		elseif(isset($data['second_year']) && $data['second_year'] !="" ){
		    $sql .=" and  ((mst.`for_month` >= 1 and mst.`for_month` <= 3 && mst.`for_year` = ".$data['second_year'].")) ";
		}
		
		$sql .=" and mst.emp_td = 8967 ";
		
		if(isset($data['emp_id']) && $data['emp_id'] !=""){
		    $sql.=" group by mst.for_month, mst.emp_td, mst.for_year ";
		}
		else{
		    $sql.=" group by mst.for_month, mst.for_year ";
		}
		
		
		
		$query = $this->db->query($sql);
		echo "<br/>". $sql; exit; 
	
		$dcpsRow = array();
		if ($query) {
			return $query->result_array();
		}
		return 0;
	}
	
	public function getdcpsDetailsNew($data) { 
	    if(!empty($data)){
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
                        mst.is_deleted = 0 and mst.emp_td > 0 " ;
        
            // Add conditions dynamically based on input
            if (isset($data['emp_id']) && $data['emp_id'] != "") {
                $sql .= " AND mst.`emp_td` = " . (int)$data['emp_id'];
            }
            
            if (isset($data['voucher_date']) && $data['voucher_date'] != "") {
                $sql .= " AND mst.`recovered_DCPS_with_voucher_date` = " . $this->db->escape($data['voucher_date']);
            }
    
            if (isset($data['voucher_no']) && $data['voucher_no'] != "") {
                $sql .= " AND mst.`recovered_DCPS_with_voucher_no` = " . $this->db->escape($data['voucher_no']);
            }
        
            if (isset($data['first_year']) && $data['first_year'] != "" && isset($data['second_year']) && $data['second_year'] != "") {
                $sql .= " AND (
                    (mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = " . (int)$data['first_year'] . ") 
                    OR 
                    (mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = " . (int)$data['second_year'] . ")
                )";
            } elseif (isset($data['first_year']) && $data['first_year'] != "") {
                $sql .= " AND mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = " . (int)$data['first_year'];
            } elseif (isset($data['second_year']) && $data['second_year'] != "") {
                $sql .= " AND mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = " . (int)$data['second_year'];
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
        return 0;
    }


    public function getdcpsAllDetails($data) { 
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
                    mst.is_deleted = 0 and mst.emp_td > 0 " ;
    
        // Add conditions dynamically based on input
        if (isset($data['emp_id']) && $data['emp_id'] != "") {
            $sql .= " AND mst.`emp_td` = " . (int)$data['emp_id'];
        }
    
        if (isset($data['first_year']) && $data['first_year'] != "" && isset($data['second_year']) && $data['second_year'] != "") {
            $sql .= " AND (
                (mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = " . (int)$data['first_year'] . ") 
                OR 
                (mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = " . (int)$data['second_year'] . ")
            )";
        } elseif (isset($data['first_year']) && $data['first_year'] != "") {
            $sql .= " AND mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = " . (int)$data['first_year'];
        } elseif (isset($data['second_year']) && $data['second_year'] != "") {
            $sql .= " AND mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = " . (int)$data['second_year'];
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
    
    
    public function getdcpsAllDetailsForDeduction($data) { 
        //echo "<pre>"; print_r($data); exit;
        if(!empty($data)){
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
                        mst.is_deleted in (0, 3) and mst.emp_td > 0 " ;
        
            // Add conditions dynamically based on input
            if (isset($data['pay_center']) && $data['pay_center'] != "") {
                $sql .= " AND mst.`pay_center` = " . $data['pay_center'];
            }
        
            if (isset($data['emp_id']) && $data['emp_id'] != "") {
                $sql .= " AND mst.`emp_td` = " . (int)$data['emp_id'];
            }
            
            if (isset($data['voucher_date']) && $data['voucher_date'] != "") {
                $sql .= " AND mst.`recovered_DCPS_with_voucher_date` = " . $this->db->escape($data['voucher_date']);
            }
    
            if (isset($data['voucher_no']) && $data['voucher_no'] != "") {
                $sql .= " AND mst.`recovered_DCPS_with_voucher_no` = " . $this->db->escape($data['voucher_no']);
            }
            
        
            if (isset($data['from_month']) && $data['from_month'] != "" && isset($data['to_month']) && $data['to_month'] != "") {
                $sql .= " AND mst.`for_month` >= " . (int)$data['from_month'];
                $sql .= " AND mst.`for_month` <= " . (int)$data['to_month'];
            }
            else{
                if (isset($data['from_month']) && $data['from_month'] != "") {
                    $sql .= " AND mst.`for_month` = " . (int)$data['from_month'];
                }
                elseif (isset($data['to_month']) && $data['to_month'] != "") {
                    $sql .= " AND mst.`for_month` = " . (int)$data['to_month'];
                }
            }
        
            if (isset($data['first_year']) && $data['first_year'] != "" && isset($data['second_year']) && $data['second_year'] != "") {
                $sql .= " AND (
                    (mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = " . (int)$data['first_year'] . ") 
                    OR 
                    (mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = " . (int)$data['second_year'] . ")
                )";
            } elseif (isset($data['first_year']) && $data['first_year'] != "") {
                $sql .= " AND mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = " . (int)$data['first_year'];
            } elseif (isset($data['second_year']) && $data['second_year'] != "") {
                $sql .= " AND mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = " . (int)$data['second_year'];
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
    
    
    public function getdcpsAllDetailsForLedger($data) { 
        //echo "<pre>"; print_r($data); exit;
        if(!empty($data)){
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
                        mst.is_deleted in (0) and mst.emp_td > 0 " ;
        
            // Add conditions dynamically based on input
            if (isset($data['pay_center']) && $data['pay_center'] != "") {
                $sql .= " AND mst.`pay_center` = " . $data['pay_center'];
            }
        
            if (isset($data['emp_id']) && $data['emp_id'] != "") {
                $sql .= " AND mst.`emp_td` = " . (int)$data['emp_id'];
            }
            
            if (isset($data['voucher_date']) && $data['voucher_date'] != "") {
                $sql .= " AND mst.`recovered_DCPS_with_voucher_date` = " . $this->db->escape($data['voucher_date']);
            }
    
            if (isset($data['voucher_no']) && $data['voucher_no'] != "") {
                $sql .= " AND mst.`recovered_DCPS_with_voucher_no` = " . $this->db->escape($data['voucher_no']);
            }
            
        
            if (isset($data['from_month']) && $data['from_month'] != "" && isset($data['to_month']) && $data['to_month'] != "") {
                $sql .= " AND mst.`for_month` >= " . (int)$data['from_month'];
                $sql .= " AND mst.`for_month` <= " . (int)$data['to_month'];
            }
            else{
                if (isset($data['from_month']) && $data['from_month'] != "") {
                    $sql .= " AND mst.`for_month` = " . (int)$data['from_month'];
                }
                elseif (isset($data['to_month']) && $data['to_month'] != "") {
                    $sql .= " AND mst.`for_month` = " . (int)$data['to_month'];
                }
            }
        
            if (isset($data['first_year']) && $data['first_year'] != "" && isset($data['second_year']) && $data['second_year'] != "") {
                $sql .= " AND (
                    (mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = " . (int)$data['first_year'] . ") 
                    OR 
                    (mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = " . (int)$data['second_year'] . ")
                )";
            } elseif (isset($data['first_year']) && $data['first_year'] != "") {
                $sql .= " AND mst.`for_month` >= 4 AND mst.`for_month` <= 12 AND mst.`for_year` = " . (int)$data['first_year'];
            } elseif (isset($data['second_year']) && $data['second_year'] != "") {
                $sql .= " AND mst.`for_month` >= 1 AND mst.`for_month` <= 3 AND mst.`for_year` = " . (int)$data['second_year'];
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
            elseif ((isset($data['first_year']) && $data['first_year'] != "" && (!isset($data['from_month']) || $data['from_month'] == "" ) && (!isset($data['to_month']) || $data['to_month'] == "")) || (isset($data['second_year']) && $data['second_year'] != "" && (!isset($data['from_month']) || $data['from_month'] == "" ) && (!isset($data['to_month']) || $data['to_month'] == ""))) {
                $sql .= " ORDER BY (CASE WHEN MONTH(em.joining_date) >= 4 THEN MONTH(em.joining_date) - 3 ELSE MONTH(em.joining_date) + 9 END) ASC, em.joining_date ASC, mst.pay_center ASC, CAST(mst.emp_td AS UNSIGNED) ASC";
            }
            else {
                $sql .= " ORDER BY mst.pay_center ASC, CAST(mst.emp_td AS UNSIGNED) ASC";
            }
        
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

    public function getYearlyInterestNew($data = array()){
	    if($data['emp_id'] || $data['f_year']){
	        $this->db->select('*');
    		$this->db->from('yearly_interest');
    		if(isset($data['emp_id']) && $data['emp_id'] != ""){
    		    $this->db->where("employee_id", $data['emp_id']);
    		}
    		if(isset($data['f_year']) && $data['f_year'] != ""){
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

	public function getYearlyInterest($data = array()){
	    if($data['emp_id'] && $data['f_year']){
	        $this->db->select('*');
    		$this->db->from('yearly_interest');
    		if(isset($data['emp_id']) && $data['emp_id'] != ""){
    		    $this->db->where("employee_id", $data['emp_id']);
    		}
    		if(isset($data['f_year']) && $data['f_year'] != ""){
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
	
	public function getInterestRates($firstYear="", $secondYear=""){
	    $interestRateByMonths = array();
		$monthSql = "SELECT gr_month, gr_percentage FROM `dpt_gr_management` where  ((gr_month >= 4 && gr_month <= 12 and gr_year =".$firstYear.") or (gr_month >= 1 && gr_month <= 3 and gr_year =".$secondYear."))";
		//echo $monthSql; exit;
		$query = $this->db->query($monthSql);
		//echo $this->db->last_query(); exit;
		if($query){
			//echo "<pre>"; print_r($query->result()); exit;
			foreach($query->result() as $mresult){
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

		$firstYear = isset($data['first_year']) ? (int)$data['first_year'] : (isset($data['year']) ? (int)$data['year'] : 0);
		if (!$firstYear) {
			return array();
		}
		$secondYear = isset($data['second_year']) ? (int)$data['second_year'] : ($firstYear + 1);
		$fYear = $firstYear . "-" . $secondYear;

		$monthsOrder = array(4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3);

		$rates = $this->getInterestRates($firstYear, $secondYear);
		if (!is_array($rates)) {
			$rates = array();
		}

		// IMPORTANT:
		// Do NOT use grouped/monthly-summed data here, because duplicates (multiple records
		// for same emp + month) must be shown separately (Deduction Report behavior).
		$dcpsRows = $this->getdcpsAllDetailsForLedger($data);
		$byEmpMonth = array(); // [empId][month] => [row,row,...]
		$empIds = array();
		if (is_array($dcpsRows)) {
			foreach ($dcpsRows as $r) {
				$empId = (int)$r['emp_td'];
				$m = (int)$r['for_month'];
				if (!isset($byEmpMonth[$empId][$m])) {
					$byEmpMonth[$empId][$m] = array();
				}
				$byEmpMonth[$empId][$m][] = $r;
				$empIds[$empId] = true;
			}
		}
		$empIds = array_keys($empIds);

		// Opening balance (सुरवातीची शिल्लक) computed at runtime as previous FY closing.
		$openingByEmp = array();
		foreach ($empIds as $empId) {
			$openingByEmp[$empId] = (float)$this->getFinalLedgerOpeningBalanceRuntime($empId, $firstYear);
		}

		$out = array();
		foreach ($empIds as $empId) {
			$opening = isset($openingByEmp[$empId]) ? (float)$openingByEmp[$empId] : 0.0;

			// ===== DEBUG: cumulative rows - emp start =====
			$_dbg_model_log = APPPATH . 'logs/final_ledger_model_debug.txt';
			file_put_contents($_dbg_model_log,
				"\n" . str_repeat('*', 80) . "\n" .
				"[MODEL-CUMUL] getFinalLedgerCumulativeRows  FY: {$fYear}  EmpId: {$empId}" .
				"  Current Year Opening (from previous FY closing): {$opening}\n" .
				str_repeat('*', 80) . "\n",
				FILE_APPEND
			);
			// ===== END DEBUG =====

			$empBase = $opening;
			$nmcBase = $opening;
			$totalBase = $opening;

			$totals = array(
				'emp_regular' => 0.0,
				'emp_supp' => 0.0,
				'nmc_regular' => 0.0,
				'nmc_supp' => 0.0,
				'loan_installment' => 0.0,
				'total_deposit' => 0.0,
				'loan_taken' => 0.0,
				'emp_interest' => 0.0,
				'nmc_interest' => 0.0,
				'total_interest' => 0.0,
			);

			$rows = array();
			foreach ($monthsOrder as $m) {
				$monthRecords = isset($byEmpMonth[$empId][$m]) ? $byEmpMonth[$empId][$m] : array();

				// Sort duplicates consistently so bases are predictable.
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
						$vnA = isset($a['recovered_DCPS_with_voucher_no']) ? (string)$a['recovered_DCPS_with_voucher_no'] : '';
						$vnB = isset($b['recovered_DCPS_with_voucher_no']) ? (string)$b['recovered_DCPS_with_voucher_no'] : '';
						if ($vnA !== $vnB) {
							return $vnA <=> $vnB;
						}
						$fnA = isset($a['file_no']) ? (string)$a['file_no'] : '';
						$fnB = isset($b['file_no']) ? (string)$b['file_no'] : '';
						return $fnA <=> $fnB;
					});
				}

				// If there are no records, still keep a placeholder month row (all zeros)
				// to preserve report shape.
				if (empty($monthRecords)) {
					$monthRecords = array(array());
				}

				$rate = isset($rates[$m]) ? (float)$rates[$m] : 0.0;
				$yearForMonth = ($m >= 4 && $m <= 12) ? $firstYear : $secondYear;

				// Build rows for this month: contributions updated sequentially on bases,
				// then ONE monthly interest on month-end base is split across duplicate rows
				// so each row shows interest while totals stay mathematically correct.
				$pendingRows = array();
				foreach ($monthRecords as $r) {
					$salaryType = isset($r['salary_type']) ? (string)$r['salary_type'] : '';
					$ideal = isset($r['Ideal_contribution_of_employee_for_DCPS']) && $r['Ideal_contribution_of_employee_for_DCPS'] !== ''
						? (float)$r['Ideal_contribution_of_employee_for_DCPS']
						: 0.0;

					// Match legacy behavior: when actual recovered contribution fields are empty,
					// fall back to Ideal contribution for display/calculation.
					$empRegular = 0.0;
					$empSupp = 0.0;
					$nmcRegular = 0.0;
					$nmcSupp = 0.0;
					if ($salaryType === 'Regular') {
						$empRegular = (!empty($r['emp_DCPS_contribution']) ? (float)$r['emp_DCPS_contribution'] : $ideal);
						$nmcRegular = (!empty($r['NMC_DCPS_contribution']) ? (float)$r['NMC_DCPS_contribution'] : $ideal);
					} elseif ($salaryType === 'Suplimentory') {
						$empSupp = (!empty($r['emp_DCPS_supplimentory_contribution']) ? (float)$r['emp_DCPS_supplimentory_contribution'] : $ideal);
						$nmcSupp = (!empty($r['NMC_supplimentory_DCPS_contribution']) ? (float)$r['NMC_supplimentory_DCPS_contribution'] : $ideal);
					}

					$loanInstallment = !empty($r['loan_installment_paid_through_salary']) ? (float)$r['loan_installment_paid_through_salary'] : 0.0;
					$loanTaken = !empty($r['DCPS_loan_taken_by_an_employee']) ? (float)$r['DCPS_loan_taken_by_an_employee'] : 0.0;

					$totalDeposit = ($empRegular + $empSupp + $loanInstallment) + ($nmcRegular + $nmcSupp);
					
					//echo "Before empbase=>".$empBase;

					$empBase = ($empBase + $empRegular + $empSupp + $loanInstallment) - $loanTaken;
					//echo "<br/>After empBase=>".$empBase.", empRegular=>".$empRegular.", empSupp=>".$empSupp.", loanInstallment=>".$loanInstallment;
					$nmcBase = ($nmcBase + $nmcRegular + $nmcSupp);
					$totalBase = ($totalBase + $totalDeposit) - $loanTaken;

					$pendingRows[] = array(
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
				}

				$monthEmpInterest = round((($empBase * $rate) / 100) / 12, 0);
				$monthNmcInterest = round((($nmcBase * $rate) / 100) / 12, 0);
				$rowCount = count($pendingRows);
				$empIntParts = $this->_splitIntegerAcrossRows($monthEmpInterest, $rowCount);
				$nmcIntParts = $this->_splitIntegerAcrossRows($monthNmcInterest, $rowCount);

				// ===== DEBUG: per-month in getCumulativeRows =====
				$_dbg_month_names_cr = array(1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',
					7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December');
				$_dbg_month_label_cr = isset($_dbg_month_names_cr[$m]) ? $_dbg_month_names_cr[$m] : $m;
				// Gather month-level totals from pendingRows for the log
				$_dbg_empReg=0; $_dbg_empSup=0; $_dbg_nmcReg=0; $_dbg_nmcSup=0;
				$_dbg_loanInst=0; $_dbg_loanTaken=0;
				foreach ($pendingRows as $_pr) {
					$_dbg_empReg    += (float)$_pr['emp_regular'];
					$_dbg_empSup    += (float)$_pr['emp_supp'];
					$_dbg_nmcReg    += (float)$_pr['nmc_regular'];
					$_dbg_nmcSup    += (float)$_pr['nmc_supp'];
					$_dbg_loanInst  += (float)$_pr['loan_installment'];
					$_dbg_loanTaken += (float)$_pr['loan_taken'];
				}
				$_dbg_monthly_closing_cr = $empBase + $nmcBase;
				file_put_contents($_dbg_model_log,
					"[MODEL-CUMUL] FY: {$fYear}  EmpId: {$empId}  Month: {$_dbg_month_label_cr} ({$m})" .
					"  Opening(FY): {$opening}" .
					"  Emp Regular: {$_dbg_empReg}" .
					"  Emp Supp: {$_dbg_empSup}" .
					"  NMC Regular: {$_dbg_nmcReg}" .
					"  NMC Supp: {$_dbg_nmcSup}" .
					"  Loan Installment: {$_dbg_loanInst}" .
					"  Loan Taken: {$_dbg_loanTaken}" .
					"  Rate: {$rate}" .
					"  Emp Base (month-end): {$empBase}" .
					"  NMC Base (month-end): {$nmcBase}" .
					"  Emp Interest: {$monthEmpInterest}" .
					"  NMC Interest: {$monthNmcInterest}" .
					"  Monthly Closing (EmpBase+NmcBase): {$_dbg_monthly_closing_cr}\n",
					FILE_APPEND
				);
				// ===== END DEBUG =====

				foreach ($pendingRows as $i => $prow) {
					$ei = isset($empIntParts[$i]) ? $empIntParts[$i] : 0;
					$ni = isset($nmcIntParts[$i]) ? $nmcIntParts[$i] : 0;
					$prow['emp_interest'] = $monthEmpInterest;
					$prow['nmc_interest'] = $monthNmcInterest;
					$prow['total_interest'] = $monthEmpInterest + $monthNmcInterest;
					$prow['rate'] = $rate;
					$rows[] = $prow;
					
					$totals['emp_interest'] += $monthEmpInterest;
    				$totals['nmc_interest'] += $monthNmcInterest;
    				$totals['total_interest'] += ($monthEmpInterest + $monthNmcInterest);
				}

				
			}

			$out[$empId] = array(
				'f_year' => $fYear,
				'opening_balance' => $opening,
				'rows' => $rows,
				'totals' => $totals,
			);

			// ===== DEBUG: cumulative rows - emp final closing =====
			$_dbg_closing_cr = ($opening + ($totals['emp_regular']+$totals['emp_supp']+$totals['loan_installment']) + ($totals['nmc_regular']+$totals['nmc_supp'])) - $totals['loan_taken'] + $totals['total_interest'];
			file_put_contents($_dbg_model_log,
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
			);
			// ===== END DEBUG =====
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
		$empId = (int)$empId;
		$firstYear = (int)$firstYear;

		if ($empId <= 0 || $firstYear <= 2005) {
			return 0.0;
		}

		static $closingCache = array(); // [empId][fyStart] => closing

		$targetFYStart = $firstYear - 1;
		if (isset($closingCache[$empId][$targetFYStart])) {
			return (float)$closingCache[$empId][$targetFYStart];
		}

		$opening = 0.0;
		for ($fy = 2005; $fy <= $targetFYStart; $fy++) {
			if (isset($closingCache[$empId][$fy])) {
				$opening = (float)$closingCache[$empId][$fy];
				continue;
			}
            if($fy < 2008){
                //continue;
            }
			$closing = $this->_finalLedgerComputeClosingForFY($empId, $fy, $opening);
			
			//echo "<br/>empId=>".$empId.", firstYear=>".$fy.", Opening=>".$opening.", closing=>".$closing;
			
			$closingCache[$empId][$fy] = $closing;
			$opening = $closing;
		}

		return (float)$opening;
	}

	/**
	 * Split an integer total across N displayed rows; returned integers sum exactly to $total.
	 * Used so duplicate month-rows each show a share of that month's interest.
	 */
	private function _splitIntegerAcrossRows($total, $n)
	{
		$total = (int) round((float) $total);
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
	private function _finalLedgerComputeClosingForFY($empId, $fyStart, $opening)
	{
		$empId = (int)$empId;
		$fyStart = (int)$fyStart;
		$opening = (float)$opening;
		//echo "<br/>fystart=>".$fyStart;

		// ===== DEBUG: model FY start =====
		$_dbg_model_log = APPPATH . 'logs/final_ledger_model_debug.txt';
		$_dbg_fy_label  = $fyStart . '-' . ($fyStart + 1);
		file_put_contents($_dbg_model_log,
			"\n" . str_repeat('=', 80) . "\n" .
			"[MODEL] FY: {$_dbg_fy_label}  EmpId: {$empId}  Previous Year Closing / Current Year Opening: {$opening}\n" .
			str_repeat('-', 80) . "\n",
			FILE_APPEND
		);
		// ===== END DEBUG =====

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

		// Use ungrouped rows so duplicates contribute to closing properly.
		$dcpsRows = $this->getdcpsAllDetailsForLedger($data);
		//echo "<br>".$opening; 
		//echo "<br/><pre>"; print_R($dcpsRows); //exit;
		$byMonth = array(); // [month] => list of rows
		if (is_array($dcpsRows)) {
			foreach ($dcpsRows as $r) {
				$m = (int)$r['for_month'];
				if (!isset($byMonth[$m])) {
					$byMonth[$m] = array();
				}
				$byMonth[$m][] = $r;
			}
		}
		//echo "<br/><pre>By Month=>"; print_r($byMonth);

		$empBase = $opening;
		$nmcBase = $opening;

		$sumEmp = 0.0;
		$sumEmpSupp = 0.0;
		$sumNmc = 0.0;
		$sumNmcSupp = 0.0;
		$sumLoanInst = 0.0;
		$sumLoanTaken = 0.0;
		$sumInterest = 0.0;

		foreach ($monthsOrder as $m) {
			$monthRecords = isset($byMonth[$m]) ? $byMonth[$m] : array();
			$empRegular = 0.0;
			$empSupp = 0.0;
			$nmcRegular = 0.0;
			$nmcSupp = 0.0;
			$loanInstallment = 0.0;
			$loanTaken = 0.0;
			
			//echo "<br/><pre>"; print_r($monthRecords); 
            $rate = isset($rates[$m]) ? (float)$rates[$m] : 0.0;
			if (!empty($monthRecords)) {
				foreach ($monthRecords as $r) {
					$salaryType = isset($r['salary_type']) ? (string)$r['salary_type'] : '';
					$ideal = isset($r['Ideal_contribution_of_employee_for_DCPS']) && $r['Ideal_contribution_of_employee_for_DCPS'] !== ''
						? (float)$r['Ideal_contribution_of_employee_for_DCPS']
						: 0.0;
					if ($salaryType === 'Regular') {
						$empRegular += !empty($r['emp_DCPS_contribution']) ? (float)$r['emp_DCPS_contribution'] : $ideal;
						$nmcRegular += !empty($r['NMC_DCPS_contribution']) ? (float)$r['NMC_DCPS_contribution'] : $ideal;
					} elseif ($salaryType === 'Suplimentory') {
						$empSupp += !empty($r['emp_DCPS_supplimentory_contribution']) ? (float)$r['emp_DCPS_supplimentory_contribution'] : $ideal;
						$nmcSupp += !empty($r['NMC_supplimentory_DCPS_contribution']) ? (float)$r['NMC_supplimentory_DCPS_contribution'] : $ideal;
					}
					$loanInstallment += !empty($r['loan_installment_paid_through_salary']) ? (float)$r['loan_installment_paid_through_salary'] : 0.0;
					$loanTaken += !empty($r['DCPS_loan_taken_by_an_employee']) ? (float)$r['DCPS_loan_taken_by_an_employee'] : 0.0;
					
					$empBase = ($empBase + $empRegular + $empSupp + $loanInstallment) - $loanTaken;
        	        $nmcBase = ($nmcBase + $nmcRegular + $nmcSupp);
        	        
        	        
        			$empInterest = round((($empBase * $rate) / 100) / 12, 0);
        			$nmcInterest = round((($nmcBase * $rate) / 100) / 12, 0);
			        
				}
			}

			// ===== DEBUG: per-month log inside _finalLedgerComputeClosingForFY =====
			$_dbg_month_names = array(1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',
				7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December');
			$_dbg_month_label  = isset($_dbg_month_names[$m]) ? $_dbg_month_names[$m] : $m;
			$_dbg_monthly_closing = ($empBase + $nmcBase); // emp+nmc bases at month end (before interest)
			file_put_contents($_dbg_model_log,
				"[MODEL-COMPUTE] FY: {$_dbg_fy_label}  Month: {$_dbg_month_label} ({$m})" .
				"  Opening(FY): {$opening}" .
				"  Emp Regular: {$empRegular}" .
				"  Emp Supp: {$empSupp}" .
				"  NMC Regular: {$nmcRegular}" .
				"  NMC Supp: {$nmcSupp}" .
				"  Loan Installment: {$loanInstallment}" .
				"  Loan Taken: {$loanTaken}" .
				"  Rate: {$rate}" .
				"  Emp Base: {$empBase}" .
				"  NMC Base: {$nmcBase}" .
				"  Emp Interest: {$empInterest}" .
				"  NMC Interest: {$nmcInterest}" .
				"  Monthly Closing (EmpBase+NmcBase): {$_dbg_monthly_closing}\n",
				FILE_APPEND
			);
			// ===== END DEBUG =====

			
			$sumInterest += ($empInterest + $nmcInterest);		
			//echo "<pre>EmpBase=>".$empBase;

			
			

			$sumEmp += $empRegular;
			$sumEmpSupp += $empSupp;
			$sumNmc += $nmcRegular;
			$sumNmcSupp += $nmcSupp;
			$sumLoanInst += $loanInstallment;
			$sumLoanTaken += $loanTaken;
		}

		$closing = ($opening + ($sumEmp + $sumEmpSupp + $sumLoanInst) + ($sumNmc + $sumNmcSupp)+$sumInterest) - $sumLoanTaken;

		// ===== DEBUG: FY closing summary =====
		file_put_contents($_dbg_model_log,
			"[MODEL-COMPUTE] FY: {$_dbg_fy_label}  EmpId: {$empId}" .
			"  Sum Emp: {$sumEmp}  Sum EmpSupp: {$sumEmpSupp}  Sum NMC: {$sumNmc}  Sum NMCSupp: {$sumNmcSupp}" .
			"  Sum LoanInst: {$sumLoanInst}  Sum LoanTaken: {$sumLoanTaken}  Sum Interest: {$sumInterest}" .
			"  Opening: {$opening}  >>> FINAL CLOSING: {$closing}\n" .
			str_repeat('-', 80) . "\n",
			FILE_APPEND
		);
		// ===== END DEBUG =====

		return (float)$closing;
	}


    
       
}
?>