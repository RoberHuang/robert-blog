<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();   // 取消批量赋值白名单、黑名单属性校验
        // $this->call(UsersTableSeeder::class);
        //$this->call(TagsTableSeeder::class);
        //$this->call(ArticlesTableSeeder::class);
        //$this->call(GoodsTableSeeder::class);

        $this->call(AdminsTableSeeder::class);

        //$this->call(ProjectsTableSeeder::class);

        Model::reguard();   // 恢复校验
    }
}
