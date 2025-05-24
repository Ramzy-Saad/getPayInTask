<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['facebook','instagram','linkedin','twitter'];

        foreach($names as $name){
            Platform::updateOrCreate([
                'type'=>$name
            ],[
                'name'=>$name
            ]);
        }
    }
}
