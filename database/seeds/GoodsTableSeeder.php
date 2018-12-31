<?php

use Illuminate\Database\Seeder;
use App\Models\Goods;

class GoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Goods::truncate();

        factory(Goods::class, 5)->create();
    }
}
