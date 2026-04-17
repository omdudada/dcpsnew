<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class HomeModel extends CI_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getAllData(){
	    $this->db->select("count(*) as total_hospital, sum(mb.hospital_total_beds) as total_beds, sum(mb.hospital_nmc_beds_reserverd) as nmc_reserved, sum(mb.ventilator_beds) as total_ventilator_beds, sum(mb.ICU_beds) as total_ICU_beds, sum(mb.oxygen_beds) as total_oxygen_beds, sum(mb.general_beds) as total_general_beds, sum(hl.vacant_ventilator_beds) as total_vacant_ventilator_beds, sum(hl.vacant_ICU_beds) as total_vacant_ICU_beds, sum(hl.vacant_oxygen_beds) as total_vacant_oxygen_beds, sum(hl.vacant_general_beds) as total_vacant_general_beds", false);
		$this->db->from('master_bed_status as mb');
		$this->db->join('hospital_list as hl', 'hl.id = mb.id');
		//$this->db->join('division as dv', 'dv.id = mb.division_id');
		$query = $this->db->get();
		// echo $this->db->last_query();die();
		if ($query) {
			return $query->row_array();
		}
		return false;
	}

	public function getHospitalAllData(){
	    $this->db->select('mb.id,mb.hospital_address,mb.name_of_the_contact_person,mb.hospital_mobile_number,mb.contanct_land_line_number,mb.hospital_name,mb.ccc,mb.hospital_total_beds,mb.ventilator_beds,mb.ICU_beds,mb.oxygen_beds,mb.hospital_nmc_beds_reserverd,dv.division,mb.general_beds,mb.hospital_category,mb.je_eng_name,mb.je_eng_mobile_number1,hl.vacant_ventilator_beds,hl.vacant_ICU_beds,hl.vacant_oxygen_beds,hl.vacant_general_beds');
		$this->db->from('master_bed_status as mb');
		$this->db->join('hospital_list as hl', 'hl.id = mb.id');
		$this->db->join('division as dv', 'dv.id = mb.division_id');
		$this->db->order_by("mb.ccc", "desc");
		$query = $this->db->get();
		// echo $this->db->last_query();die();
		if ($query) {
			return $query->result_array();
		}
		return false;
	}

	public function getTotalCountOfHospitalList(){
		
		$this->db->select("

			sum(CASE WHEN hl.CCC = 'CCC(Govt.)' THEN hl.nmc_beds_reserverd ELSE 0 END) as total_nmc_ccc_govt,
			sum(CASE WHEN hl.CCC = 'CCC' THEN hl.nmc_beds_reserverd ELSE 0 END) as total_nmc_ccc,
			sum(CASE WHEN hl.CCC = 'DCHC(Govt.)' THEN hl.nmc_beds_reserverd ELSE 0 END) as total_nmc_dchc_govt,
			sum(CASE WHEN hl.CCC = 'DCHC' THEN hl.nmc_beds_reserverd ELSE 0 END) as total_nmc_dchc,
			sum(CASE WHEN hl.CCC = 'DCH(Govt.)' THEN hl.nmc_beds_reserverd ELSE 0 END) as total_nmc_dch_govt,
			sum(CASE WHEN hl.CCC = 'DCH' THEN hl.nmc_beds_reserverd ELSE 0 END) as total_nmc_dch,

			sum(CASE WHEN hl.CCC = 'CCC(Govt.)' THEN hl.vacant_ventilator_beds ELSE 0 END) as vacant_venti_ccc_govt,
			sum(CASE WHEN hl.CCC = 'CCC' THEN hl.vacant_ventilator_beds ELSE 0 END) as vacant_venti_ccc,
			sum(CASE WHEN hl.CCC = 'CCC(Govt.)' THEN hl.vacant_ICU_beds ELSE 0 END) as vacant_icu_ccc_govt,
			sum(CASE WHEN hl.CCC = 'CCC' THEN hl.vacant_ICU_beds ELSE 0 END) as vacant_icu_ccc,
			sum(CASE WHEN hl.CCC = 'CCC(Govt.)' THEN hl.vacant_oxygen_beds ELSE 0 END) as vacant_oxygen_ccc_govt,
			sum(CASE WHEN hl.CCC = 'CCC' THEN hl.vacant_oxygen_beds ELSE 0 END) as vacant_oxygen_ccc,
			sum(CASE WHEN hl.CCC = 'CCC(Govt.)' THEN hl.vacant_general_beds ELSE 0 END) as vacant_general_ccc_govt,
			sum(CASE WHEN hl.CCC = 'CCC' THEN hl.vacant_general_beds ELSE 0 END) as vacant_general_ccc,

			sum(CASE WHEN hl.CCC = 'DCHC(Govt.)' THEN hl.vacant_ventilator_beds ELSE 0 END) as vacant_venti_DCHC_govt,
			sum(CASE WHEN hl.CCC = 'DCHC' THEN hl.vacant_ventilator_beds ELSE 0 END) as vacant_venti_DCHC,
			sum(CASE WHEN hl.CCC = 'DCHC(Govt.)' THEN hl.vacant_ICU_beds ELSE 0 END) as vacant_icu_DCHC_govt,
			sum(CASE WHEN hl.CCC = 'DCHC' THEN hl.vacant_ICU_beds ELSE 0 END) as vacant_icu_DCHC,
			sum(CASE WHEN hl.CCC = 'DCHC(Govt.)' THEN hl.vacant_oxygen_beds ELSE 0 END) as vacant_oxygen_DCHC_govt,
			sum(CASE WHEN hl.CCC = 'DCHC' THEN hl.vacant_oxygen_beds ELSE 0 END) as vacant_oxygen_DCHC,
			sum(CASE WHEN hl.CCC = 'DCHC(Govt.)' THEN hl.vacant_general_beds ELSE 0 END) as vacant_general_DCHC_govt,
			sum(CASE WHEN hl.CCC = 'DCHC' THEN hl.vacant_general_beds ELSE 0 END) as vacant_general_DCHC,

			sum(CASE WHEN hl.CCC = 'DCH(Govt.)' THEN hl.vacant_ventilator_beds ELSE 0 END) as vacant_venti_DCH_govt,
			sum(CASE WHEN hl.CCC = 'DCH' THEN hl.vacant_ventilator_beds ELSE 0 END) as vacant_venti_DCH,
			sum(CASE WHEN hl.CCC = 'DCH(Govt.)' THEN hl.vacant_ICU_beds ELSE 0 END) as vacant_icu_DCH_govt,
			sum(CASE WHEN hl.CCC = 'DCH' THEN hl.vacant_ICU_beds ELSE 0 END) as vacant_icu_DCH,
			sum(CASE WHEN hl.CCC = 'DCH(Govt.)' THEN hl.vacant_oxygen_beds ELSE 0 END) as vacant_oxygen_DCH_govt,
			sum(CASE WHEN hl.CCC = 'DCH' THEN hl.vacant_oxygen_beds ELSE 0 END) as vacant_oxygen_DCH,
			sum(CASE WHEN hl.CCC = 'DCH(Govt.)' THEN hl.vacant_general_beds ELSE 0 END) as vacant_general_DCH_govt,
			sum(CASE WHEN hl.CCC = 'DCH' THEN hl.vacant_general_beds ELSE 0 END) as vacant_general_DCH,


			");
		$this->db->from('hospital_list as hl');
		
		//$this->db->group_by('hl.CCC');
		
		$query = $this->db->get();
		// echo $this->db->last_query();die();
		if ($query) {
			return $query->row_array();
		}
		return false;
	}

}

?>