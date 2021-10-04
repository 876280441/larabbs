<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //生成数据集合
        User::factory()->count(10)->create();
        //单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = "876280441";
        $user->email = "876280441@qq.com";
        $user->avatar = "https://placeimg.com/140/180/any";
        $user->save();
    }
}
