<?php

namespace App\Db;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Products extends Model
{
    protected $fillable = ['productId','name','description','company_id','company_name','stock','images','price','sku', 'categories_id'];

}
