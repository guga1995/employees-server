<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Storage::deleteDirectory('public/company-logos');

        User::factory()->create([
           'email' => 'admin@admin.com',
           'is_admin' => true,
        ]);

        User::factory()->count(10)->create();

        Company::factory()->count(20)->create();
    }
}
