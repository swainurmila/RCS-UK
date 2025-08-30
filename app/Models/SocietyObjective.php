<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocietyObjective extends Model
{
    // use HasFactory;

    protected $table = 'society_objective';
    protected $fillable = ['objective'];
}