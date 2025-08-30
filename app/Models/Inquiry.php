<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'district_id',
        'block_id',
        'society_type',
        'society_id',
        'inspector_id',
        'remarks',
        'inquiry_file',
    ];
    public function district() {
        return $this->belongsTo(District::class, 'district_id');
    }
    
    public function block() {
        return $this->belongsTo(Block::class, 'block_id');
    }
    
    public function society() {
        return $this->belongsTo(SocietyRegistration::class, 'society_id');
    }
    public function inspector()
{
    return $this->belongsTo(Inspector::class, 'inspector_id'); 
}
}