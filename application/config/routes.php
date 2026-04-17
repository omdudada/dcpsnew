<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin'] = 'admin/login';
$route['admin/change-password'] = 'admin/login/changepassword';
// $route['admin/login'] = 'admin/Login';

$route['admin/master-record'] = 'admin/report/masterReocrd';
$route['admin/view-employee-data/(:any)'] = 'admin/report/viewEmployeeData/$1';

$route['admin/emp-master'] = 'admin/masterdata/empmaster';
$route['admin/add-emp'] = 'admin/masterdata/addEmp';
$route['admin/edit-emp/(:any)'] = 'admin/masterdata/editEmp/$1';

// $route['admin/dcps-deduction-record'] = 'admin/masterdata/deductionRecord';
// $route['admin/edit-dcps-deduction-record/(:any)'] = 'admin/masterdata/editDeductionRecord/$1';

$route['admin/gr-management'] = 'admin/masterdata/grManagement';
$route['admin/add-gr-management'] = 'admin/masterdata/addGrManagement';
$route['admin/edit-gr-management/(:any)'] = 'admin/masterdata/editGrManagementData/$1';

$route['admin/slip-and-ledger'] = 'admin/report/slipAndLedger';
$route['admin/opening-bal'] = 'admin/masterdata/calOpeningBal';

$route['get-employee-details'] = 'admin/misreport/get_employee_details';

$route['admin/add-edit-master-record'] = 'admin/addeditmaster';

$route['admin/broad-sheet-report'] = 'admin/report';
$route['admin/dcps-deduction-record'] = 'admin/report/deductionRecord';
$route['admin/edit-dcps-deduction-record/(:any)'] = 'admin/report/editDeductionRecord/$1';

$route['admin/monthly-record'] = 'admin/report/monthlyRecord';
$route['admin/edit-monthly-record/(:any)'] = 'admin/report/editmonthlyRecord/$1';
$route['admin/generate-PDF'] = 'admin/report/generatePDF';
$route['admin/edit-monthly-record/(:any)'] = 'admin/report/editmonthlyRecord/$1';
$route['admin/edit-missing-month-year-records'] = 'admin/report/editMissingMonthYearRecords';

// Team Wise Tasks routes
$route['admin/team-wise-tasks'] = 'admin/report/teamwisetasks';
$route['admin/team-wise-tasks/team/(:num)'] = 'admin/report/teamwisetasks/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
