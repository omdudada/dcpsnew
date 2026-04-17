<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('getMenuDetails')){
		function getMenuDetails(){
			$CI =& get_instance();	
			//$CI->db = $CI->load->database(($CI->session->userdata('dbName'))?$CI->session->userdata('dbName'):'tax', TRUE);
			//echo "<pre>"; print_r($CI->db); exit;
			$CI->db->select("co.id as cId, ac.id as aId, co.route_url as cRouteUrl, ac.route_url as aRouteUrl, co.is_menu as cMenu, co.is_master as cMaster, ac.is_menu as aMenu,controller_value, controller_name, co.order_no, action_name, action_value, is_permission");
			$CI->db->from('controller as co');
			$CI->db->where('ac.is_menu',1);
			$CI->db->where('co.is_menu',1);
			$CI->db->join('action as ac', 'ac.controller_id = co.id', 'left');
			$CI->db->group_by('ac.id');
			$CI->db->order_by('co.order_no', 'asc');
			$CI->db->order_by('ac.order_no', 'asc');
			$query=$CI->db->get();
			//echo $CI->db->last_query(); exit;
			$results = $query->result();
			//echo "<pre>"; print_r($results); exit;
			$menuAry = array(); $cnt =0; $cId="";
			foreach($results as $result){
				//echo "<br>".$cnt."=>".$result->controller_value."=>".count($menuAry);
				if($cId != $result->cId &&  !$result->cMaster){
					$cnt++;
				}
				if($cnt > 9){
					$menuAry["More Link"][$result->controller_value][] = $result;
				}
				else{
					if(!$result->is_permission){
						if($result->cMaster){
							$menuAry["Master"][$result->controller_value] = $result;
						}
						else{
							$menuAry[$result->controller_value][] = $result;
						}
					}
					else{
						$res = checkAccess($result->cId, $result->aId, $CI->session->userdata('id'));
						if($res){
							if($result->cMaster){
								$menuAry["Master"][$result->controller_value][] = $result;
							}
							else{
								$menuAry[$result->controller_value][] = $result;
							}
						}
					}
				}
				$cId = $result->cId;
			}	
			//echo "<pre>"; print_r($menuAry); exit;
			return $menuAry ;
		}
	}
	
	if(! function_exists('getPaginationLinks')){
		function getPaginationLinks($baseUrl="",$totalRows="",$perPage="",$uriSegment=""){
			$CI =& get_instance();
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = '</ul>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
			$config['prev_tag_open'] = '<li title="Previous">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '<i class="fa fa-angle-right"></i>';
			$config['next_tag_open'] = '<li title="Next">';
			$config['next_tag_close'] = '</li>';
			
			
			$config['base_url'] = ($baseUrl)?$baseUrl:"";
			$config['total_rows'] = ($totalRows)?$totalRows:0;
			$config['uri_segment'] = ($uriSegment)?$uriSegment:"";
			$config['per_page'] = ($perPage)?$perPage:"";
			
			//echo "<pre>"; print_r($config); exit;
			//$CI->pagination->initialize($config);
			$CI->load->library('pagination', $config);
			return $CI->pagination->create_links(); 
		}
	}
	
	
	if(!function_exists('checkAccess')){
		function checkAccess($cId, $aId, $uId){ 
			// echo "cId=>".$cId.", aId=>".$aId.", uId=>".$uId; exit;
			$CI =& get_instance();			
			if($cId && $aId){ 
				$CI->db->select('au.id');
				$CI->db->from('adminuser as au');

				if($CI->session->userdata('level') == 0){
					$CI->db->join('useraccess as ua', 'ua.user_id = au.id', 'inner');
					$CI->db->where('ua.controller_id=', $cId);
					$CI->db->where("find_in_set(".$aId.", ua.action)", null, false);
				}
				$CI->db->where('au.id=', $uId);
				
				$query= $CI->db->get();
				// echo $CI->db->last_query();exit;
				if($query->num_rows() > 0){
					return 1;
				}
				return 0;
			}
			return 0;
		}
	}
	
	
	
	if(!function_exists('getConnectionUsageTypes')){
		function getConnectionUsageTypes(){
			$CI =& get_instance();
			$connetionTypes = $CI->db->select('id as optionValue, connection_usage_type as optionText')->from('tapconnectiontype')->get()->result();
			
			if(count($connetionTypes)){
				return $connetionTypes;
			}
			return 0;
		}
	}
	
	if(!function_exists('getTapConnectionAuthority')){
		function getTapConnectionAuthority(){
			$CI =& get_instance();
			$connectionAuthorities = $CI->db->select('id as optionValue, connection_authority as optionText')->from('connection_authority')->get()->result();
			
			if(count($connectionAuthorities)){
				return $connectionAuthorities;
			}
			return 0;
		}
	}
	
	if(!function_exists('getPipeSize')){
		function getPipeSize(){
			$CI =& get_instance();
			$pipeSizes = $CI->db->select('id as optionValue, CONCAT(size_label, " (", size_in_inches, ")") as optionText')->from('pipesize')->get()->result();
			
			if(count($pipeSizes)){
				return $pipeSizes;
			}
			return 0;
		}
	}

	if(!function_exists('getMeterStatus')){
		function getMeterStatus(){
			$CI =& get_instance();
			$meterStatus = $CI->db->select('id as optionValue, meter_status as optionText')->from('tapconnectiontype')->get()->result();
			$index =0;
			for($i = 0; $i<= 1;$i++) {
			
				if($i==0){
					$update[$i]['optionValue'] =0;
					$update[$i]['optionText'] ='NonMetered';
					
				}else{
					$update[$i]['optionValue'] =1;
					$update[$i]['optionText'] ='Metered';
				}
			
			}
			if(count($update)){
				return $update;
			}
			return 0;
		}
	}
	
	
	
	if(!function_exists('getNextNoticeNumber')){
		function getNextNoticeNumber($zoneId){
			$CI =& get_instance();
			if($zoneId){ 
				$CI->db->select_max('notice_number');
				$result = $CI->db->get('notices')->row();  
				$result->notice_number;
				if($result->notice_number > 0){
					return ($result->notice_number+1);
				}
				else{
					return 1;
				}
			}
			return 0;
		}
	}
	
	if(!function_exists('getAdminUrl')){
		function getAdminUrl($data){
			$CI =& get_instance();
			$str = "";
			foreach($data as $key => $val){
				if($val !="" && $key !="controller" && $key!="action"){
					$str.=$key."/".$val."/";
				}
			}
			echo base_url('admin/'.$data['controller']."/".$data['action']."/".substr($str, 0, -1)); //exit;
		}
	}
	
	if(! function_exists('cleanXSSContent')){
		function cleanXSSContent($inputData=""){
			//echo "<pre>"; print_r($inputData); exit;
			$CI =& get_instance();
			$purifier = new HTMLPurifier();
			if(is_array($inputData) && count($inputData) > 0){
				$cleanedData = array();
				foreach($inputData as $fieldKey => $fieldValue){
					if($fieldKey != "form_validation"){
						$cleanedData[$fieldKey] = $CI->security->xss_clean($purifier->purify($fieldValue));
					}
				}
			}
			else{
				$cleanedData= $CI->security->xss_clean($purifier->purify($inputData));
			}
			return $cleanedData;
		}
	}

	if(!function_exists('getZones')){
		function getZones(){
			$CI =& get_instance();
			$zones = $CI->db->select('id as optionValue, zone_name as optionText')->from('zone')->get()->result();
			
			if(count($zones)){
				return $zones;
			}
			return 0;
		}
	}

	if(!function_exists('getUsage')){
		function getUsage(){
			$CI =& get_instance();
			$usage = $CI->db->select('id as optionValue, usage_master as optionText')->from('usage_master')->get()->result();
			
			if(count($usage)){
				return $usage;
			}
			return 0;
		}
	}

	if(!function_exists('getSubUsage')){
		function getSubUsage(){
			$CI =& get_instance();
			$subUsage = $CI->db->select('id as optionValue, sub_usage_master as optionText')->from('usage_sub_master')->get()->result();
			
			if(count($subUsage)){
				return $subUsage;
			}
			return 0;
		}
	}

	if(!function_exists('getUserRole')){
		function getUserRole(){
			$CI =& get_instance();
			$userRoles = $CI->db->select('id as optionValue, role as optionText')->from('user_role')->get()->result();
			
			if(count($userRoles)){
				return $userRoles;
			}
			return 0;
		}
	}

	if(!function_exists('getCollectionCenter')){
		function getCollectionCenter(){
			$CI =& get_instance();
			$collection = $CI->db->select('id as optionValue, centername as optionText')->from('collection_center')->get()->result();
			
			if(count($collection)){
				return $collection;
			}
			return 0;
		}
	}

	if(!function_exists('getWardNumber')){
		function getWardNumber(){
			$CI =& get_instance();
			$wardname = $CI->db->select('id as optionValue, wardname as optionText')->from('ward')->get()->result();
			//echo "<pre>"; print_r($wardname); exit;
			if(count($wardname)){
				return $wardname;
			}
			return 0;
		}
	}
	
	if(!function_exists('getCollectionCenterData')){
		function getCollectionCenterData(){
			$CI =& get_instance();
			$collectCenterData = $CI->db->select('id as optionValue, centername as optionText')->from('collection_center')->get()->result();
			
			if(count($collectCenterData)){
				return $collectCenterData;
			}
			return 0;
		}
	}
	if(!function_exists('getDocData')){
		function getDocData(){
			$CI =& get_instance();
			$docData = $CI->db->select('id as optionValue, document_name as optionText')->from('transfer_document')->get()->result();
			
			if(count($docData)){
				return $docData;
			}
			return 0;
		}
	}
?>