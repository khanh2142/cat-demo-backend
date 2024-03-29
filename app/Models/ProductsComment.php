<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsComment extends Model
{
    use HasFactory;
    protected $table = "products_comment";
    protected $fillable = ["product_id","user_id","comment"];
    
}
