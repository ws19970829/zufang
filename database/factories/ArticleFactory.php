<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    return [
        //
        'cid'=>mt_rand(2,5),
        'title'=>$faker->sentence(),
        'desn'=>$faker->sentence(),
        'pic'=>'/uploads/articles/OfWL3JO74nTrN0bdgyPHlNS9Imm4YgQM9wsFxWDk.jpeg',
        'body'=>$faker->text(),
    ];
});
