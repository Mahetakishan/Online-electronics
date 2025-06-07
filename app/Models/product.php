<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class product extends Model
{
    protected $table = 'products';
    protected $fillable = [
      'productname',
      'price',
      'image',
      'category_id',
      'subcategory_id',
      'quantity',
    ];
   


    public function category()
    {
        return $this->hasOne('App\Models\category', 'id','category_id');
        return $this->belongsTo(category::class);
    }

    public function subcategory()
    {
        return $this->hasOne('App\Models\subcategory', 'id','subcategory_id');
        return $this->belongsTo(subcategory::class, 'subcategory_id');
    }
  
    
   
}
