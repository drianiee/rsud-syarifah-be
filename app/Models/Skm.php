<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skm extends Model
{
    protected $fillable = [
        'period_name','survey_period','male_count','female_count',
        'index_value','service_quality','performance','ekm_value','year'
    ];

    protected $casts = [
        'male_count' => 'int',
        'female_count' => 'int',
        'index_value' => 'float',
        'ekm_value' => 'float',
        'year' => 'int',
    ];
}
