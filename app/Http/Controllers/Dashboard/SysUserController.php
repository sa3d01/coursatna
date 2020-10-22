<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SysManagement\SysUserStoreRequest;
use App\Http\Requests\Dashboard\SysManagement\SysUserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class SysUserController extends Controller
{
    public function index(Request $request)
    {
        $search_q = '';
        if ($request->has('search_q')) {
            $search_q = $request['search_q'];
        }

        $sysUsers = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['SYS_SUPPORT']);
        })->where('name', 'LIKE', '%' . $search_q . '%')
            ->orderBy('id', 'DESC')
            ->paginate();

        return view('dashboard.sys-users.index')
            ->with('sysUsers', $sysUsers)
            ->with('total', $sysUsers->total())
            ->with('indexUrl', route('dashboard.sys-users.index'));
    }

    public function create()
    {
        return view('dashboard.sys-users.create');
    }

    public function store(SysUserStoreRequest $request)
    {
        $data = $request->validated();
        $sysUser = User::create($data);
        $role = Role::findByName($data['role']);
        if ($role) {
            $sysUser->syncRoles([$data['role']]);
        }
        return redirect()->route('dashboard.sys-users.index')
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(User $sysUser)
    {
        return view('dashboard.sys-users.show')
            ->with('sysUser', $sysUser);
    }

    public function edit(User $sysUser)
    {
        $authUser = auth()->user();
        $canUpdateRole = false;
        if ($authUser->can('edit-user-role') && $authUser->id != $sysUser->id) {
            $canUpdateRole = true;
        }

        return view('dashboard.sys-users.edit')
            ->with('sysUser', $sysUser)
            ->with('canUpdateRole', $canUpdateRole);
    }

    public function update(SysUserUpdateRequest $request, User $sysUser)
    {
        $data = $request->validated();
        $sysUser->update($data);
        return redirect()->route('dashboard.sys-users.index')
            ->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(User $sysUser)
    {
        $sysUser->delete();
        return response()->json(['message' => 'Deleted Successfully'], 200);
    }
}
