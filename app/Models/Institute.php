<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'institute_code',
        'status',
    ];

    public function scopeActive($data){
        return $data->where('status','Active');
    }
}
