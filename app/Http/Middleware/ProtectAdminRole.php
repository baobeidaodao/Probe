<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;

/**
 * 保护 admin 初始超级管理员角色
 * Class ProtectAdminRole
 * @package App\Http\Middleware
 */
class ProtectAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = $request->route('roles');
        $role = (new Role)->findOrFail($id);
        if (isset($role->name) && 'admin' !== $role->name) {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}
