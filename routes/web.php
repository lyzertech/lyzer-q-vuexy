<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\laravel_example\UserManagement;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\dashboard\CrmOri;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\layouts\CollapsedMenu;
use App\Http\Controllers\layouts\ContentNavbar;
use App\Http\Controllers\layouts\ContentNavSidebar;
use App\Http\Controllers\layouts\NavbarFull;
use App\Http\Controllers\layouts\NavbarFullSidebar;
use App\Http\Controllers\layouts\Horizontal;
use App\Http\Controllers\layouts\Vertical;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\front_pages\Landing;
use App\Http\Controllers\front_pages\Pricing;
use App\Http\Controllers\front_pages\Payment;
use App\Http\Controllers\front_pages\Checkout;
use App\Http\Controllers\front_pages\HelpCenter;
use App\Http\Controllers\front_pages\HelpCenterArticle;
use App\Http\Controllers\apps\Email;
use App\Http\Controllers\apps\Chat;
use App\Http\Controllers\apps\Calendar;
use App\Http\Controllers\apps\Kanban;
use App\Http\Controllers\apps\EcommerceDashboard;
use App\Http\Controllers\apps\EcommerceProductList;
use App\Http\Controllers\apps\EcommerceProductAdd;
use App\Http\Controllers\apps\EcommerceProductCategory;
use App\Http\Controllers\apps\EcommerceOrderList;
use App\Http\Controllers\apps\EcommerceOrderDetails;
use App\Http\Controllers\apps\EcommerceCustomerAll;
use App\Http\Controllers\apps\EcommerceCustomerDetailsOverview;
use App\Http\Controllers\apps\EcommerceCustomerDetailsSecurity;
use App\Http\Controllers\apps\EcommerceCustomerDetailsBilling;
use App\Http\Controllers\apps\EcommerceCustomerDetailsNotifications;
use App\Http\Controllers\apps\EcommerceManageReviews;
use App\Http\Controllers\apps\EcommerceReferrals;
use App\Http\Controllers\apps\EcommerceSettingsDetails;
use App\Http\Controllers\apps\EcommerceSettingsPayments;
use App\Http\Controllers\apps\EcommerceSettingsCheckout;
use App\Http\Controllers\apps\EcommerceSettingsShipping;
use App\Http\Controllers\apps\EcommerceSettingsLocations;
use App\Http\Controllers\apps\EcommerceSettingsNotifications;
use App\Http\Controllers\AcademyDashboard;
use App\Http\Controllers\AcademyCourse;
use App\Http\Controllers\AcademyCourseDetails;
use App\Http\Controllers\LogisticsDashboard;
use App\Http\Controllers\LogisticsFleet;
use App\Http\Controllers\InvoiceList;
use App\Http\Controllers\InvoicePreview;
use App\Http\Controllers\InvoicePrint;
use App\Http\Controllers\InvoiceEdit;
use App\Http\Controllers\InvoiceAdd;
use App\Http\Controllers\UserList;
use App\Http\Controllers\UserViewAccount;
use App\Http\Controllers\UserViewSecurity;
use App\Http\Controllers\UserViewBilling;
use App\Http\Controllers\UserViewNotifications;
use App\Http\Controllers\UserViewConnections;
use App\Http\Controllers\AccessRoles;
use App\Http\Controllers\AccessPermission;
use App\Http\Controllers\pages\UserProfile;
use App\Http\Controllers\pages\UserTeams;
use App\Http\Controllers\pages\UserProjects;
use App\Http\Controllers\pages\UserConnections;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsSecurity;
use App\Http\Controllers\pages\AccountSettingsBilling;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\Faq;
use App\Http\Controllers\Pricing as PagesPricing;
use App\Http\Controllers\MiscError;
use App\Http\Controllers\MiscUnderMaintenance;
use App\Http\Controllers\MiscComingSoon;
use App\Http\Controllers\MiscNotAuthorized;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\LoginCover;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\RegisterCover;
use App\Http\Controllers\authentications\RegisterMultiSteps;
use App\Http\Controllers\authentications\VerifyEmailBasic;
use App\Http\Controllers\authentications\VerifyEmailCover;
use App\Http\Controllers\authentications\ResetPasswordBasic;
use App\Http\Controllers\authentications\ResetPasswordCover;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\authentications\ForgotPasswordCover;
use App\Http\Controllers\authentications\TwoStepsBasic;
use App\Http\Controllers\authentications\TwoStepsCover;
use App\Http\Controllers\wizard_example\Checkout as WizardCheckout;
use App\Http\Controllers\wizard_example\PropertyListing;
use App\Http\Controllers\wizard_example\CreateDeal;
use App\Http\Controllers\modal\ModalExample;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\cards\CardAdvance;
use App\Http\Controllers\cards\CardStatistics;
use App\Http\Controllers\cards\CardAnalytics;
use App\Http\Controllers\cards\CardGamifications;
use App\Http\Controllers\cards\CardActions;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\Avatar;
use App\Http\Controllers\extended_ui\BlockUI;
use App\Http\Controllers\extended_ui\DragAndDrop;
use App\Http\Controllers\extended_ui\MediaPlayer;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\StarRatings;
use App\Http\Controllers\extended_ui\SweetAlert;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\extended_ui\TimelineBasic;
use App\Http\Controllers\extended_ui\TimelineFullscreen;
use App\Http\Controllers\extended_ui\Tour;
use App\Http\Controllers\extended_ui\Treeview;
use App\Http\Controllers\extended_ui\Misc;
use App\Http\Controllers\icons\Tabler;
use App\Http\Controllers\icons\FontAwesome;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_elements\CustomOptions;
use App\Http\Controllers\form_elements\Editors;
use App\Http\Controllers\form_elements\FileUpload;
use App\Http\Controllers\form_elements\Picker;
use App\Http\Controllers\form_elements\Selects;
use App\Http\Controllers\form_elements\Sliders;
use App\Http\Controllers\form_elements\Switches;
use App\Http\Controllers\form_elements\Extras;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\form_layouts\StickyActions;
use App\Http\Controllers\form_wizard\Numbered as FormWizardNumbered;
use App\Http\Controllers\form_wizard\Icons as FormWizardIcons;
use App\Http\Controllers\form_validation\Validation;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\tables\DatatableBasic;
use App\Http\Controllers\tables\DatatableAdvanced;
use App\Http\Controllers\tables\DatatableExtensions;
use App\Http\Controllers\charts\ApexCharts;
use App\Http\Controllers\charts\ChartJs;
use App\Http\Controllers\maps\Leaflet;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\crm\CrmDashboard;
use App\Http\Controllers\crm\CrmCustomer;
use App\Http\Controllers\crm\CrmVisitReport;
use App\Http\Controllers\crm\CrmVisitReportSep;
use App\Http\Controllers\crm\CrmCalendar;
use App\Http\Controllers\crm\CrmProject;
use App\Http\Controllers\crm\CrmQuotation;
use App\Http\Controllers\crm\CrmPurchaseRequest;
use App\Http\Controllers\crm\CrmPurchaseOrder;
use App\Http\Controllers\crm\CrmInquiry;
use App\Http\Controllers\indent\IndentHome;
use App\Http\Controllers\labs\LabsDashboard;
use App\Http\Controllers\labs\LabsLabel;
use App\Http\Controllers\monitoring\MonitoringHome;
use App\Http\Controllers\monitoring\MonitoringDashboard;
use App\Http\Controllers\monitoring\MonitoringInstallation;
use App\Http\Controllers\monitoring\MonitoringAnalysis;
use App\Http\Controllers\monitoring\MonitoringTrend;
use App\Http\Controllers\monitoring\MonitoringDatalog;

// Procurement Controllers
use App\Http\Controllers\procurement\ProcurementRequestController;
use App\Http\Controllers\procurement\ProcurementDashboardController;
use App\Http\Controllers\procurement\ProcurementItemController;
use App\Http\Controllers\procurement\ProcurementCommentController;
use App\Http\Controllers\procurement\ProcurementAttachmentController;
use App\Http\Controllers\procurement\ProcurementArrivalController;
use App\Http\Controllers\procurement\ProcurementPurchaseOrderController;
use App\Http\Controllers\procurement\ProcurementSupplierController;
use App\Http\Controllers\procurement\ProcurementCustomerController;
use App\Http\Controllers\procurement\ProcurementProductController;

use App\Http\Controllers\users\Users;
use App\Http\Controllers\dev\DevZerotest;

use App\Http\Controllers\clan\ClanTree;


use App\Http\Controllers\shield\ShieldInsight;
use App\Http\Controllers\shield\ShieldInsightcrm;

use App\Http\Controllers\school\SchoolStudent;
use App\Http\Controllers\school\SchoolTeacher;

use App\Http\Controllers\modbus\ModbusRishabh;
use App\Http\Controllers\modbus\ModbusAccuenergy;
use App\Http\Controllers\modbus\ModbusAcuvimL;
use App\Http\Controllers\techvault\TechvaultInternalwiki;


// Login form
Route::view('/login', 'auth.login')->name('login');
// Handle auth
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Route::middleware(['auth'])->group(function () {

Route::middleware(['role:1'])->group(function () {
  // Digitize
    Route::get('/crm/dashboard', [CrmDashboard::class, 'index'])->name('crm-dashboard');

  // Customer
    Route::get('/crm/customer', [CrmCustomer::class, 'index'])->name('crm-customer');
    Route::get('/crm/customer/data', [CrmCustomer::class, 'customer_data'])->name('crm-customer-data');
    Route::post('/crm/customer/create', [CrmCustomer::class, 'create'])->name('crm-customer-create');
    Route::get('/crm/customer/view/{id_customer}', [CrmCustomer::class, 'customer_view'])->name('crm-customer-view');
    Route::post('/crm/customer/edit/{id_customer}', [CrmCustomer::class, 'customer_edit'])->name('crm-customer-edit');
    Route::get('/crm/customer/destroy', [CrmCustomer::class, 'customer_destroy'])->name('crm-customer-destroy');

  // Visit Report AII
    Route::get('/crm/visit-report', [CrmVisitReport::class, 'index'])->name('crm-visit-report');
    Route::get('/crm/visit-report/data', [CrmVisitReport::class, 'visit_report_data'])->name('crm-visit-report-data');
    Route::post('/crm/visit-report/create', [CrmVisitReport::class, 'create'])->name('crm-visit-report-create');
    Route::get('/crm/visit-report/view/{id_visit_report}', [CrmVisitReport::class, 'visit_report_view'])->name('crm-visit-report-view');
    Route::post('/crm/visit-report/edit/{id_visit_report}', [CrmVisitReport::class, 'visit_report_edit'])->name('crm-visit-report-edit');
    Route::post('/crm/visit-report/submit/{id_visit_report}', [CrmVisitReport::class, 'visit_report_submit'])->name('crm-visit-report-submit');
    Route::post('/crm/visit-report/ackmanager/{id_visit_report}', [CrmVisitReport::class, 'visit_report_ackmanager'])->name('crm-visit-report-ackmanager');
    Route::post('/crm/visit-report/ackdirector/{id_visit_report}', [CrmVisitReport::class, 'visit_report_ackdirector'])->name('crm-visit-report-ackdirector');
    Route::post('/crm/visit-report/ackpresdir/{id_visit_report}', [CrmVisitReport::class, 'visit_report_ackpresdir'])->name('crm-visit-report-ackpresdir');
    Route::post('/crm/visit-report/response/{id_visit_report}', [CrmVisitReport::class, 'visit_report_response'])->name('crm-visit-report-response');
    Route::post('/crm/visit-report/followup/{id_visit_report}', [CrmVisitReport::class, 'visit_report_followup'])->name('crm-visit-report-followup');
    Route::delete('/crm/visit-report/destroy/{id_visit_report}', [CrmVisitReport::class, 'visit_report_destroy'])->name('crm-visit-report-destroy');
    Route::post('/crm/visit-report/cancel/{id_visit_report}', [CrmVisitReport::class, 'visit_report_cancel'])->name('crm-visit-report-cancel');
    Route::post('/crm/visit-report/delete/{id_visit_report}', [CrmVisitReport::class, 'visit_report_delete'])->name('crm-visit-report-delete');

  // Visit Report SEP
    Route::get('/crm/visit-report-sep', [CrmVisitReportSep::class, 'index'])->name('crm-visit-report-sep');
    Route::get('/crm/visit-report-sep/data', [CrmVisitReportSep::class, 'visit_report_data'])->name('crm-visit-report-sep-data');
    Route::post('/crm/visit-report-sep/create', [CrmVisitReportSep::class, 'create'])->name('crm-visit-report-sep-create');
    Route::get('/crm/visit-report-sep/view/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_view'])->name('crm-visit-report-sep-view');
    Route::post('/crm/visit-report-sep/edit/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_edit'])->name('crm-visit-report-sep-edit');
    Route::post('/crm/visit-report-sep/submit/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_submit'])->name('crm-visit-report-sep-submit');
    Route::post('/crm/visit-report-sep/ackmanager/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_ackmanager'])->name('crm-visit-report-sep-ackmanager');
    Route::post('/crm/visit-report-sep/ackdirector/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_ackdirector'])->name('crm-visit-report-sep-ackdirector');
    Route::post('/crm/visit-report-sep/ackpresdir/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_ackpresdir'])->name('crm-visit-report-sep-ackpresdir');
    Route::post('/crm/visit-report-sep/response/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_response'])->name('crm-visit-report-sep-response');
    Route::post('/crm/visit-report-sep/followup/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_followup'])->name('crm-visit-report-sep-followup');
    Route::delete('/crm/visit-report-sep/destroy/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_destroy'])->name('crm-visit-report-sep-destroy');
    Route::post('/crm/visit-report-sep/cancel/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_cancel'])->name('crm-visit-report-sep-cancel');
    Route::post('/crm/visit-report-sep/delete/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_delete'])->name('crm-visit-report-sep-delete');

  // Calendar
    Route::get('/crm/calendar', [CrmCalendar::class, 'calendar_index'])->name('crm-calendar');
    Route::get('/crm/calendar/data', [CrmCalendar::class, 'calendar_data'])->name('crm-calendar');

  // Project
    Route::get('/crm/project', [CrmProject::class, 'index'])->name('crm-project');

  // Quotation
    Route::get('/crm/quotation', [CrmQuotation::class, 'index'])->name('crm-quotation');

  // Purchase Request
    Route::get('/crm/purchase-request', [CrmPurchaseRequest::class, 'index'])->name('crm-purchase-request');
    Route::get('/crm/purchase-request/data', [CrmPurchaseRequest::class, 'purchase_request_data'])->name('crm-purchase-request-data');
    Route::post('/crm/purchase-request/create', [CrmPurchaseRequest::class, 'create'])->name('crm-purchase-request-create');
    Route::get('/crm/purchase-request/view/{id_purchase_request}', [CrmPurchaseRequest::class, 'purchase_request_view'])->name('crm-purchase-request-view');
    Route::post('/crm/purchase-request/edit/{id_purchase_request}', [CrmPurchaseRequest::class, 'purchase_request_edit'])->name('crm-purchase-request-edit');
    Route::post('/crm/purchase-request/update-dp-date/{id_purchase_request}', [CrmPurchaseRequest::class, 'update_dp_date'])->name('crm-purchase-request-update-dp-date');
    Route::post('/crm/purchase-request/update-principal-po/{id_purchase_request}', [CrmPurchaseRequest::class, 'update_principal_po'])->name('crm-purchase-request-update-principal-po');
    Route::post('/crm/purchase-request/update-principal-delivery/{id_purchase_request}', [CrmPurchaseRequest::class, 'update_principal_delivery'])->name('crm-purchase-request-update-principal-delivery');
    Route::post('/crm/purchase-request/update-status/{id_purchase_request}', [CrmPurchaseRequest::class, 'update_status'])->name('crm-purchase-request-update-status');
    Route::get('/crm/purchase-request/items', [CrmPurchaseRequest::class, 'get_items'])->name('crm-purchase-request-items');
    Route::get('/crm/purchase-request/brands', [CrmPurchaseRequest::class, 'get_brands'])->name('crm-purchase-request-brands');
    Route::post('/crm/purchase-request/add-comment/{id_purchase_request}', [CrmPurchaseRequest::class, 'add_comment'])->name('crm-purchase-request-add-comment');
    Route::get('/crm/purchase-request/get-comments/{id_purchase_request}', [CrmPurchaseRequest::class, 'get_comments'])->name('crm-purchase-request-get-comments');
    Route::delete('/crm/purchase-request/delete-comment/{id_comment}', [CrmPurchaseRequest::class, 'delete_comment'])->name('crm-purchase-request-delete-comment');

  // Purchase Order
    Route::get('/crm/purchase-order', [CrmPurchaseOrder::class, 'index'])->name('crm-purchase-order');
    Route::get('/crm/purchase-order/data', [CrmPurchaseOrder::class, 'purchase_order_data'])->name('crm-purchase-order-data');
    Route::post('/crm/purchase-order/update-principal-po', [CrmPurchaseOrder::class, 'update_principal_po'])->name('crm-purchase-order-update-principal-po');
    Route::post('/crm/purchase-order/update-delivery-date', [CrmPurchaseOrder::class, 'update_delivery_date'])->name('crm-purchase-order-update-delivery-date');
    Route::post('/crm/purchase-order/update-status', [CrmPurchaseOrder::class, 'update_status'])->name('crm-purchase-order-update-status');
    Route::post('/crm/purchase-order/update-status-bulk', [CrmPurchaseOrder::class, 'update_status_bulk'])->name('crm-purchase-order-update-status-bulk');

  // Inquiry
    Route::get('/crm/inquiry', [CrmInquiry::class, 'index'])->name('crm-inquiry');
    Route::get('/crm/inquiry/data', [CrmInquiry::class, 'inquiry_data'])->name('crm-inquiry-data');
    Route::post('/crm/inquiry/create', [CrmInquiry::class, 'create'])->name('crm-inquiry-create');
    Route::get('/crm/inquiry/view/{id_inquiry}', [CrmInquiry::class, 'inquiry_view'])->name('crm-inquiry-view');
    Route::post('/crm/inquiry/edit/{id_inquiry}', [CrmInquiry::class, 'inquiry_edit'])->name('crm-inquiry-edit');
    Route::post('/crm/inquiry/batch-update', [CrmInquiry::class, 'inquiry_batch_update'])->name('crm-inquiry-batch-update');
    Route::get('/crm/inquiry/projects', [CrmInquiry::class, 'get_inquiry_projects'])->name('crm-inquiry-projects');
    Route::get('/crm/inquiry/project/{project_title}', [CrmInquiry::class, 'get_inquiry_by_project'])->name('crm-inquiry-by-project');

  // Labs Dashboard
    Route::get('/labs/dashboard', [LabsDashboard::class, 'index'])->name('labs-dashboard');

  // Labs Label
    Route::get('/labs/label', [LabsLabel::class, 'index'])->name('labs-label');
    Route::get('/labs/label/data', [LabsLabel::class, 'label_data'])->name('labs-label-data');
    Route::post('/labs/label/create', [LabsLabel::class, 'create'])->name('labs-label-create');
    Route::get('/labs/label/view/{id_label}', [LabsLabel::class, 'label_view'])->name('labs-label-view');
    Route::delete('/labs/label/destroy/{id_label}', [LabsLabel::class, 'label_destroy'])->name('labs-label-destroy');

  // Labs Report
    Route::get('/labs/label', [LabsLabel::class, 'index'])->name('labs-label');
    Route::get('/labs/label/data', [LabsLabel::class, 'label_data'])->name('labs-label-data');
    Route::post('/labs/label/create', [LabsLabel::class, 'create'])->name('labs-label-create');
    Route::get('/labs/label/view/{id_label}', [LabsLabel::class, 'label_view'])->name('labs-label-view');
    Route::delete('/labs/label/destroy/{id_label}', [LabsLabel::class, 'label_destroy'])->name('labs-label-destroy');

  // Monitoring

    Route::resource('/monitoring/home', MonitoringHome::class);

    Route::get('/monitoring/dashboard', [MonitoringDashboard::class, 'index'])->name('monitoring-dashboard');
    Route::get('/dashboard', [MonitoringDashboard::class, 'dashboard']);

    Route::get('/monitoring/installation', [MonitoringInstallation::class, 'index'])->name('monitoring-installation');
    Route::get('/monitoring/installation/facility/data', [MonitoringInstallation::class, 'installation_facility_data'])->name('monitoring-installation-facility-data');
    Route::post('/monitoring/installation/facility/create', [MonitoringInstallation::class, 'installation_facility_create'])->name('monitoring-installation-facility-create');
    Route::get('/monitoring/installation/device/data', [MonitoringInstallation::class, 'installation_device_data'])->name('monitoring-installation-device-data');
    Route::get('/monitoring/installation/device/data/notListed', [MonitoringInstallation::class, 'installation_device_data_not_listed'])->name('monitoring-installation-device-data-not-listed');
    Route::post('/monitoring/installation/device/create', [MonitoringInstallation::class, 'installation_device_create'])->name('monitoring-installation-device-create');
    Route::post('/monitoring/installation/device/bulkFacility', [MonitoringInstallation::class, 'installation_device_bulkFacility'])->name('monitoring-installation-device-bulkFacility');

    Route::get('/monitoring/analysis', [MonitoringAnalysis::class, 'index'])->name('monitoring-analysis');
    Route::get('/monitoring/analysis/energy', [MonitoringAnalysis::class, 'energy'])->name('monitoring-analysis-energy');
    Route::get('/monitoring/analysis/realtime', [MonitoringAnalysis::class, 'realtime'])->name('monitoring-analysis-realtime');
    Route::get('/monitoring/analysis/powerquality', [MonitoringAnalysis::class, 'powerquality'])->name('monitoring-analysis-powerquality');
    Route::get('/monitoring/analysis/data', [MonitoringAnalysis::class, 'analysis_getMonitoringTree'])->name('monitoring-analysis-getMonitoringTree');
    Route::post('/monitoring/analysis/selectdata', [MonitoringAnalysis::class, 'analysis_selectdata'])->name('monitoring-analysis-selectdata');

    Route::get('/monitoring/trend', [MonitoringTrend::class, 'realtime'])->name('monitoring-trend');

    Route::get('/monitoring/datalog', [MonitoringDatalog::class, 'index'])->name('monitoring-datalog');
    Route::get('/monitoring/datalog/data', [MonitoringDatalog::class, 'datalog_getMonitoringTree'])->name('monitoring-datalog-getMonitoringTree');
    Route::post('/monitoring/datalog/selectdata', [MonitoringDatalog::class, 'datalog_selectdata'])->name('monitoring-datalog-selectdata');

  // Modbus Rishabh
    Route::get('/modbus/rish-con-m+', [ModbusRishabh::class, 'rish_con_m_plus'])->name('modbus-rish-con-m+');
    Route::get('/modbus/AO1', [ModbusRishabh::class, 'AO1'])->name('modbus-ao1');
    Route::get('/modbus/read/data/{address}/{count}', [ModbusRishabh::class, 'read_data'])->name('modbus-read-data');
    Route::post('/modbus/write/rish-con-m+', [ModbusRishabh::class, 'rish_con_m_plus_write'])->name('modbus-rish-con-m+-write');

  // Modbus Accuenergy AcuDC240
    Route::get('/modbus/acudc240', [ModbusAccuenergy::class, 'accuenergy_read'])->name('modbus-acudc240');
    Route::get('/modbus/acudc240/read/data/{address}/{count}', [ModbusAccuenergy::class, 'read_data'])->name('modbus-acudc240-read-data');
    Route::post('/modbus/acudc240/write', [ModbusAccuenergy::class, 'accuenergy_write'])->name('modbus-acudc240-write');
    Route::post('/modbus/acudc240/sync-time', [ModbusAccuenergy::class, 'sync_time'])->name('modbus-acudc240-sync-time');

  // Modbus Accuenergy Acuvim L-V4
    Route::get('/modbus/acuviml-v4', [ModbusAcuvimL::class, 'acuviml_read'])->name('modbus-acuviml-v4');
    Route::get('/modbus/acuviml-v4/read/data/{address}/{count}', [ModbusAcuvimL::class, 'read_data'])->name('modbus-acuviml-v4-read-data');
    Route::post('/modbus/acuviml-v4/write', [ModbusAcuvimL::class, 'acuviml_write'])->name('modbus-acuviml-v4-write');
    Route::post('/modbus/acuviml-v4/sync-time', [ModbusAcuvimL::class, 'sync_time'])->name('modbus-acuviml-v4-sync-time');

  // TechVault
    Route::get('/techvault/internalwiki', [TechvaultInternalwiki::class, 'index'])->name('techvault-internalwiki');

  // Engineering Wiki (manual routes)
    Route::get('/techvault/engineering/wiki', [\App\Http\Controllers\techvault\EngineeringWikiController::class, 'index'])->name('techvault-engineeringwiki');
    Route::get('/techvault/engineering/wiki/create', [\App\Http\Controllers\techvault\EngineeringWikiController::class, 'create'])->name('techvault-engineeringwiki.create');
    Route::post('/techvault/engineering/wiki', [\App\Http\Controllers\techvault\EngineeringWikiController::class, 'store'])->name('techvault-engineeringwiki.store');
    Route::get('/techvault/engineering/wiki/{engineeringWiki}', [\App\Http\Controllers\techvault\EngineeringWikiController::class, 'show'])->name('techvault-engineeringwiki.show');
    Route::get('/techvault/engineering/wiki/{engineeringWiki}/edit', [\App\Http\Controllers\techvault\EngineeringWikiController::class, 'edit'])->name('techvault-engineeringwiki.edit');
    Route::put('/techvault/engineering/wiki/{engineeringWiki}', [\App\Http\Controllers\techvault\EngineeringWikiController::class, 'update'])->name('techvault-engineeringwiki.update');
    Route::delete('/techvault/engineering/wiki/{engineeringWiki}', [\App\Http\Controllers\techvault\EngineeringWikiController::class, 'destroy'])->name('techvault-engineeringwiki.destroy');

  // Users
    Route::get('/users', [Users::class, 'index'])->name('users');
    Route::get('/users/data', [Users::class, 'users_data'])->name('users-data');
    Route::get('/users/view/{id}', [Users::class, 'users_view'])->name('users-view');
    Route::get('/users/change/{id}', [Users::class, 'users_change_password'])->name('users-change-password');
    Route::post('/users/change/{id}', [Users::class, 'users_update_password'])->name('users-update-password');
    Route::delete('/users/destroy/{id}', [Users::class, 'users_destroy'])->name('users-destroy');

  // Zerotest
    Route::get('/dev/zerotest', [DevZerotest::class, 'index'])->name('dev-zerotest');

  // Insight
    Route::get('/insight', [ShieldInsight::class, 'index'])->name('insight');
  // Insight CRM
    Route::get('/insight/crm', [ShieldInsightcrm::class, 'index'])->name('insight#crm');

    Route::get('/insight/crm/customer/data', [ShieldInsightcrm::class, 'crm_customer_data'])->name('insight#crm-customer-data');
    Route::get('/insight/crm/customer/view/{id_customer}', [ShieldInsightcrm::class, 'crm_customer_view'])->name('insight#crm-customer-view');
    Route::post('/insight/crm/customer/edit/{id_customer}', [ShieldInsightcrm::class, 'crm_customer_edit'])->name('insight#crm-customer-edit');

    Route::get('/insight/crm/visit-report/data', [ShieldInsightcrm::class, 'crm_visit_report_data'])->name('insight#crm-visit-report-data');
    Route::get('/insight/crm/visit-report/view/{id_visit-report}', [ShieldInsightcrm::class, 'crm_visit_report_view'])->name('insight#crm-visit-report-view');

    Route::get('/insight/crm/visit-report-sep/data', [ShieldInsightcrm::class, 'crm_visit_report_sep_data'])->name('insight#crm-visit-report-sep-data');
    Route::get('/insight/crm/visit-report-sep/view/{id_visit_report}', [ShieldInsightcrm::class, 'crm_visit_report_sep_view'])->name('insight#crm-visit-report-sep-view');

  // Clan
    Route::get('/clan/tree', [ClanTree::class, 'index'])->name('clan-tree');
    Route::get('/clan/tree/data', [ClanTree::class, 'tree_data'])->name('clan-tree-data');
    Route::post('/clan/tree/create', [ClanTree::class, 'tree_create'])->name('clan-tree-create');
    Route::get('/clan/tree/view/{id_tree}', [ClanTree::class, 'tree_view'])->name('clan-tree-view');
    Route::get('/clan/tree/edit/{id_tree}', [ClanTree::class, 'tree_edit'])->name('clan-tree-edit');
    Route::delete('/clan/tree/destroy', [ClanTree::class, 'tree_destroy'])->name('clan-tree-destroy');

  // All-Users
    Route::get('/all-users', [Users::class, 'all_users_index'])->name('all-users');
    Route::get('/all-users/data', [Users::class, 'all_users_data'])->name('all-users-data');

  // Main Page Route
    Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');
    Route::get('/dashboard/analytics', [Analytics::class, 'index'])->name('dashboard-analytics');
    Route::get('/dashboard/crm', [CrmOri::class, 'index'])->name('dashboard-crm');

  // locale
    Route::get('/lang/{locale}', [LanguageController::class, 'swap']);

  // layout
    Route::get('/layouts/collapsed-menu', [CollapsedMenu::class, 'index'])->name('layouts-collapsed-menu');
    Route::get('/layouts/content-navbar', [ContentNavbar::class, 'index'])->name('layouts-content-navbar');
    Route::get('/layouts/content-nav-sidebar', [ContentNavSidebar::class, 'index'])->name('layouts-content-nav-sidebar');
    Route::get('/layouts/navbar-full', [NavbarFull::class, 'index'])->name('layouts-navbar-full');
    Route::get('/layouts/navbar-full-sidebar', [NavbarFullSidebar::class, 'index'])->name('layouts-navbar-full-sidebar');
    Route::get('/layouts/horizontal', [Horizontal::class, 'index'])->name('dashboard-analytics');
    Route::get('/layouts/vertical', [Vertical::class, 'index'])->name('dashboard-analytics');
    Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
    Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
    Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
    Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
    Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

  // Front Pages
    Route::get('/front-pages/landing', [Landing::class, 'index'])->name('front-pages-landing');
    Route::get('/front-pages/pricing', [Pricing::class, 'index'])->name('front-pages-pricing');
    Route::get('/front-pages/payment', [Payment::class, 'index'])->name('front-pages-payment');
    Route::get('/front-pages/checkout', [Checkout::class, 'index'])->name('front-pages-checkout');
    Route::get('/front-pages/help-center', [HelpCenter::class, 'index'])->name('front-pages-help-center');
    Route::get('/front-pages/help-center-article', [HelpCenterArticle::class, 'index'])->name('front-pages-help-center-article');

  // apps
    Route::get('/app/email', [Email::class, 'index'])->name('app-email');
    Route::get('/app/chat', [Chat::class, 'index'])->name('app-chat');
    Route::get('/app/calendar', [Calendar::class, 'index'])->name('app-calendar');
    Route::get('/app/kanban', [Kanban::class, 'index'])->name('app-kanban');
    Route::get('/app/ecommerce/dashboard', [EcommerceDashboard::class, 'index'])->name('app-ecommerce-dashboard');
    Route::get('/app/ecommerce/product/list', [EcommerceProductList::class, 'index'])->name('app-ecommerce-product-list');
    Route::get('/app/ecommerce/product/add', [EcommerceProductAdd::class, 'index'])->name('app-ecommerce-product-add');
    Route::get('/app/ecommerce/product/category', [EcommerceProductCategory::class, 'index'])->name('app-ecommerce-product-category');
    Route::get('/app/ecommerce/order/list', [EcommerceOrderList::class, 'index'])->name('app-ecommerce-order-list');
    Route::get('/app/ecommerce/order/details', [EcommerceOrderDetails::class, 'index'])->name('app-ecommerce-order-details');
    Route::get('/app/ecommerce/customer/all', [EcommerceCustomerAll::class, 'index'])->name('app-ecommerce-customer-all');
    Route::get('/app/ecommerce/customer/details/overview', [EcommerceCustomerDetailsOverview::class, 'index'])->name('app-ecommerce-customer-details-overview');
    Route::get('/app/ecommerce/customer/details/security', [EcommerceCustomerDetailsSecurity::class, 'index'])->name('app-ecommerce-customer-details-security');
    Route::get('/app/ecommerce/customer/details/billing', [EcommerceCustomerDetailsBilling::class, 'index'])->name('app-ecommerce-customer-details-billing');
    Route::get('/app/ecommerce/customer/details/notifications', [EcommerceCustomerDetailsNotifications::class, 'index'])->name('app-ecommerce-customer-details-notifications');
    Route::get('/app/ecommerce/manage/reviews', [EcommerceManageReviews::class, 'index'])->name('app-ecommerce-manage-reviews');
    Route::get('/app/ecommerce/referrals', [EcommerceReferrals::class, 'index'])->name('app-ecommerce-referrals');
    Route::get('/app/ecommerce/settings/details', [EcommerceSettingsDetails::class, 'index'])->name('app-ecommerce-settings-details');
    Route::get('/app/ecommerce/settings/payments', [EcommerceSettingsPayments::class, 'index'])->name('app-ecommerce-settings-payments');
    Route::get('/app/ecommerce/settings/checkout', [EcommerceSettingsCheckout::class, 'index'])->name('app-ecommerce-settings-checkout');
    Route::get('/app/ecommerce/settings/shipping', [EcommerceSettingsShipping::class, 'index'])->name('app-ecommerce-settings-shipping');
    Route::get('/app/ecommerce/settings/locations', [EcommerceSettingsLocations::class, 'index'])->name('app-ecommerce-settings-locations');
    Route::get('/app/ecommerce/settings/notifications', [EcommerceSettingsNotifications::class, 'index'])->name('app-ecommerce-settings-notifications');
    Route::get('/app/academy/dashboard', [AcademyDashboard::class, 'index'])->name('app-academy-dashboard');
    Route::get('/app/academy/course', [AcademyCourse::class, 'index'])->name('app-academy-course');
    Route::get('/app/academy/course-details', [AcademyCourseDetails::class, 'index'])->name('app-academy-course-details');
    Route::get('/app/logistics/dashboard', [LogisticsDashboard::class, 'index'])->name('app-logistics-dashboard');
    Route::get('/app/logistics/fleet', [LogisticsFleet::class, 'index'])->name('app-logistics-fleet');
    Route::get('/app/invoice/list', [InvoiceList::class, 'index'])->name('app-invoice-list');
    Route::get('/app/invoice/preview', [InvoicePreview::class, 'index'])->name('app-invoice-preview');
    Route::get('/app/invoice/print', [InvoicePrint::class, 'index'])->name('app-invoice-print');
    Route::get('/app/invoice/edit', [InvoiceEdit::class, 'index'])->name('app-invoice-edit');
    Route::get('/app/invoice/add', [InvoiceAdd::class, 'index'])->name('app-invoice-add');
    Route::get('/app/user/list', [UserList::class, 'index'])->name('app-user-list');
    Route::get('/app/user/view/account', [UserViewAccount::class, 'index'])->name('app-user-view-account');
    Route::get('/app/user/view/security', [UserViewSecurity::class, 'index'])->name('app-user-view-security');
    Route::get('/app/user/view/billing', [UserViewBilling::class, 'index'])->name('app-user-view-billing');
    Route::get('/app/user/view/notifications', [UserViewNotifications::class, 'index'])->name('app-user-view-notifications');
    Route::get('/app/user/view/connections', [UserViewConnections::class, 'index'])->name('app-user-view-connections');
    Route::get('/app/access-roles', [AccessRoles::class, 'index'])->name('app-access-roles');
    Route::get('/app/access-permission', [AccessPermission::class, 'index'])->name('app-access-permission');

  // pages
    Route::get('/pages/profile-user', [UserProfile::class, 'index'])->name('pages-profile-user');
    Route::get('/pages/profile-teams', [UserTeams::class, 'index'])->name('pages-profile-teams');
    Route::get('/pages/profile-projects', [UserProjects::class, 'index'])->name('pages-profile-projects');
    Route::get('/pages/profile-connections', [UserConnections::class, 'index'])->name('pages-profile-connections');
    Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
    Route::get('/pages/account-settings-security', [AccountSettingsSecurity::class, 'index'])->name('pages-account-settings-security');
    Route::get('/pages/account-settings-billing', [AccountSettingsBilling::class, 'index'])->name('pages-account-settings-billing');
    Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
    Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
    Route::get('/pages/faq', [Faq::class, 'index'])->name('pages-faq');
    Route::get('/pages/pricing', [PagesPricing::class, 'index'])->name('pages-pricing');
    Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
    Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');
    Route::get('/pages/misc-comingsoon', [MiscComingSoon::class, 'index'])->name('pages-misc-comingsoon');
    Route::get('/pages/misc-not-authorized', [MiscNotAuthorized::class, 'index'])->name('pages-misc-not-authorized');

  // authentication
    Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
    Route::get('/auth/login-cover', [LoginCover::class, 'index'])->name('auth-login-cover');
    Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
    Route::get('/auth/register-cover', [RegisterCover::class, 'index'])->name('auth-register-cover');
    Route::get('/auth/register-multisteps', [RegisterMultiSteps::class, 'index'])->name('auth-register-multisteps');
    Route::get('/auth/verify-email-basic', [VerifyEmailBasic::class, 'index'])->name('auth-verify-email-basic');
    Route::get('/auth/verify-email-cover', [VerifyEmailCover::class, 'index'])->name('auth-verify-email-cover');
    Route::get('/auth/reset-password-basic', [ResetPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
    Route::get('/auth/reset-password-cover', [ResetPasswordCover::class, 'index'])->name('auth-reset-password-cover');
    Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
    Route::get('/auth/forgot-password-cover', [ForgotPasswordCover::class, 'index'])->name('auth-forgot-password-cover');
    Route::get('/auth/two-steps-basic', [TwoStepsBasic::class, 'index'])->name('auth-two-steps-basic');
    Route::get('/auth/two-steps-cover', [TwoStepsCover::class, 'index'])->name('auth-two-steps-cover');

  // wizard example
    Route::get('/wizard/ex-checkout', [WizardCheckout::class, 'index'])->name('wizard-ex-checkout');
    Route::get('/wizard/ex-property-listing', [PropertyListing::class, 'index'])->name('wizard-ex-property-listing');
    Route::get('/wizard/ex-create-deal', [CreateDeal::class, 'index'])->name('wizard-ex-create-deal');

  // modal
    Route::get('/modal-examples', [ModalExample::class, 'index'])->name('modal-examples');

  // cards
    Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');
    Route::get('/cards/advance', [CardAdvance::class, 'index'])->name('cards-advance');
    Route::get('/cards/statistics', [CardStatistics::class, 'index'])->name('cards-statistics');
    Route::get('/cards/analytics', [CardAnalytics::class, 'index'])->name('cards-analytics');
    Route::get('/cards/gamifications', [CardGamifications::class, 'index'])->name('cards-gamifications');
    Route::get('/cards/actions', [CardActions::class, 'index'])->name('cards-actions');

  // User Interface
    Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
    Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
    Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
    Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
    Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
    Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
    Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
    Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
    Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
    Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
    Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
    Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
    Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
    Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
    Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
    Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
    Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
    Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
    Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

  // extended ui
    Route::get('/extended/ui-avatar', [Avatar::class, 'index'])->name('extended-ui-avatar');
    Route::get('/extended/ui-blockui', [BlockUI::class, 'index'])->name('extended-ui-blockui');
    Route::get('/extended/ui-drag-and-drop', [DragAndDrop::class, 'index'])->name('extended-ui-drag-and-drop');
    Route::get('/extended/ui-media-player', [MediaPlayer::class, 'index'])->name('extended-ui-media-player');
    Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
    Route::get('/extended/ui-star-ratings', [StarRatings::class, 'index'])->name('extended-ui-star-ratings');
    Route::get('/extended/ui-sweetalert2', [SweetAlert::class, 'index'])->name('extended-ui-sweetalert2');
    Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');
    Route::get('/extended/ui-timeline-basic', [TimelineBasic::class, 'index'])->name('extended-ui-timeline-basic');
    Route::get('/extended/ui-timeline-fullscreen', [TimelineFullscreen::class, 'index'])->name('extended-ui-timeline-fullscreen');
    Route::get('/extended/ui-tour', [Tour::class, 'index'])->name('extended-ui-tour');
    Route::get('/extended/ui-treeview', [Treeview::class, 'index'])->name('extended-ui-treeview');
    Route::get('/extended/ui-misc', [Misc::class, 'index'])->name('extended-ui-misc');

  // icons
    Route::get('/icons/tabler', [Tabler::class, 'index'])->name('icons-tabler');
    Route::get('/icons/font-awesome', [FontAwesome::class, 'index'])->name('icons-font-awesome');

  // form elements
    Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
    Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');
    Route::get('/forms/custom-options', [CustomOptions::class, 'index'])->name('forms-custom-options');
    Route::get('/forms/editors', [Editors::class, 'index'])->name('forms-editors');
    Route::get('/forms/file-upload', [FileUpload::class, 'index'])->name('forms-file-upload');
    Route::get('/forms/pickers', [Picker::class, 'index'])->name('forms-pickers');
    Route::get('/forms/selects', [Selects::class, 'index'])->name('forms-selects');
    Route::get('/forms/sliders', [Sliders::class, 'index'])->name('forms-sliders');
    Route::get('/forms/switches', [Switches::class, 'index'])->name('forms-switches');
    Route::get('/forms/extras', [Extras::class, 'index'])->name('forms-extras');

  // form layouts
    Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
    Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');
    Route::get('/form/layouts-sticky', [StickyActions::class, 'index'])->name('form-layouts-sticky');

  // form wizards
    Route::get('/form/wizard-numbered', [FormWizardNumbered::class, 'index'])->name('form-wizard-numbered');
    Route::get('/form/wizard-icons', [FormWizardIcons::class, 'index'])->name('form-wizard-icons');
    Route::get('/form/validation', [Validation::class, 'index'])->name('form-validation');

  // tables
    Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
    Route::get('/tables/datatables-basic', [DatatableBasic::class, 'index'])->name('tables-datatables-basic');
    Route::get('/tables/datatables-advanced', [DatatableAdvanced::class, 'index'])->name('tables-datatables-advanced');
    Route::get('/tables/datatables-extensions', [DatatableExtensions::class, 'index'])->name('tables-datatables-extensions');

  // charts
    Route::get('/charts/apex', [ApexCharts::class, 'index'])->name('charts-apex');
    Route::get('/charts/chartjs', [ChartJs::class, 'index'])->name('charts-chartjs');

  // maps
    Route::get('/maps/leaflet', [Leaflet::class, 'index'])->name('maps-leaflet');

  // laravel example
    Route::get('/laravel/user-management', [UserManagement::class, 'UserManagement'])->name('laravel-example-user-management');
    Route::resource('/user-list', UserManagement::class);
});

Route::middleware(['role:1,2,4,5,6,8,45'])->group(function () {
  // Digitize
    Route::get('/crm/dashboard', [CrmDashboard::class, 'index'])->name('crm-dashboard');

  // Customer
    Route::get('/crm/customer', [CrmCustomer::class, 'index'])->name('crm-customer');
    Route::get('/crm/customer/data', [CrmCustomer::class, 'customer_data'])->name('crm-customer-data');
    Route::post('/crm/customer/create', [CrmCustomer::class, 'create'])->name('crm-customer-create');
    Route::get('/crm/customer/view/{id_customer}', [CrmCustomer::class, 'customer_view'])->name('crm-customer-view');
    Route::post('/crm/customer/edit/{id_customer}', [CrmCustomer::class, 'customer_edit'])->name('crm-customer-edit');
    Route::get('/crm/customer/destroy', [CrmCustomer::class, 'customer_destroy'])->name('crm-customer-destroy');

  // Visit Report AII
    Route::get('/crm/visit-report', [CrmVisitReport::class, 'index'])->name('crm-visit-report');
    Route::get('/crm/visit-report/data', [CrmVisitReport::class, 'visit_report_data'])->name('crm-visit-report-data');
    Route::post('/crm/visit-report/create', [CrmVisitReport::class, 'create'])->name('crm-visit-report-create');
    Route::get('/crm/visit-report/view/{id_visit_report}', [CrmVisitReport::class, 'visit_report_view'])->name('crm-visit-report-view');
    Route::post('/crm/visit-report/edit/{id_visit_report}', [CrmVisitReport::class, 'visit_report_edit'])->name('crm-visit-report-edit');
    Route::post('/crm/visit-report/submit/{id_visit_report}', [CrmVisitReport::class, 'visit_report_submit'])->name('crm-visit-report-submit');
    Route::post('/crm/visit-report/ackmanager/{id_visit_report}', [CrmVisitReport::class, 'visit_report_ackmanager'])->name('crm-visit-report-ackmanager');
    Route::post('/crm/visit-report/ackdirector/{id_visit_report}', [CrmVisitReport::class, 'visit_report_ackdirector'])->name('crm-visit-report-ackdirector');
    Route::post('/crm/visit-report/ackpresdir/{id_visit_report}', [CrmVisitReport::class, 'visit_report_ackpresdir'])->name('crm-visit-report-ackpresdir');
    Route::post('/crm/visit-report/response/{id_visit_report}', [CrmVisitReport::class, 'visit_report_response'])->name('crm-visit-report-response');
    Route::post('/crm/visit-report/followup/{id_visit_report}', [CrmVisitReport::class, 'visit_report_followup'])->name('crm-visit-report-followup');
    Route::delete('/crm/visit-report/destroy/{id_visit_report}', [CrmVisitReport::class, 'visit_report_destroy'])->name('crm-visit-report-destroy');
    Route::post('/crm/visit-report/cancel/{id_visit_report}', [CrmVisitReport::class, 'visit_report_cancel'])->name('crm-visit-report-cancel');
    Route::post('/crm/visit-report/delete/{id_visit_report}', [CrmVisitReport::class, 'visit_report_delete'])->name('crm-visit-report-delete');

  // Visit Report SEP
    Route::get('/crm/visit-report-sep', [CrmVisitReportSep::class, 'index'])->name('crm-visit-report-sep');
    Route::get('/crm/visit-report-sep/data', [CrmVisitReportSep::class, 'visit_report_data'])->name('crm-visit-report-sep-data');
    Route::post('/crm/visit-report-sep/create', [CrmVisitReportSep::class, 'create'])->name('crm-visit-report-sep-create');
    Route::get('/crm/visit-report-sep/view/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_view'])->name('crm-visit-report-sep-view');
    Route::post('/crm/visit-report-sep/edit/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_edit'])->name('crm-visit-report-sep-edit');
    Route::post('/crm/visit-report-sep/submit/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_submit'])->name('crm-visit-report-sep-submit');
    Route::post('/crm/visit-report-sep/ackmanager/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_ackmanager'])->name('crm-visit-report-sep-ackmanager');
    Route::post('/crm/visit-report-sep/ackdirector/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_ackdirector'])->name('crm-visit-report-sep-ackdirector');
    Route::post('/crm/visit-report-sep/ackpresdir/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_ackpresdir'])->name('crm-visit-report-sep-ackpresdir');
    Route::post('/crm/visit-report-sep/response/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_response'])->name('crm-visit-report-sep-response');
    Route::post('/crm/visit-report-sep/followup/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_followup'])->name('crm-visit-report-sep-followup');
    Route::delete('/crm/visit-report-sep/destroy/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_destroy'])->name('crm-visit-report-sep-destroy');
    Route::post('/crm/visit-report-sep/cancel/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_cancel'])->name('crm-visit-report-sep-cancel');
    Route::post('/crm/visit-report-sep/delete/{id_visit_report}', [CrmVisitReportSep::class, 'visit_report_delete'])->name('crm-visit-report-sep-delete');
  // Indent
    Route::get('/indent', [IndentHome::class, 'index'])->name('indent');

  // Users
    Route::get('/users', [Users::class, 'index'])->name('users');
    Route::get('/users/data', [Users::class, 'users_data'])->name('users-data');
    Route::get('/users/view/{id}', [Users::class, 'users_view'])->name('users-view');
    Route::get('/users/change/{id}', [Users::class, 'users_change_password'])->name('users-change-password');
    Route::post('/users/change/{id}', [Users::class, 'users_update_password'])->name('users-update-password');
    Route::delete('/users/destroy/{id}', [Users::class, 'users_destroy'])->name('users-destroy');

  // Calendar
    Route::get('/crm/calendar', [CrmCalendar::class, 'calendar_index'])->name('crm-calendar');
    Route::get('/crm/calendar/data', [CrmCalendar::class, 'calendar_data'])->name('crm-calendar');

  // Project
    Route::get('/crm/project', [CrmProject::class, 'index'])->name('crm-project');

  // Quotation
    Route::get('/crm/quotation', [CrmQuotation::class, 'index'])->name('crm-quotation');

  // Purchase Request
    Route::get('/crm/purchase-request', [CrmPurchaseRequest::class, 'index'])->name('crm-purchase-request');
    Route::get('/crm/purchase-request/data', [CrmPurchaseRequest::class, 'purchase_request_data'])->name('crm-purchase-request-data');
    Route::post('/crm/purchase-request/create', [CrmPurchaseRequest::class, 'create'])->name('crm-purchase-request-create');
    Route::get('/crm/purchase-request/view/{id_purchase_request}', [CrmPurchaseRequest::class, 'purchase_request_view'])->name('crm-purchase-request-view');
    Route::post('/crm/purchase-request/edit/{id_purchase_request}', [CrmPurchaseRequest::class, 'purchase_request_edit'])->name('crm-purchase-request-edit');
    Route::post('/crm/purchase-request/update-dp-date/{id_purchase_request}', [CrmPurchaseRequest::class, 'update_dp_date'])->name('crm-purchase-request-update-dp-date');
    Route::post('/crm/purchase-request/update-principal-po/{id_purchase_request}', [CrmPurchaseRequest::class, 'update_principal_po'])->name('crm-purchase-request-update-principal-po');
    Route::post('/crm/purchase-request/update-principal-delivery/{id_purchase_request}', [CrmPurchaseRequest::class, 'update_principal_delivery'])->name('crm-purchase-request-update-principal-delivery');
    Route::post('/crm/purchase-request/update-status/{id_purchase_request}', [CrmPurchaseRequest::class, 'update_status'])->name('crm-purchase-request-update-status');
    Route::get('/crm/purchase-request/items', [CrmPurchaseRequest::class, 'get_items'])->name('crm-purchase-request-items');
    Route::get('/crm/purchase-request/brands', [CrmPurchaseRequest::class, 'get_brands'])->name('crm-purchase-request-brands');
    Route::post('/crm/purchase-request/add-comment/{id_purchase_request}', [CrmPurchaseRequest::class, 'add_comment'])->name('crm-purchase-request-add-comment');
    Route::get('/crm/purchase-request/get-comments/{id_purchase_request}', [CrmPurchaseRequest::class, 'get_comments'])->name('crm-purchase-request-get-comments');
    Route::delete('/crm/purchase-request/delete-comment/{id_comment}', [CrmPurchaseRequest::class, 'delete_comment'])->name('crm-purchase-request-delete-comment');

  // Purchase Order
    Route::get('/crm/purchase-order', [CrmPurchaseOrder::class, 'index'])->name('crm-purchase-order');
    Route::get('/crm/purchase-order/data', [CrmPurchaseOrder::class, 'purchase_order_data'])->name('crm-purchase-order-data');
    Route::post('/crm/purchase-order/update-principal-po', [CrmPurchaseOrder::class, 'update_principal_po'])->name('crm-purchase-order-update-principal-po');
    Route::post('/crm/purchase-order/update-delivery-date', [CrmPurchaseOrder::class, 'update_delivery_date'])->name('crm-purchase-order-update-delivery-date');
    Route::post('/crm/purchase-order/update-status', [CrmPurchaseOrder::class, 'update_status'])->name('crm-purchase-order-update-status');
    Route::post('/crm/purchase-order/update-status-bulk', [CrmPurchaseOrder::class, 'update_status_bulk'])->name('crm-purchase-order-update-status-bulk');

  // Inquiry
    Route::get('/crm/inquiry', [CrmInquiry::class, 'index'])->name('crm-inquiry');
    Route::get('/crm/inquiry/data', [CrmInquiry::class, 'inquiry_data'])->name('crm-inquiry-data');
    Route::post('/crm/inquiry/create', [CrmInquiry::class, 'create'])->name('crm-inquiry-create');
    Route::get('/crm/inquiry/view/{id_inquiry}', [CrmInquiry::class, 'inquiry_view'])->name('crm-inquiry-view');
    Route::post('/crm/inquiry/edit/{id_inquiry}', [CrmInquiry::class, 'inquiry_edit'])->name('crm-inquiry-edit');
    Route::post('/crm/inquiry/batch-update', [CrmInquiry::class, 'inquiry_batch_update'])->name('crm-inquiry-batch-update');
    Route::get('/crm/inquiry/projects', [CrmInquiry::class, 'get_inquiry_projects'])->name('crm-inquiry-projects');
    Route::get('/crm/inquiry/project/{project_title}', [CrmInquiry::class, 'get_inquiry_by_project'])->name('crm-inquiry-by-project');

  // Labs Dashboard
    Route::get('/labs/dashboard', [LabsDashboard::class, 'index'])->name('labs-dashboard');

  // Labs Label
    Route::get('/labs/label', [LabsLabel::class, 'index'])->name('labs-label');
    Route::get('/labs/label/data', [LabsLabel::class, 'label_data'])->name('labs-label-data');
    Route::post('/labs/label/create', [LabsLabel::class, 'create'])->name('labs-label-create');
    Route::get('/labs/label/view/{id_label}', [LabsLabel::class, 'label_view'])->name('labs-label-view');
    Route::delete('/labs/label/destroy/{id_label}', [LabsLabel::class, 'label_destroy'])->name('labs-label-destroy');

  // Labs Report
    Route::get('/labs/label', [LabsLabel::class, 'index'])->name('labs-label');
    Route::get('/labs/label/data', [LabsLabel::class, 'label_data'])->name('labs-label-data');
    Route::post('/labs/label/create', [LabsLabel::class, 'create'])->name('labs-label-create');
    Route::get('/labs/label/view/{id_label}', [LabsLabel::class, 'label_view'])->name('labs-label-view');
    Route::delete('/labs/label/destroy/{id_label}', [LabsLabel::class, 'label_destroy'])->name('labs-label-destroy');

  // Monitoring
    Route::resource('/monitoring/home', MonitoringHome::class);

    Route::get('/monitoring/dashboard', [MonitoringDashboard::class, 'index'])->name('monitoring-dashboard');
    Route::get('/dashboard', [MonitoringDashboard::class, 'dashboard']);

    Route::get('/monitoring/installation', [MonitoringInstallation::class, 'index'])->name('monitoring-installation');
    Route::get('/monitoring/installation/facility/data', [MonitoringInstallation::class, 'installation_facility_data'])->name('monitoring-installation-facility-data');
    Route::post('/monitoring/installation/facility/create', [MonitoringInstallation::class, 'installation_facility_create'])->name('monitoring-installation-facility-create');
    Route::get('/monitoring/installation/device/data', [MonitoringInstallation::class, 'installation_device_data'])->name('monitoring-installation-device-data');
    Route::get('/monitoring/installation/device/data/notListed', [MonitoringInstallation::class, 'installation_device_data_not_listed'])->name('monitoring-installation-device-data-not-listed');
    Route::post('/monitoring/installation/device/create', [MonitoringInstallation::class, 'installation_device_create'])->name('monitoring-installation-device-create');
    Route::post('/monitoring/installation/device/bulkFacility', [MonitoringInstallation::class, 'installation_device_bulkFacility'])->name('monitoring-installation-device-bulkFacility');

    Route::get('/monitoring/analysis', [MonitoringAnalysis::class, 'index'])->name('monitoring-analysis');
    Route::get('/monitoring/analysis/energy', [MonitoringAnalysis::class, 'energy'])->name('monitoring-analysis-energy');
    Route::get('/monitoring/analysis/realtime', [MonitoringAnalysis::class, 'realtime'])->name('monitoring-analysis-realtime');
    Route::get('/monitoring/analysis/powerquality', [MonitoringAnalysis::class, 'powerquality'])->name('monitoring-analysis-powerquality');
    Route::get('/monitoring/analysis/data', [MonitoringAnalysis::class, 'analysis_getMonitoringTree'])->name('monitoring-analysis-getMonitoringTree');
    Route::post('/monitoring/analysis/selectdata', [MonitoringAnalysis::class, 'analysis_selectdata'])->name('monitoring-analysis-selectdata');

    Route::get('/monitoring/datalog', [MonitoringDatalog::class, 'index'])->name('monitoring-datalog');
    Route::get('/monitoring/datalog/data', [MonitoringDatalog::class, 'datalog_getMonitoringTree'])->name('monitoring-datalog-getMonitoringTree');
    Route::post('/monitoring/datalog/selectdata', [MonitoringDatalog::class, 'datalog_selectdata'])->name('monitoring-datalog-selectdata');

  // ===================================================
  // PROCUREMENT MANAGEMENT SYSTEM
  // ===================================================

  // Procurement Main Route
    Route::get('/procurement', [ProcurementDashboardController::class, 'index'])->name('procurement.index');

  // Procurement Routes - Following existing role pattern
    // Procurement Routes - Individual Routes (without prefix grouping)

    // Dashboard Routes
    Route::get('/procurement-dashboard-sales', [ProcurementDashboardController::class, 'sales'])->name('procurement.dashboard.sales');
    Route::get('/procurement-dashboard-purchasing', [ProcurementDashboardController::class, 'purchasing'])->name('procurement.dashboard.purchasing');
    Route::get('/procurement-dashboard-manager', [ProcurementDashboardController::class, 'manager'])->name('procurement.dashboard.manager');

    // Procurement Requests - Resource Routes
    Route::get('/procurement/requests', [ProcurementRequestController::class, 'index'])->name('procurement.requests.index');
    Route::get('/procurement/requests/create', [ProcurementRequestController::class, 'create'])->name('procurement.requests.create');
    Route::post('/procurement/requests', [ProcurementRequestController::class, 'store'])->name('procurement.requests.store');
    Route::get('/procurement/requests/{request}', [ProcurementRequestController::class, 'show'])->name('procurement.requests.show');
    Route::get('/procurement/requests/{request}/edit', [ProcurementRequestController::class, 'edit'])->name('procurement.requests.edit');
    Route::put('/procurement/requests/{request}', [ProcurementRequestController::class, 'update'])->name('procurement.requests.update');
    Route::delete('/procurement/requests/{request}', [ProcurementRequestController::class, 'destroy'])->name('procurement.requests.destroy');

    // Procurement Requests - Additional Routes
    Route::get('/procurement/requests/data', [ProcurementRequestController::class, 'data'])->name('procurement.requests.data');
    Route::post('/procurement/requests/{request}/submit', [ProcurementRequestController::class, 'submit'])->name('procurement.requests.submit');
    Route::post('/procurement/requests/{request}/ackmanager', [ProcurementRequestController::class, 'ack_manager'])->name('procurement.requests.ack_manager');
    Route::post('/procurement/requests/{request}/ackdirector', [ProcurementRequestController::class, 'ack_director'])->name('procurement.requests.ack_director');
    Route::post('/procurement/requests/{request}/approve', [ProcurementRequestController::class, 'approve'])->name('procurement.requests.approve');
    Route::post('/procurement/requests/{request}/reject', [ProcurementRequestController::class, 'reject'])->name('procurement.requests.reject');
    Route::post('/procurement/requests/{request}/cancel', [ProcurementRequestController::class, 'cancel'])->name('procurement.requests.cancel');
    Route::post('/procurement/requests/{request}/confirm-delivery', [ProcurementRequestController::class, 'confirmDelivery'])->name('procurement.requests.confirm_delivery');
    Route::post('/procurement/requests/{request}/complete', [ProcurementRequestController::class, 'complete'])->name('procurement.requests.complete');
    Route::get('/procurement/requests/{request}/export-pdf', [ProcurementRequestController::class, 'exportPdf'])->name('procurement.requests.export_pdf');
    Route::get('/procurement/requests/export-excel', [ProcurementRequestController::class, 'exportExcel'])->name('procurement.requests.export_excel');

    // Procurement Items Routes
    Route::get('/procurement/requests/{request}/items', [ProcurementItemController::class, 'index'])->name('procurement.items.index');
    Route::post('/procurement/requests/{request}/items', [ProcurementItemController::class, 'store'])->name('procurement.items.store');
    Route::get('/procurement/requests/{request}/items/{item}', [ProcurementItemController::class, 'show'])->name('procurement.items.show');
    Route::put('/procurement/requests/{request}/items/{item}', [ProcurementItemController::class, 'update'])->name('procurement.items.update');
    Route::delete('/procurement/requests/{request}/items/{item}', [ProcurementItemController::class, 'destroy'])->name('procurement.items.destroy');
    Route::post('/procurement/requests/{request}/items/{item}/order', [ProcurementItemController::class, 'markAsOrdered'])->name('procurement.items.order');
    Route::post('/procurement/requests/{request}/items/{item}/production', [ProcurementItemController::class, 'markAsProduction'])->name('procurement.items.production');
    Route::post('/procurement/requests/{request}/items/{item}/shipping', [ProcurementItemController::class, 'markAsShipping'])->name('procurement.items.shipping');
    Route::post('/procurement/requests/{request}/items/{item}/cancel', [ProcurementItemController::class, 'cancel'])->name('procurement.items.cancel');

    // Arrival Management Routes
    Route::get('/procurement/arrivals', [ProcurementArrivalController::class, 'index'])->name('procurement.arrivals.index');
    Route::get('/procurement/arrivals/data', [ProcurementArrivalController::class, 'data'])->name('procurement.arrivals.data');
    Route::post('/procurement/arrivals/record', [ProcurementArrivalController::class, 'record'])->name('procurement.arrivals.record');
    Route::get('/procurement/arrivals/{arrival}', [ProcurementArrivalController::class, 'show'])->name('procurement.arrivals.show');
    Route::delete('/procurement/arrivals/{arrival}', [ProcurementArrivalController::class, 'destroy'])->name('procurement.arrivals.destroy');
    Route::get('/procurement/arrivals/warehouses', [ProcurementArrivalController::class, 'getWarehouses'])->name('procurement.arrivals.warehouses');
    Route::post('/procurement/arrivals/bulk-record', [ProcurementArrivalController::class, 'bulkRecord'])->name('procurement.arrivals.bulk_record');

    // Purchase Orders - Resource Routes
    Route::get('/procurement/purchase-orders', [ProcurementPurchaseOrderController::class, 'index'])->name('procurement.po.index');
    Route::get('/procurement/purchase-orders/create', [ProcurementPurchaseOrderController::class, 'create'])->name('procurement.po.create');
    Route::post('/procurement/purchase-orders', [ProcurementPurchaseOrderController::class, 'store'])->name('procurement.po.store');
    Route::get('/procurement/purchase-orders/{purchase_order}', [ProcurementPurchaseOrderController::class, 'show'])->name('procurement.po.show');
    Route::get('/procurement/purchase-orders/{purchase_order}/edit', [ProcurementPurchaseOrderController::class, 'edit'])->name('procurement.po.edit');
    Route::put('/procurement/purchase-orders/{purchase_order}', [ProcurementPurchaseOrderController::class, 'update'])->name('procurement.po.update');
    Route::delete('/procurement/purchase-orders/{purchase_order}', [ProcurementPurchaseOrderController::class, 'destroy'])->name('procurement.po.destroy');

    // Purchase Orders - Additional Routes
    Route::get('/procurement/purchase-orders/data', [ProcurementPurchaseOrderController::class, 'data'])->name('procurement.po.data');
    Route::post('/procurement/purchase-orders/{po}/send', [ProcurementPurchaseOrderController::class, 'send'])->name('procurement.po.send');
    Route::post('/procurement/purchase-orders/{po}/acknowledge', [ProcurementPurchaseOrderController::class, 'acknowledge'])->name('procurement.po.acknowledge');
    Route::get('/procurement/purchase-orders/{po}/pdf', [ProcurementPurchaseOrderController::class, 'generatePdf'])->name('procurement.po.pdf');
    Route::post('/procurement/purchase-orders/bulk-update-status', [ProcurementPurchaseOrderController::class, 'bulkUpdateStatus'])->name('procurement.po.bulk_update_status');

    // Comments & Timeline Routes
    Route::get('/procurement/requests/{request}/comments', [ProcurementCommentController::class, 'index'])->name('procurement.comments.index');
    Route::post('/procurement/requests/{request}/comments', [ProcurementCommentController::class, 'store'])->name('procurement.comments.store');
    Route::put('/procurement/requests/{request}/comments/{comment}', [ProcurementCommentController::class, 'update'])->name('procurement.comments.update');
    Route::delete('/procurement/requests/{request}/comments/{comment}', [ProcurementCommentController::class, 'destroy'])->name('procurement.comments.destroy');
    Route::post('/procurement/requests/{request}/comments/{comment}/reply', [ProcurementCommentController::class, 'reply'])->name('procurement.comments.reply');
    Route::get('/procurement/requests/{request}/comments/{comment}/thread', [ProcurementCommentController::class, 'getThread'])->name('procurement.comments.thread');

    // Attachments Routes
    Route::post('/procurement/attachments/upload', [ProcurementAttachmentController::class, 'upload'])->name('procurement.attachments.upload');
    Route::get('/procurement/attachments/{attachment}/download', [ProcurementAttachmentController::class, 'download'])->name('procurement.attachments.download');
    Route::get('/procurement/attachments/{attachment}/view', [ProcurementAttachmentController::class, 'view'])->name('procurement.attachments.view');
    Route::delete('/procurement/attachments/{attachment}', [ProcurementAttachmentController::class, 'destroy'])->name('procurement.attachments.destroy');
    Route::delete('/procurement/attachments/bulk-delete', [ProcurementAttachmentController::class, 'bulkDelete'])->name('procurement.attachments.bulk_delete');

    // Master Data - Suppliers
    Route::get('/procurement/suppliers', [ProcurementSupplierController::class, 'index'])->name('procurement.suppliers.index');
    Route::get('/procurement/suppliers/create', [ProcurementSupplierController::class, 'create'])->name('procurement.suppliers.create');
    Route::post('/procurement/suppliers', [ProcurementSupplierController::class, 'store'])->name('procurement.suppliers.store');
    Route::get('/procurement/suppliers/{supplier}', [ProcurementSupplierController::class, 'show'])->name('procurement.suppliers.show');
    Route::get('/procurement/suppliers/{supplier}/edit', [ProcurementSupplierController::class, 'edit'])->name('procurement.suppliers.edit');
    Route::put('/procurement/suppliers/{supplier}', [ProcurementSupplierController::class, 'update'])->name('procurement.suppliers.update');
    Route::delete('/procurement/suppliers/{supplier}', [ProcurementSupplierController::class, 'destroy'])->name('procurement.suppliers.destroy');
    Route::get('/procurement/suppliers/data', [ProcurementSupplierController::class, 'data'])->name('procurement.suppliers.data');
    Route::post('/procurement/suppliers/{supplier}/toggle-status', [ProcurementSupplierController::class, 'toggleStatus'])->name('procurement.suppliers.toggle_status');
    Route::get('/procurement/suppliers/search', [ProcurementSupplierController::class, 'search'])->name('procurement.suppliers.search');
    Route::get('/procurement/suppliers/performance', [ProcurementSupplierController::class, 'performance'])->name('procurement.suppliers.performance');
    Route::get('/procurement/suppliers/export', [ProcurementSupplierController::class, 'export'])->name('procurement.suppliers.export');

    // Master Data - Customers
    Route::get('/procurement/customers', [ProcurementCustomerController::class, 'index'])->name('procurement.customers.index');
    Route::get('/procurement/customers/create', [ProcurementCustomerController::class, 'create'])->name('procurement.customers.create');
    Route::post('/procurement/customers', [ProcurementCustomerController::class, 'store'])->name('procurement.customers.store');
    Route::get('/procurement/customers/{customer}', [ProcurementCustomerController::class, 'show'])->name('procurement.customers.show');
    Route::get('/procurement/customers/{customer}/edit', [ProcurementCustomerController::class, 'edit'])->name('procurement.customers.edit');
    Route::put('/procurement/customers/{customer}', [ProcurementCustomerController::class, 'update'])->name('procurement.customers.update');
    Route::delete('/procurement/customers/{customer}', [ProcurementCustomerController::class, 'destroy'])->name('procurement.customers.destroy');
    Route::get('/procurement/customers/data', [ProcurementCustomerController::class, 'data'])->name('procurement.customers.data');
    Route::post('/procurement/customers/{customer}/toggle-status', [ProcurementCustomerController::class, 'toggleStatus'])->name('procurement.customers.toggle_status');
    Route::get('/procurement/customers/search', [ProcurementCustomerController::class, 'search'])->name('procurement.customers.search');
    Route::get('/procurement/customers/{customer}/requests-history', [ProcurementCustomerController::class, 'requestHistory'])->name('procurement.customers.request_history');
    Route::get('/procurement/customers/{customer}/analytics', [ProcurementCustomerController::class, 'analytics'])->name('procurement.customers.analytics');
    Route::get('/procurement/customers/export', [ProcurementCustomerController::class, 'export'])->name('procurement.customers.export');
    Route::post('/procurement/customers/bulk-import', [ProcurementCustomerController::class, 'bulkImport'])->name('procurement.customers.bulk_import');

    // Master Data - Products
    Route::get('/procurement/products', [ProcurementProductController::class, 'index'])->name('procurement.products.index');
    Route::get('/procurement/products/create', [ProcurementProductController::class, 'create'])->name('procurement.products.create');
    Route::post('/procurement/products', [ProcurementProductController::class, 'store'])->name('procurement.products.store');
    Route::get('/procurement/products/{product}', [ProcurementProductController::class, 'show'])->name('procurement.products.show');
    Route::get('/procurement/products/{product}/edit', [ProcurementProductController::class, 'edit'])->name('procurement.products.edit');
    Route::put('/procurement/products/{product}', [ProcurementProductController::class, 'update'])->name('procurement.products.update');
    Route::delete('/procurement/products/{product}', [ProcurementProductController::class, 'destroy'])->name('procurement.products.destroy');
    Route::get('/procurement/products/data', [ProcurementProductController::class, 'data'])->name('procurement.products.data');
    Route::post('/procurement/products/{product}/toggle-status', [ProcurementProductController::class, 'toggleStatus'])->name('procurement.products.toggle_status');
    Route::get('/procurement/products/search', [ProcurementProductController::class, 'search'])->name('procurement.products.search');
    Route::get('/procurement/products/categories', [ProcurementProductController::class, 'categories'])->name('procurement.products.categories');
    Route::get('/procurement/products/units', [ProcurementProductController::class, 'units'])->name('procurement.products.units');
    Route::get('/procurement/products/category-analytics', [ProcurementProductController::class, 'categoryAnalytics'])->name('procurement.products.category_analytics');
    Route::get('/procurement/products/export', [ProcurementProductController::class, 'export'])->name('procurement.products.export');
    Route::post('/procurement/products/bulk-import', [ProcurementProductController::class, 'bulkImport'])->name('procurement.products.bulk_import');
    Route::post('/procurement/products/{product}/duplicate', [ProcurementProductController::class, 'duplicate'])->name('procurement.products.duplicate');
    Route::get('/procurement/products/check-code', [ProcurementProductController::class, 'checkCodeAvailability'])->name('procurement.products.check_code');

    // Reports & Analytics Routes
    Route::get('/procurement/reports/dashboard-stats', [ProcurementDashboardController::class, 'dashboardStats'])->name('procurement.reports.dashboard_stats');

    // API endpoints for dropdowns and search
    Route::get('/procurement/items/{item}/arrivals', [ProcurementArrivalController::class, 'getItemArrivals'])->name('procurement.item_arrivals');
    Route::get('/procurement/requests/{request}/items-list', [ProcurementPurchaseOrderController::class, 'getRequestItems'])->name('procurement.request_items');
    Route::get('/procurement/requests/{request}/attachments', [ProcurementAttachmentController::class, 'getRequestAttachments'])->name('procurement.request_attachments');
    Route::get('/procurement/products/search-products', [ProcurementItemController::class, 'getProducts'])->name('procurement.search_products');


});
