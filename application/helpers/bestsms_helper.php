<?php defined('BASEPATH') OR exit('No direct script access allowed.');
    
    if(!function_exists('sendcdacsms')){
        function sendcdacsms($message,$mobileNos)
        {
            $username="nashiksmartcity"; //username of the department
            $password="Nmc$54321"; //password of the department
            $data['senderId']="NMCNSK"; //senderid of the deparment
            $data['AUTH_KEY'] = "6dbfc35421b2ef8dbd9ab0f25ff64c72";
            $data['message'] = $message;
            $data['mobileNos'] = $mobileNos;

            
            //$message="Test Message from CDAC "; //message content
            //$messageUnicode="Test Message"; //moessage content in unicode
            //$mobileno="9860814247"; //if single sms need to be send use mobileno keyword
            //$mobileNos= "9860814247,9284628352"; //if bulk sms need to send use
            
             post_to_url($data);
        }
    }

    if(!function_exists('post_to_url')){
        function post_to_url($data) {

           $curlUrl = "http://msgpr.bestsms.co.in/rest/services/sendSMS/sendGroupSms?AUTH_KEY=".$data['AUTH_KEY']."&message=".urlencode($data['message'])."&senderId=".$data['senderId']."&routeId=1&mobileNos=".$data['mobileNos']."&smsContentType=english"; 


           //$jsonStr = file_get_contents($curlUrl);

            //echo $curlUrl; 
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_PORT => "80",
              /*CURLOPT_URL => "http://msgpr.bestsms.co.in/rest/services/sendSMS/sendGroupSms?AUTH_KEY=".$data['AUTH_KEY']."&message=".$data['message']."&senderId=".$data['senderId']."&routeId=1&mobileNos=".$data['mobileNos']."&smsContentType=english",*/

              CURLOPT_URL => $curlUrl,

              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache"
              ),
            ));

               /* $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $curlUrl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                
                if($method == "POST"){
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                }*/
                
                



            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              return $response; 
            }
        }
    }
?>