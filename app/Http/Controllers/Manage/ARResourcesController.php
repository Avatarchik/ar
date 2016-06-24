<?php
namespace App\Http\Controllers\Manage;

use App\Models\ArTarget;
use Log;

class ARResourcesController extends BaseController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artargets = ArTarget::orderBy('created_at', 'desc')->paginate($this->pageSize);

        return view('manage.ar.index', compact('artargets'), ['model' => 'ar', 'menu' => 'list']);

//        $ar = new EasyARCloudApi();
//        echo($ar->targetsList());
    }
}
