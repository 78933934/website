<?php

namespace App\Admin\Controllers;

use App\Models\GoodCategory;
use App\Models\GoodModule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    function __construct(Request $request)
    {
//        parent::__construct($request);

        View::share('erp_api_domain', env('ERP_API_DOMAIN', ''));
        View::share('global_area', config('global_area'));
        View::share('money_sign', config('money_sign'));

        $good_categories = GoodCategory::pluck('name','id');
        $good_modules = GoodModule::pluck('name','id');

        View::share('good_categories', $good_categories);
        View::share('good_modules', $good_modules);


    }
}
