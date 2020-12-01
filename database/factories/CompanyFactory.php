<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Employee;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $logoPath = Storage::putFile('public/company-logos', new File('./default-logo.jpg'));

        return [
            'name' => $this->faker->unique()->company,
            'email' => $this->faker->unique()->companyEmail,
            'logo' => $filename = pathinfo($logoPath)['basename'],
            'website' => $this->faker->url,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Company $company) {
            Employee::factory()->count($this->faker->numberBetween(20, 30))->create([
               'company_id' => $company->id,
            ]);
        });
    }
}
