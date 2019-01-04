<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Project;
use App\Models\Admin\Admin;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = Admin::all()->pluck('id')->all();

        Project::truncate();
        DB::table('project_user')->truncate();

        factory(Project::class, 2)->create()->each(function ($project) use ($admins) {
            shuffle($admins); // 把数组中的元素按随机顺序重新排序
            $projectUsers = [$admins[0]];

            $project->syncProjectUser($projectUsers);
        });
    }
}
