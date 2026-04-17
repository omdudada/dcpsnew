<?php defined('BASEPATH') OR exit('No direct script access allowed.');

if ( ! function_exists('count_visitor')) {
    function count_visitor()
    {
        $CI = get_instance();

   
    $CI->load->model('default/HomeModel');

    
   $totalvisitors = $CI->HomeModel->gettotalvisitors();

        $filecounter=(APPPATH . 'logs/counter.txt');
        $kunjungan=file($filecounter);
        $visits =$totalvisitors[0]->total_visitor+1;
        $CI->HomeModel->updatetotalvisitors($visits);
   //echo '<pre>'; print_r($visits);exit;
        $file=fopen($filecounter, 'w');
        fputs($file, $visits);
        fclose($file);
        return $visits;
    }
}
?>