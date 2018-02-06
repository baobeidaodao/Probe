<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * 此类用于创建初始的角色权限表和初始用户
 * Class PermissionTableSeeder
 */
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 临时关闭 mysql 外键约束
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // 清空表
        (new Permission)->truncate();
        (new Role)->truncate();
        (new User)->truncate();
        DB::table('role_user')->delete();
        DB::table('permission_role')->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        // 创建初始用户
        $root = (new User)->create([
            'name' => 'root',
            'email' => '625117069@qq.com',
            'password' => bcrypt('1234'),
        ]);

        // 创建初始角色
        $admin = (new Role)->create([
            'name' => 'admin',
            'display_name' => '超级管理员',
            'description' => '超级管理员',
        ]);

        // 创建相应的初始权限
        $super_manager = (new Permission)->create([
            'name' => 'super_manager',
            'display_name' => '超级管理员',
            'description' => '超级管理员',
        ]);

        // 给角色赋予权限
        $admin->attachPermission($super_manager);

        // 给用户指定角色
        $root->attachRole($admin);
    }
}
