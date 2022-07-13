<?php

namespace Database\Seeders;

use App\RealEstate\Models\Office;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $office = new Office();
        $office->setName('Default');
        $office->setZipCode('cm27pj');
        $office->setDefault();
        $office->save();
    }
}
