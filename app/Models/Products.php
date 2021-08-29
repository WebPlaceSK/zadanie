<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Products_d extends Model
{
    use HasFactory;
    use Searchable;

    public $fillable = ['name','description','company_name'];


    /**
     * Get the index name for the model.
     */
    public function searchableAs()
    {
        return 'product_index';
    }
}
