<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsCategory extends Model
{
    use HasFactory;

    protected $table = "products_category";
    protected $fillable = [
        "name","type_id","image"
    ];
}
