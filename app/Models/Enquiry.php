<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'rental_start_date',
        'end_date',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'enquiry_product');
    }
}
