<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subcategory extends Model
{
    protected $table = 'subcategory';
    protected $fillable = [
      'category_id',
      'subcategoryname',
     
    ];
    public function products()
    {
        return $this->hasMany(product::class);
    }
    public function category()
    {
      return $this->belongsTo(category::class);
    }
    
}
