<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = "products";
    protected $fillable = [
        "name", "content","color","age","price_root","price_sale","quantity","type_id","category_id","gender"
    ];
}
