<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Course;

class courseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 15; $i++) {
            
            $faker =  Faker::create();
            $course_obj = new Course();
            $course_obj->name = Str::random(10);
            $course_obj->capacity = $faker->numberBetween($min = 3, $max = 8);
            $course_obj->save();
            
        }
    }
}
