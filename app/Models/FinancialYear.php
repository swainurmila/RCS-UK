<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model
{
    protected $table = 'financial_years';
    protected $fillable = [
        'financial_year',
        'status'
    ];
}