<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pdf {

    public $pdf;

    public function __construct($param = null)
    {
        require_once FCPATH . 'vendor/autoload.php';
        
        if ($param) {
            $this->pdf = new \Mpdf\Mpdf($param);
        } else {
            $this->pdf = new \Mpdf\Mpdf();
        }
    }
}
