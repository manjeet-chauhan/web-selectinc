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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['login']='login/auth/my_login';
$route['user-login']='login/auth/user_login';
$route['register']='login/auth/my_register';
$route['user-register']='login/auth/user_register';
$route['logout']='login/auth/user_logout';
 
$route['view-issues-issues']='home/home/view_issues_issues';
$route['view-issues-issues-detail']='home/home/view_issues_issues_detail';
  
$route['open-invoice-send']='home/home/open_invoice_send';
 
// client model management
$route['client-management']='home/home/client_management';
$route['all-client-management']='home/home/all_client_management';

$route['add-client-management']='home/home/add_client_management';
$route['save-client-management']='home/home/save_client_management';
$route['edit-client-management/(:any)']='home/home/edit_client_management/$1';
$route['save-edit-client-management']='home/home/save_edit_client_management';
$route['client-management-detail/(:any)']='home/home/client_management_detail/$1';


$route['save-create-refund']='home/home/save_create_refund';


// model management
$route['model-management']='home/home/model_management';
$route['all-model-management']='home/home/all_model_management';
$route['add-model-management']='home/home/add_model_management';
$route['save-model-management']='home/home/save_model_management';
$route['edit-model-management/(:any)']='home/home/edit_model_management/$1';
$route['save-edit-model-management']='home/home/save_edit_model_management';
$route['model-management-detail/(:any)']='home/home/model_management_detail/$1';

$route['mwm-agency-management']='home/home/mwm_agency_management';
$route['save-mwm-agency-management']='home/home/save_mwm_agency_management';

$route['invoice']='home/home/invoice';
$route['generate-new-invoice']='home/home/generate_new_invoice';
$route['save-new-invoice']='home/home/save_new_invoice';


$route['generate-reverse-charge-invoice']='home/home/generate_reverse_charge_invoice';
$route['edit-reverse-charge-invoice']='home/home/edit_reverse_charge_invoice';



$route['accepted-invoice']='home/home/accepted_invoice';
$route['save-accepted-invoice-email-send']='home/home/save_accepted_invoice_email_send';



$route['edit-generate-invoice-client']='home/home/edit_generate_invoice_client';
$route['edit-generate-invoice-modal']='home/home/edit_generate_invoice_modal';
$route['general-invoive-details/(:any)']='home/home/generate_invoice_details/$1';
$route['general-invoices']='home/home/general_invoices';

$route['client-list-invoice']='home/home/client_list_invoice';
$route['client-list-invoice-without-vat']='home/home/client_list_invoice_without_vat';


$route['collective-invoice']='home/home/collective_invoice';
$route['collective-invoice-pdf']='home/pdfdownloader/collective_invoice_pdf';

// http://homeofbulldogs.com/dev/selectinc/general-invoice
$route['generate-new-general-invoice']='home/home/generate_new_general_invoice';
$route['save-new-general-invoice']='home/home/save_new_general_invoice';

$route['edit-invoive']='home/home/edit_invoice';
$route['save-edit-invoice']='home/home/save_edit_invoice';

$route['invoice-correction']='home/home/invoice_correction';
$route['edit-invoice-correction']='home/home/edit_invoice_correction';
$route['save-edit-invoice-correction']='home/home/save_edit_invoice_correction';


$route['edit-refund-invoice']='home/home/edit_refund_invoice';
// $route['save-edit-invoice']='home/home/save_edit_invoice';
// edit-refund-invoice.php

$route['invoice-no-info'] = 'home/home/invoice_no_info';
$route['clients-for-invoice']='home/home/clients_for_invoice';
$route['models-for-invoice']='home/home/models_for_invoice';
$route['generate-invoice-preview']='home/home/generate_invoice_preview';

$route['generate-invoice/(:any)']='home/home/generate_invoice/$1';
$route['generate-invoice-headers']='home/home/generate_invoice_headers';
$route['delete-invoice-headers']='home/home/delete_invoice_headers';
$route['forward-invoice-approval']='home/home/forward_invoice_approval';

$route['invoice-approve-or-change-request']='home/home/invoice_approve_or_change_request';

$route['generate-invoice-pdf/(:any)'] = 'home/pdfdownloader/generate_invoice_pdf/$1';
$route['model-invoice-pdf/(:any)'] = 'home/pdfdownloader/model_invoice_pdf/$1';

$route['model-invoice-expenses-pdf/(:any)'] = 'home/pdfdownloader/model_invoice_expenses_pdf/$1';

$route['mwm-invoice-pdf/(:any)'] = 'home/pdfdownloader/mwm_invoice_pdf/$1';
$route['partners-invoice-pdf/(:any)'] = 'home/pdfdownloader/partners_invoice_pdf/$1';
$route['refund-invoice-pdf/(:any)'] = 'home/pdfdownloader/refund_invoice_pdf/$1';
$route['download-client-list-pdf'] = 'home/pdfdownloader/download_client_list_pdf';


$route['download-mwm-pdf'] = 'home/pdfdownloader/download_mwm_pdf';
$route['download-invoice-list-pdf'] = 'home/pdfdownloader/download_invoice_list_pdf';
$route['download-general-invoice-pdf/(:any)'] = 'home/pdfdownloader/download_general_invoice_pdf/$1';





$route['refund-overview']='home/home/refund_overview';
$route['invoive-refund']='home/home/invoive_refund';
$route['save-invoive-refund']='home/home/save_invoive_refund';
$route['forward-refund-approval']='home/home/forward_refund_approval';

// $route['create-refund']='home/home/create_refund';

$route['invoive-refund-details/(:any)']='home/home/get_invoice_refund_details/$1';
$route['invoive-details/(:any)']='home/home/get_invoice_details/$1';


$route['draft-invoice']='home/home/get_draft_invoices';
$route['open-invoice']='home/home/get_open_invoices';
$route['approve-invoice']='home/home/get_approve_invoices';
$route['reminder-invoice']='home/home/get_reminder_invoices';
$route['refund-invoice']='home/home/get_refund_invoices';
 
 
$route['invoice-for-approval']='home/home/get_invoice_for_approval';
$route['approve-user-invoice']='home/home/approve_user_invoice';

$route['changes-request-invoice-lists-for-approval']='home/home/changes_requestinvoice_lists_for_approval';

 
$route['refund-for-approval']='home/home/get_refund_for_approval';
$route['approve-user-refund']='home/home/approve_user_refund';


$route['draft-refund']='home/home/get_draft_refunds';
$route['open-refund']='home/home/get_open_refunds';
$route['approve-refund']='home/home/get_approve_refunds';
$route['reminder-refund']='home/home/get_reminder_refunds';
$route['prepared-refund']='home/home/get_prepared_refunds';


$route['deductions']='home/home/deductions';
$route['create-deduction-transaction/(:any)']='home/home/create_deduction_transaction/$1';
$route['save-deduction-transaction']='home/home/save_deduction_transaction';


// $route['expences-deduction']='home/home/expences_deduction';

$route['reports-overview']='home/home/reports_overview';
$route['reports-detail-view']='home/home/reports_detail_view';
$route['administration']='home/home/administration';
$route['save-logo']='home/home/save_logo';

$route['get-footer-contents']='home/home/get_footer_contents';
$route['save-footer-contents']='home/home/save_footer_contents';



$route['reports-select-income-list']='home/home/reports_select_income_list';
$route['reports-select-income/(:any)']='home/home/reports_select_income/$1';

$route['reports-expenses-overview-list']='home/home/reports_expenses_overview_list';
$route['reports-expenses-overview/(:any)']='home/home/reports_expenses_overview/$1';

$route['profile']='home/home/profile';
$route['save-profile']='home/home/save_profile';
$route['settings']='home/home/settings';
$route['change-settings']='home/home/change_settings';

$route['hold-tickets']='home/home/hold_tickets';
$route['select-expenses-invoice']='home/home/select_expenses_invoice';
$route['payed-models-overview']='home/home/payed_models_overview';
$route['payed-refund']='home/home/payed_refund';
$route['approve-invoices-ready-for-email-send']='home/home/approve_invoices_ready_for_email_send';
$route['payed-invoices-ready-for-refund']='home/home/payed_invoices_ready_for_refund';

$route['upload-client-csv-data']='home/home/upload_client_csv_data';
$route['upload-modal-csv-data']='home/home/upload_model_csv_data';

$route['get-modified-date']='home/home/get_modified_date';


$route['save-created-refund']='home/home/save_created_refund';


$route['get-client-list']='home/home/get_client_list';
$route['get-model-list']='home/home/get_model_list';





// ===============

$route['collected-invoice-last-month-with-vat']='home/home/collected_invoice_last_month_with_vat';
$route['collected-net']='home/home/collected_net';
$route['collected-vat']='home/home/collected_vat';
$route['collected-invoice-last-no-vat']='home/home/collected_invoice_last_no_vat';
$route['advances-on-behalf-of-mwm']='home/home/advances_on_behalf_of_mwm';

$route['user-management']='home/home/user_management';
$route['save-user-profile']='home/home/save_user_profile';
// -------------- Admin Backend -----------

$route['admin'] = 'login/auth/login';
$route['admin/login'] = 'login/auth/login';
$route['admin/login-admin'] = 'login/auth/login_admin';
$route['admin/logout'] = 'login/auth/logout';

$route['admin/dashboard'] = 'admin/admin/dashboard';
$route['admin/users'] = 'admin/admin/users';
$route['admin/user-profile/(:any)/(:any)'] = 'admin/admin/user_profile/$1/$2';

$route['admin/users-enable'] = 'admin/admin/users_enabled';
$route['admin/users-status'] = 'admin/admin/users_status';
$route['admin/edit-profile/(:any)/(:any)'] = 'admin/admin/edit_users_profile/$1/$2';
$route['admin/save-profile'] = 'admin/admin/save_users_profile';
$route['admin/users-delete-account'] = 'admin/admin/users_delete_account';
$route['admin/users-approve-account'] = 'admin/admin/users_approve_account';

$route['admin/profile'] = 'login/auth/admin_profile';

$route['admin/update-profile'] = 'login/auth/update_profile';
$route['admin/change-password'] = 'login/auth/admin_change_password';
$route['admin/update-password'] = 'login/auth/admin_update_password';


$route['admin/clients/(:any)/(:any)'] = 'admin/admin/user_clients/$1/$2';
$route['admin/client-details/(:any)'] = 'admin/admin/user_client_detail/$1';

$route['admin/models/(:any)/(:any)'] = 'admin/admin/user_models/$1/$2';
$route['admin/model-details/(:any)'] = 'admin/admin/user_model_detail/$1';

$route['admin/invoices/(:any)/(:any)'] = 'admin/admin/user_invoices/$1/$2';
$route['admin/invoices-for-approval'] = 'admin/admin/invoices_for_approval';
$route['admin/approve-user-invoice'] = 'admin/admin/approve_user_invoice';


$route['admin/refund/(:any)/(:any)'] = 'admin/admin/user_refund/$1/$2';
$route['admin/refund-for-approval'] = 'admin/admin/refund_for_approval';
$route['admin/approve-user-refund'] = 'admin/admin/approve_user_refund';

$route['(:any)'] = 'pages/view/$1'; 


