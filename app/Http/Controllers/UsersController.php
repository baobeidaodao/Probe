<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: UsersController.php
 * Author  : Li Tao
 * DateTime: 2018-02-06 11:42:00
 */

namespace App\Http\Controllers;

use App\Models\ActionLog;
use App\Models\Role;
use App\Models\UserLevel;
use App\Services\AdminService;
use App\Services\AppService;
use Illuminate\Http\Request;
use App\Models\User;
use PhpParser\Node\Expr\Isset_;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $page
     * @return \Illuminate\Http\Response
     */
    public static function index($page = 1)
    {
        $size = 10;
        // $users = User::with('roles.perms')->get();
        $userListData = User::listUser($page, $size);
        $pagination = AppService::calculatePagination($page, $size, $userListData['count']);
        $roles = (new Role)->get();
        $userLevelList = UserLevel::all()->toArray();
        $areaMap = AdminService::listAreaMap();
        $data = [];
        $data['users'] = $userListData['userList'];
        $data['roles'] = $roles;
        $data['pagination'] = $pagination;
        $data['userLevelList'] = $userLevelList;
        $data['areaMap'] = $areaMap;
        $data['active'] = 'users';
        return view('admin.users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = (new User)->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'level' => $request->level,
            'password' => bcrypt($request->password),
            'area_id' => (isset($request->city_id) && !empty($request->city_id)) ? $request->city_id : ((isset($request->province_id) && !empty($request->province_id)) ? $request->province_id : 0),
        ]);
        if ($request->role) {
            $user->attachRoles($request->role);
        }
        ActionLog::log(ActionLog::ACTION_CREATE_USER, isset($user->name) ? $user->name : '');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = (new User)->findOrFail($id);
        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'level' => $request->level,
            'password' => (isset($request->password) && !empty($request->password)) ? bcrypt($request->password) : $user->password,
            'area_id' => (isset($request->city_id) && !empty($request->city_id)) ? $request->city_id : ((isset($request->province_id) && !empty($request->province_id)) ? $request->province_id : 0),
        ])->save();
        if ($roleArray = $request->role) {
            $user->roles()->sync($roleArray);
        } else {
            $user->roles()->detach();
        }
        if (User::isAdmin($user)) {
            $admin = (new Role)->where('name', '=', Role::getAdmin())->first();
            $user->attachRole($admin);
        }
        ActionLog::log(ActionLog::ACTION_EDIT_USER, isset($user->name) ? $user->name : '');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = (new User)->findOrFail($id);
        // $role->perms()->detach();
        try {
            $user->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        ActionLog::log(ActionLog::ACTION_DELETE_USER, isset($user->name) ? $user->name : '');
        return redirect()->back();
    }

    public static function search($page = 1, Request $request){
        $size = 10;
        $search = [
            'name' => isset($request->name) ? $request->name : '',
            'area_id' => (isset($request->city_id) && !empty($request->city_id)) ? $request->city_id : ((isset($request->province_id) && !empty($request->province_id)) ? $request->province_id : 0),
        ];
        $userListData = User::searchUser($search, $page, $size);
        $pagination = AppService::calculatePagination($page, $size, $userListData['count']);
        $roles = (new Role)->get();
        $userLevelList = UserLevel::all()->toArray();
        $areaMap = AdminService::listAreaMap();
        $data = [];
        $data['users'] = $userListData['userList'];
        $data['roles'] = $roles;
        $data['search'] = $search;
        $data['pagination'] = $pagination;
        $data['userLevelList'] = $userLevelList;
        $data['areaMap'] = $areaMap;
        $data['active'] = 'users';
        return view('admin.users.index', $data);
    }
}