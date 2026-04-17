<?php if(!defined('BASEPATH')) exit("No direct script access allowed");
	
class SettingModel extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		//$this->db = $this->load->database(($this->session->userdata('dbName'))?$this->session->userdata('dbName'):'tax', TRUE);
		//echo "<pre>"; print_r($this->db); exit;
		$this->_name = "settings";
	}
	
	public function getRecordsFrom($tableName, $filter= array()){
		if($tableName == 'collectioncenters'){
			$this->db->select('id as key, name as val');
			$as = '';
		}
		else if($tableName == 'adminusers'){
			$as = ' as t1';
			$this->db->select('t1.*, t2.name as collectioncenter_name, t3.zone as zone_name');
		}
		else {
			$as = '';
			$this->db->select('*');
		}
		$this->db->from($tableName.$as);
		if($tableName == 'adminusers'){
			$this->db->join('collectioncenters as t2', 't2.id = t1.collection_center', 'left');
			$this->db->join('zone as t3', 't3.id = t1.zone_id', 'left');
		}
		if($filter){
			$this->db->where($filter);
		}
		if($tableName == 'collectioncenters'){
			$this->db->order_by('name', 'asc');
		}
		$query= $this->db->get();
		//echo $this->db->last_query();exit;
		if($query->num_rows() > 0){
			return $query->result();
		}
		return false;
	}
	
	public function getSettings($filter){
		$this->db->select('value as '.$filter);
		$this->db->from($this->_name);
		$this->db->where('name', $filter);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		if($query->num_rows() > 0){
			return $query->row();
		}
		return 0;
	}
	
	public function updateSettings($filter){
		$rows['value'] = $filter['formData']; 
		$this->db->where('name', $filter['name']);
		$this->db->update($this->_name, $rows);
		if($this->db->affected_rows()){
			return true;
		}
		else {
			return false;
		}
	}
	
	public function create($data){
		$this->db->insert('adminusers', $data);
		$id = $this->db->insert_id();
		if($id){
			return $id;
		}
		else {
			return false;
		}
	}
	
	public function getTotalRows($filter= array()){
		$this->db->select('count(au.id) as cnt', false);
		$this->db->from('adminusers as au');
		$this->db->join('zone as z', 'z.id = au.zone_id', 'left');
		//echo '<pre>';print_r($data);echo '</pre>';exit;
		if($filter){
			if($filter["holder_name"]!=""){
				$this->db->where("au.name LIKE '%".trim($filter["holder_name"])."%'");
			}
			elseif($filter["zone_name"]!=""){
				$this->db->where("au.zone_id",$filter["zone_name"]);
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if($query->num_rows() > 0){
			return $query->row()->cnt;
		}
		return 0;
	}
	
	public function getUsersDetails($limit, $start, $filter= array(),$id=''){
		$this->db->select('au.*, z.zone as zone_name');
		$this->db->from('adminusers as au');
		$this->db->join('zone as z', 'z.id = au.zone_id', 'left');
		if($id!=''){
			$this->db->where('au.id', $id);
			$query = $this->db->order_by('au.id', 'asc');
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			if($query->num_rows() > 0){
				return $query->row();
			}
		}
		else {
			//echo '<pre>';print_r($filter);echo '</pre>';exit;
			if($filter["holder_name"]!=""){
				$this->db->where("au.name LIKE '%".trim($filter["holder_name"])."%'");
			}
			elseif($filter["zone_name"]!=""){
				$this->db->where("au.zone_id",$filter["zone_name"]);
			}
			if($limit){
				$this->db->limit($limit, $start);
			}
			$query = $this->db->order_by('au.id', 'desc');
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			if($query->num_rows() > 0){
				return $query->result();
			}
		}
		return 0;
	}
	
	public function update_user($data, $id){
		$this->db->where('id', $id);
		$this->db->update('adminusers',$data);
		//echo $this->db->last_query();exit;
		if($this->db->affected_rows()){
			return true;
		}
		else {
			return false;
		}
	}
	
	public function updateUserActiveStatus($tableName, $updateArray=array(), $filter=array()){
		if($filter){
			$this->db->where($filter);
		}
		$this->db->update($tableName, $updateArray);
		//echo $this->db->last_query();exit;
		if($this->db->affected_rows() > 0){
			return 1;
		}
		else {
			return 0;
		}
	}
	
	public function removeUser($tableName, $filter=array()){
		if($filter){
			$this->db->where($filter);
		}
		$res = $this->db->delete($tableName);
		//echo $this->db->last_query();exit;
		if($res){
			return 1;
		}
		else {
			return 0;
		}
	}
	
	public function getUserInfo($tableName, $filter=array()){
		$this->db->select('*');
		$this->db->from($tableName);
		if($filter){
			$this->db->where($filter);
		}
		$query= $this->db->get();
		//echo $this->db->last_query();exit;
		if($query->num_rows() > 0){
			return $query->row();
		}
		return false;
	}
	public function getUserInfoNew($tableName, $filter=array()){
		$this->db->select('*');
		$this->db->from($tableName);
		if($filter){
			$this->db->where($filter);
		}
		$query= $this->db->get();
		//echo $this->db->last_query();exit;
		if($query->num_rows() > 0){
			return $query->result();
		}
		return false;
	}
	
	public function getUserInfoWithPermissionsNew($tableName, $filter=array()){
		$this->db->select('ua.*');
		$this->db->from($tableName.' as ua');
		$this->db->join('adminusers as au', 'au.id = ua.user_id', 'left');
		$this->db->join('controller as co', 'co.id = ua.controller_id', 'left');
		$this->db->join('action as ac', 'ac.controller_id = co.id', 'inner');
		if($filter){
			$this->db->where($filter);
		}
		$query= $this->db->get();
		//echo $this->db->last_query();exit;
		if($query->num_rows() > 0){
			return $query->result();
		}
		return false;
	}
	
	public function checkAccess($cName, $aName, $uId){ 
		// echo "cName=>".$cName.", aName=>".$aName.", uId=>".$uId; exit;
		if($uId && $cName !="login"){
			# Code to get the controller and action id from controller and action table.
			list($cId, $aId, $aPermission) = $this->getContActionIds($cName, $aName);
			 //echo $cId, $aId; exit;
			if($cId && $aId){ 
				$this->db->select('au.id');
				$this->db->from('adminuser as au');
				if($aPermission){
					$this->db->join('useraccess as ua', 'ua.user_id = au.id', 'inner');
					$this->db->where('ua.controller_id=', $cId);
					$this->db->where("find_in_set(".$aId.", ua.action)", null, false);
				}
				$this->db->where('au.id=', $uId);
				
				$query= $this->db->get();
				//echo $this->db->last_query();exit;
				if($query->num_rows() > 0){
					return 1;
				}
				return 0;
			}
			return 0;
		}
		else{
			# Code for allowed user to login.
			return 1;
		}
	}
	
	public function getContActionIds($cName, $aName){
		if($cName && $aName){
			$this->db->select('co.id as cId, ac.id as aId, ac.is_permission as aPermission');
			$this->db->from('controller as co');
			$this->db->join('action as ac', 'ac.controller_id = co.id', 'inner');
			$this->db->where('co.controller_name=', $cName);
			$this->db->where('ac.action_name=', $aName);
			$query= $this->db->get();
			// echo $this->db->last_query();exit;
			if($query->num_rows() > 0){
				$result = $query->row();
				return array($result->cId,$result->aId,$result->aPermission);
			}
			return 0;
		}
		else{
			return 0;
		}
	}
	
	public function getUserInfoWithPermissions($tableName, $filter=array()){
		$this->db->select('ua.*');
		$this->db->from($tableName.' as ua');
		$this->db->join('adminusers as au', 'au.id = ua.user_id', 'left');
		if($filter){
			$this->db->where($filter);
		}
		$query= $this->db->get();
		//echo $this->db->last_query();exit;
		if($query->num_rows() > 0){
			return $query->result();
		}
		return false;
	}
	
	public function getMenuDetails($tableName){
		$this->db->select('*');
		$this->db->from($tableName);
		$query= $this->db->get();
		$result = $query->result();
		
		$this->db->select('*');
		$this->db->from('action');
		$query1 = $this->db->get();
		$result1 = $query1->result();
		
		//echo '<pre>';print_r($result1);echo '</pre>';exit;
		//echo $this->db->last_query();exit;
		if($query->num_rows() > 0){
			return array("controllers" => $result, "actions" => $result1);
		}
		return false;
	}
	
	public function insertUserAccess($tableName, $insertArray){
		$this->db->insert($tableName, $insertArray);
		//echo $this->db->last_query();exit;
		$res = $this->db->insert_id();
		if($res){
			return $res;
		}
		else {
			return 0;
		}
	}
	
	public function updateUserAccess($tableName, $updateArray, $filter=array()){
		if($filter){
			$this->db->where($filter);
		}
		$this->db->update($tableName, $updateArray);
		//echo $this->db->last_query();exit;
		if($this->db->affected_rows() > 0){
			return 1;
		}
		else {
			return 0;
		}
	}
	
	public function deleteUserAccess($tableName, $filter=array()){
		if($filter){
			$this->db->where($filter);
		}
		$res = $this->db->delete($tableName);
		//echo $this->db->last_query();exit;
		if($res){
			return true;
		}
		else {
			return false;
		}
	}
}