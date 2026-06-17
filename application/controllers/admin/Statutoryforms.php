<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Statutoryforms
 * Renders the statutory DCPS printouts from existing data:
 *   admin/statutory-forms/form2           -> FORM-2 monthly contribution schedule
 *   admin/statutory-forms/form-r2         -> FORM-R-2 consolidated receipt-cum-schedule
 *   admin/statutory-forms/form3-register  -> FORM-3 SRKA register
 *   admin/statutory-forms/day-book        -> Treasury day book
 *
 * Each screen shows a filter form; add ?pdf=1 (or the Download PDF button)
 * to stream the same layout through the existing m_pdf (mpdf) library.
 */
class Statutoryforms extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('admin/StatutoryformsModel', 'sf');
		$this->load->library('session');
		$this->load->helper('url');
		if(!$this->session->userdata('validated') && $this->router->class != 'login'){
			// redirect('admin/login');
		}
	}

	private function monthName($m){
		$names = array(1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',
			7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December');
		return isset($names[(int)$m]) ? $names[(int)$m] : '';
	}

	/* ----------------------------------------------------- FORM-2 */
	public function form2Schedule(){
		$month = (int)$this->input->get('month');
		$year  = (int)$this->input->get('year');
		$pc    = $this->input->get('pay_center', TRUE);

		$data = $this->commonFilters();
		$data['month'] = $month; $data['year'] = $year; $data['pay_center'] = $pc;
		$data['month_name'] = $this->monthName($month);
		$data['rows'] = ($month && $year) ? $this->sf->getForm2Schedule($month, $year, $pc) : array();

		if($this->input->get('pdf') && $month && $year){
			$this->stream('admin/statutoryforms/form2_pdf', $data, 'FORM-2_Schedule_'.$year.'_'.$month);
			return;
		}
		$this->render('admin/statutoryforms/form2', $data);
	}

	/* --------------------------------------------------- FORM-R-2 */
	public function formR2(){
		$month = (int)$this->input->get('month');
		$year  = (int)$this->input->get('year');

		$data = $this->commonFilters();
		$data['month'] = $month; $data['year'] = $year;
		$data['month_name'] = $this->monthName($month);
		$data['grouped'] = ($month && $year) ? $this->sf->getFormR2($month, $year) : array();

		if($this->input->get('pdf') && $month && $year){
			$this->stream('admin/statutoryforms/form_r2_pdf', $data, 'FORM-R-2_'.$year.'_'.$month);
			return;
		}
		$this->render('admin/statutoryforms/form_r2', $data);
	}

	/* ----------------------------------------- FORM-3 Register */
	public function form3Register(){
		$pc = $this->input->get('pay_center', TRUE);
		$data = $this->commonFilters();
		$data['pay_center'] = $pc;
		$data['apps'] = $this->sf->getForm3Register($pc);

		if($this->input->get('pdf')){
			$this->stream('admin/statutoryforms/form3_register_pdf', $data, 'FORM-3_Register');
			return;
		}
		$this->render('admin/statutoryforms/form3_register', $data);
	}

	/* -------------------------------------------------- Day Book */
	public function dayBook(){
		$month = (int)$this->input->get('month');
		$year  = (int)$this->input->get('year');
		$pc    = $this->input->get('pay_center', TRUE);

		$data = $this->commonFilters();
		$data['month'] = $month; $data['year'] = $year; $data['pay_center'] = $pc;
		$data['month_name'] = $this->monthName($month);
		$data['rows'] = ($month && $year) ? $this->sf->getDayBook($month, $year, $pc) : array();

		if($this->input->get('pdf') && $month && $year){
			$this->stream('admin/statutoryforms/day_book_pdf', $data, 'Day_Book_'.$year.'_'.$month);
			return;
		}
		$this->render('admin/statutoryforms/day_book', $data);
	}

	/* ===================================================== helpers */
	private function commonFilters(){
		return array(
			'months'      => $this->sf->getMonths(),
			'years'       => $this->sf->getYears(),
			'pay_centers' => $this->sf->getPayCenters(),
		);
	}

	private function render($view, $data){
		$this->load->view('admin/common/header');
		$this->load->view($view, $data);
		$this->load->view('admin/common/footer');
	}

	/** Stream an HTML view through mpdf (A4 landscape), same as Misreport. */
	private function stream($view, $data, $filename){
		$config = array(
			'mode'          => 'utf-8',
			'format'        => 'A4-L',
			'margin_left'   => 8,
			'margin_right'  => 8,
			'margin_top'    => 10,
			'margin_bottom' => 10,
			'margin_header' => 0,
			'margin_footer' => 0,
		);
		$this->load->library('m_pdf', $config);
		$this->m_pdf->pdf->SetTitle($filename);
		$this->m_pdf->pdf->SetAuthor('NMC');
		$this->m_pdf->pdf->SetCreator('DCPS Pension System');
		$html = $this->load->view($view, $data, TRUE);
		$this->m_pdf->pdf->WriteHTML($html);
		$this->m_pdf->pdf->Output($filename.'.pdf', 'I');
	}
}
