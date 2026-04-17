<?php defined('BASEPATH') OR exit('No direct script access allowed.');
    
    if(!function_exists('sendcdacsms')){
        function sendcdacsms($message,$mobileNos)
        {
            $username="nmc"; //username of the department
            $password="Nmcit@12345"; //password of the department
            $senderid="NMCNSK"; //senderid of the deparment
            $deptSecureKey= "50255b70-7d7e-45b4-9566-6429de177774";
            $encryp_password=sha1(trim($password));
            
            //$message="Test Message from CDAC "; //message content
            //$messageUnicode="Test Message"; //message content in unicode
            //$mobileno="9860814247"; //if single sms need to be send use mobileno keyword
            //$mobileNos= "9860814247,9284628352"; //if bulk sms need to send use
            
             sendBulkSMS($username,$encryp_password,$senderid,$message,$mobileNos,$deptSecureKey);
        }
    }
    if(!function_exists('sendcdacsmsunicode')){
        function sendcdacsmsunicode($messageUnicode='',$mobileNos)
        {
            $username="nmc"; //username of the department
            $password="Nmcit@12345"; //password of the department
            $senderid="NMCNSK"; //senderid of the deparment
            $deptSecureKey= "50255b70-7d7e-45b4-9566-6429de177774";
            $encryp_password=sha1(trim($password));
            
            //$message="Test Message from CDAC "; //message content
            //$messageUnicode="Test Message"; //message content in unicode
            //$mobileno="9860814247"; //if single sms need to be send use mobileno keyword
            //$mobileNos= "9860814247,9284628352"; //if bulk sms need to send use
            
            sendBulkUnicode($username,$encryp_password,$senderid,$messageUnicode,$mobileNos,$deptSecureKey);
        }
    }

    if(!function_exists('post_to_url')){
        function post_to_url($url, $data) {
            $fields = '';
            foreach($data as $key => $value) {
                $fields .= $key . '=' . $value . '&';
            }
            rtrim($fields, '&');
            $post = curl_init();
            curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($post, CURLOPT_URL, $url); curl_setopt($post, CURLOPT_POST, count($data)); curl_setopt($post, CURLOPT_POSTFIELDS, $fields); curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
           $result = curl_exec($post); //result from mobile seva server echo $result; //output from server displayed curl_close($post);
        }
    }


    //function to send unicode sms by making http connection
    if(!function_exists('post_to_url_unicode')){
        function post_to_url_unicode($url, $data) {
            $fields = '';
            foreach($data as $key => $value) {
                $fields .= $key . '=' . urlencode($value) . '&';
            }
            echo $fields; exit;
            rtrim($fields, '&');
            $post = curl_init(); 
            curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false); 
            curl_setopt($post, CURLOPT_URL, $url); 
            curl_setopt($post, CURLOPT_POST, count($data)); 
            curl_setopt($post, CURLOPT_POSTFIELDS, $fields); 
            curl_setopt($post, CURLOPT_HTTPHEADER, array("Content-
                Type:application/x-www-form-urlencoded"));
            curl_setopt($post, CURLOPT_HTTPHEADER, array("Content-length:"
                . strlen($fields) ));
            curl_setopt($post, CURLOPT_HTTPHEADER, array("User-Agent:Mozilla/4.0 (compatible; MSIE 5.0; Windows 98; DigExt)"));
            curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
            echo $result = curl_exec($post); //result from mobile seva server
            curl_close($post);
        }
    }
    //function to convert unicode text in UTF-8 format
    if(!function_exists('string_to_finalmessage')){
        function string_to_finalmessage($message){
            $finalmessage="";
            $sss = "";
            for($i=0;$i<mb_strlen($message,"UTF-8");$i++) {
                $sss=mb_substr($message,$i,1,"utf-8");
                $a=0;
                $abc="&#".ordutf8($sss,$a).";";
                $finalmessage.=$abc;
            }
            return $finalmessage;
        }
    }
    
    //function to convet utf8 to html entity
    if(!function_exists('ordutf8')){
        function ordutf8($string, &$offset){
            $code=ord(substr($string, $offset,1));
            if ($code >= 128)
        { //otherwise 0xxxxxxx
        if ($code < 224) $bytesnumber = 2;//110xxxxx
        else if ($code < 240) $bytesnumber = 3; //1110xxxx
        else if ($code < 248) $bytesnumber = 4; //11110xxx
        $codetemp = $code - 192 - ($bytesnumber > 2 ? 32 : 0) - ($bytesnumber > 3 ? 16 : 0);
        for ($i = 2; $i <= $bytesnumber; $i++) {
            $offset ++;
        $code2 = ord(substr($string, $offset, 1)) - 128;//10xxxxxx
        $codetemp = $codetemp*64 + $code2;
        }
        $code = $codetemp;
        }
        return $code;
        }
    }
    //Function to send single sms
    if(!function_exists('sendSingleSMS')){
        function sendSingleSMS($username,$encryp_password,$senderid,$message,$mobileno,$deptSecureKey){
            $key=hash('sha512',trim($username).trim($senderid).trim($message).trim($deptSecureKey));
            $data = array(
                "username" => trim($username), "password" => trim($encryp_password), "senderid" => trim($senderid), "content" => trim($message), "smsservicetype" =>"singlemsg", "mobileno" =>trim($mobileno),
                "key" => trim($key)
            );
             post_to_url("https://msdgweb.mgov.gov.in/esms/sendsmsrequest",$data);
        //calling post_to_url to send sms
        }
    }
    //Function to send otp sms
    if(!function_exists('sendOtpSMS')){
        function sendOtpSMS($username,$encryp_password,$senderid,$message,$mobileno,$deptSecureKey){
            $key=hash('sha512',trim($username).trim($senderid).trim($message).trim($deptSecureKey));
            $data = array(
                "username" => trim($username), "password" => trim($encryp_password), "senderid" => trim($senderid), "content" => trim($message), "smsservicetype" =>"otpmsg", "mobileno" =>trim($mobileno),
                "key" => trim($key)
            );
             post_to_url("https://msdgweb.mgov.gov.in/esms/sendsmsrequest",$data);
        //calling post_to_url to send otp sms
        }
    }
    //function to send bulk sms
    if(!function_exists('sendBulkSMS')){
        function sendBulkSMS($username,$encryp_password,$senderid,$message,$mobileNos,$deptSecureKey){
            $key=hash('sha512',
                trim($username).trim($senderid).trim($message).trim($deptSecureKey));
            $data = array(
                "username" => trim($username), "password" => trim($encryp_password), "senderid" => trim($senderid), "content" => trim($message), "smsservicetype" =>"bulkmsg", "bulkmobno" =>trim($mobileNos),
                "key" => trim($key)
            );
             post_to_url("https://msdgweb.mgov.gov.in/esms/sendsmsrequest",$data);
        //calling post_to_url to send bulk sms
        }
    }
    //function to send single unicode sms
    if(!function_exists('sendSingleUnicode')){
        function sendSingleUnicode($username,$encryp_password,$senderid,$messageUnicode,$mobileno,$deptSecureKey){
            $finalmessage=string_to_finalmessage(trim($messageUnicode));
            $key=hash('sha512',trim($username).trim($senderid).trim($finalmessage).trim($deptSecureKey));
            $data = array(
                "username" => trim($username), "password" => trim($encryp_password), "senderid" => trim($senderid), "content" => trim($finalmessage), "smsservicetype" =>"unicodemsg",
                "mobileno" =>trim($mobileno), "key" => trim($key)
            );
             post_to_url_unicode("https://msdgweb.mgov.gov.in/esms/sendsmsrequest",$data);
        //calling post_to_url_unicode to send single unicode sms
        }
    }
    //function to send bulk unicode sms
    if(!function_exists('sendBulkUnicode')){
        function sendBulkUnicode($username,$encryp_password,$senderid,$messageUnicode,$mobileNos,$deptSecureKey){
            $finalmessage=string_to_finalmessage(trim($messageUnicode));
            $key=hash('sha512',trim($username).trim($senderid).trim($finalmessage).trim($deptSecureKey));
            $data = array(
                "username" => trim($username), "password" => trim($encryp_password), "senderid" => trim($senderid), "content" => trim($finalmessage), "smsservicetype" =>"unicodemsg", "bulkmobno" =>trim($mobileNos),
                "key" => trim($key)
            );
             post_to_url_unicode("https://msdgweb.mgov.gov.in/esms/sendsmsrequest",$data);
        //calling post_to_url_unicode to send bulk unicode sms
        }
    }
    //function to send single unicode otp sms
    if(!function_exists('sendUnicodeOtpSMS')){
        function sendUnicodeOtpSMS($username,$encryp_password,$senderid,$messageUnicode,$mobileno,$deptSecureKey){
            $finalmessage=string_to_finalmessage(trim($messageUnicode));
            $key=hash('sha512',trim($username).trim($senderid).trim($finalmessage).trim($deptSecureKey));
            $data = array(
                "username" => trim($username), "password" => trim($encryp_password), "senderid" => trim($senderid), "content" => trim($finalmessage), "smsservicetype" =>"unicodeotpmsg", "mobileno" =>trim($mobileno),
                "key" => trim($key)
            );
             post_to_url_unicode("https://msdgweb.mgov.gov.in/esms/sendsmsrequest",$data);
        //calling post_to_url_unicode to send single unicode sms
        }
    }


?>