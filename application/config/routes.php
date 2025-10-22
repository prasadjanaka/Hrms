<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Default route
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Authentication routes
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['change-password'] = 'auth/change_password';
$route['forgot-password'] = 'auth/forgot_password';

// Dashboard routes
$route['dashboard'] = 'dashboard/index';
$route['dashboard/chart-data'] = 'dashboard/get_chart_data';

// Employee routes
$route['employees'] = 'employees/index';
$route['employees/add'] = 'employees/add';
$route['employees/edit/(:num)'] = 'employees/edit/$1';
$route['employees/delete/(:num)'] = 'employees/delete/$1';
$route['employees/view/(:num)'] = 'employees/view/$1';

// Department routes
$route['departments'] = 'departments/index';
$route['departments/add'] = 'departments/add';
$route['departments/edit/(:num)'] = 'departments/edit/$1';
$route['departments/delete/(:num)'] = 'departments/delete/$1';

// Designation routes
$route['designations'] = 'designations/index';
$route['designations/add'] = 'designations/add';
$route['designations/edit/(:num)'] = 'designations/edit/$1';
$route['designations/delete/(:num)'] = 'designations/delete/$1';

// Cadre routes
$route['cadres'] = 'cadres/index';
$route['cadres/add'] = 'cadres/add';
$route['cadres/edit/(:num)'] = 'cadres/edit/$1';
$route['cadres/delete/(:num)'] = 'cadres/delete/$1';

// Shift routes
$route['shifts'] = 'shifts/index';
$route['shifts/add'] = 'shifts/add';
$route['shifts/edit/(:num)'] = 'shifts/edit/$1';
$route['shifts/delete/(:num)'] = 'shifts/delete/$1';

// Attendance routes
$route['attendance'] = 'attendance/index';
$route['attendance/check-in'] = 'attendance/check_in';
$route['attendance/check-out'] = 'attendance/check_out';
$route['attendance/manual'] = 'attendance/manual';
$route['attendance/report'] = 'attendance/report';

// Leave routes
$route['leaves'] = 'leaves/index';
$route['leaves/request'] = 'leaves/request';
$route['leaves/approve/(:num)'] = 'leaves/approve/$1';
$route['leaves/reject/(:num)'] = 'leaves/reject/$1';
$route['leaves/delete/(:num)'] = 'leaves/delete/$1';

// Salary routes
$route['salary'] = 'salary/index';
$route['salary/generate'] = 'salary/generate';
$route['salary/payslip/(:num)'] = 'salary/payslip/$1';
$route['salary/report'] = 'salary/report';

// Report routes
$route['reports'] = 'reports/index';
$route['reports/attendance'] = 'reports/attendance';
$route['reports/salary'] = 'reports/salary';
$route['reports/employee'] = 'reports/employee';
$route['reports/leave'] = 'reports/leave';

// Settings routes
$route['settings'] = 'settings/index';
$route['settings/company'] = 'settings/company';
$route['settings/holidays'] = 'settings/holidays';
$route['settings/email'] = 'settings/email';
