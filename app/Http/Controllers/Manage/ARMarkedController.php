<?php
namespace App\Http\Controllers\Manage;

use App\Models\ArTarget;
use Log;

class ARMarkedController extends BaseController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artargets = ArTarget::orderBy('created_at', 'desc')->paginate($this->pageSize);

        return view('manage.ar.marked.index', compact('artargets'), ['model' => 'ar', 'menu' => 'list']);

//        $ar = new EasyARCloudApi();
//        echo($ar->targetsList());
    }


    public function getCreate()
    {
        $user = new User();
        $enterprises = Enterprise::all();
        $roles = Role::all();
        return view('manage.ar.marked.create', ['model' => 'system', 'menu' => 'user', 'user' => $user, 'roles' => $roles, 'enterprises' => $enterprises]);
    }

    public function postCreate(Request $request)
    {
        $user = new User();
        $input = $request->all();
        $validator = Validator::make($input, $user->rules(), $user->messages());
        if ($validator->fails()) {
            return redirect('/manage/system/user/create')
                ->withInput()
                ->withErrors($validator);
        }
        $user->enterprise_id = $request->input('enterprise_id');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        // $user->permissions()->sync([3, 4])->sava();
        if ($user) {
            return Redirect('/manage/system/user/');
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！');
        }
    }

    public function getEdit($id)
    {
        $user = User::find($id);
        return view('manage.ar.marked.edit', ['model' => 'system', 'menu' => 'user', 'user' => $user]);
    }

    public function postEdit(Request $request)
    {

        $id = $request->input('id');
        $input = $request->all();
        $user = User::find($id);

//        $validator = Validator::make($input, $user->rules(), $user->messages());
//        if ($validator->fails()) {
//            return redirect('/manage/system/user/create')
//                ->withInput()
//                ->withErrors($validator);
//        }

        $user->name = $request->input('name');
        $user->display_name = $request->input('display_name');
        $user->description = $request->input('description');
        $user->permissions()->detach([5, 4]);
        if ($user->save()) {
            return Redirect('/manage/system/user/');
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！');
        }
    }

}
