<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['id_user', 'name', 'price', 'id_category', 'id_brand', 'status', 'sale', 'company', 'detail', 'images'];
}
