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
	   $sql = "SELECT mst.`emp_td`, em.emp_name, em.joining_date, em.pay_center, em.fixed_pay,
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
                        em.joining_date, 
                        mst.pay_center, 
                        em.fixed_pay,
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

}
?>