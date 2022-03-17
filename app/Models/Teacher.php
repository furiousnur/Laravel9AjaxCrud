<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'designation',
        'institute_id',
        'book_id',
        'status'
    ];

    public function scopeActive($data){
        return $data->where('status','Active');
    }

    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function institute(){
        return $this->belongsTo(Institute::class);
    }
}
