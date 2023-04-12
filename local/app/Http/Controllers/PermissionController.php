<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Session;
use Theme;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $theme = Theme::uses('corex')->layout('layout');
        $permissions = Permission::all();
        $data = ['users' => ''];
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        if ($user_role == 'Admin') {

            $data = ['permissions' => $permissions];
            return $theme->scope('users.permissions', $data)->render();
        } else {
            abort('401');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        //return view('permissions.create')->with('roles', $roles);


        $theme = Theme::uses('corex')->layout('layout');
        $roles = Role::get();
        $data = ['roles' => $roles];
        return $theme->scope('users.permissions_create', $data)->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:40',
            'permission_desc' => 'required|max:150',
        ]);

        $name = $request['name'];
        $permission_desc = $request['permission_desc'];

        $permission = new Permission();
        $permission->name = $name;
        $permission->permission_desc = $permission_desc;
        $roles = $request['roles'];

        $permission->save();

        if (!empty($request['roles'])) {
            foreach ($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail(); //Match input role to db record

                $permission = Permission::where('name', '=', $name)->first();
                $r->givePermissionTo($permission);
            }
        }

        return redirect()->route('permissions.index')
            ->with(
                'flash_message',
                'Permission' . $permission->name . ' added!'
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('permissions');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $theme = Theme::uses('corex')->layout('layout');
        //  $role = Role::findOrFail($id);
        $permission = Permission::find($id);


        $data = ['permission' => $permission];
        return $theme->scope('users.permission_edit', $data)->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|max:40',
        ]);

        $input = $request->all();
        $permission->fill($input)->save();

        return redirect()->route('permissions.index')
            ->with(
                'flash_message',
                'Permission' . $permission->name . ' updated!'
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        if ($permission->name == "Administer roles & permissions") {
            return redirect()->route('permissions.index')
                ->with(
                    'flash_message',
                    'Cannot delete this Permission!'
                );
        }

        $permission->delete();

        return redirect()->route('permissions.index')
            ->with(
                'flash_message',
                'Permission deleted!'
            );
    }
}
