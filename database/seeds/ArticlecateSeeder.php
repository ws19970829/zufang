<?php

use Illuminate\Database\Seeder;
use App\Models\Articlecate;

class ArticlecateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Articlecate::create([
            'cname' => '租房',
            'pid' => 0
        ]);
        Articlecate::create([
            'cname' => '找房看房',
            'pid' => 1
        ]);
        Articlecate::create([
            'cname' => '签约付款',
            'pid' => 1
        ]);
        Articlecate::create([
            'cname' => '物业交割',
            'pid' => 1
        ]);
        Articlecate::create([
            'cname' => '租房纠纷',
            'pid' => 1
        ]);
    }
}
