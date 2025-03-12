<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations ;

class Product extends Model 

{
    use HasFactory, HasTranslations;
    protected $fillable = ['name', 'price', 'stock'];
    public $translatable = ['name'];
}
