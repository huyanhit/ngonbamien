<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\SReportService;
use Symfony\Component\HttpFoundation\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class SReportController extends MyController
{
    public $form;
    public $service;

    function __construct(Request $request){
        parent::__construct($request, new SReportService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = [];
        $this->view['list'] = [];
	}
	
    public function index(){
        $this->init($this->view);
        $this->view['report'] = $this->service->generateReport();
        $this->view['data'] = [
            'weeks'  => $this->service->getAllWeeksOfYear(),
            'months' => $this->service->getAllMonthsOfYear(),
            'years'  => ['2026']
        ];
        return view('Admin::Orders.report', $this->view);
	}
}
