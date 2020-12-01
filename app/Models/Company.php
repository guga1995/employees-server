<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
    ];

    protected $appends = [
        'logo_url'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function getLogoUrlAttribute()
    {
        return asset('storage/company-logos/' . $this->attributes['logo']);
    }

    public static function booted()
    {
        static::saving(function (Company $company) {
            $logo = $company->logo;
            if ($logo instanceof UploadedFile && $logo->isValid()) {
                $path = $logo->store('public/company-logos');
                if ($path) {
                    $filename = pathinfo($path)['basename'];
                    $company->setAttribute('logo', $filename);
                }
            }
        });

        static::updated(function (Company $company) {
            $filename = $company->getOriginal('logo');

            if ($filename) {
                $path = 'public/company-logos/' . $filename;
                Storage::delete($path);
            }

        });
    }
}
