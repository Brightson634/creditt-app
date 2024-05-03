<?php

namespace Database\Seeders;

use App\Models\Webmaster;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class webmasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $webmaster = Webmaster::where('username', 'superadmin')->first();

        if (is_null($webmaster)) {
            $webmaster           = new Webmaster();
            $webmaster->name     = "Super Admin";
            $webmaster->email    = "testadmin@gmail.com";
            $webmaster->username = "superadmin";
            $webmaster->password = Hash::make('qwerty123');
            $webmaster->save();
        }
    }
}
