<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table = 'category';
    protected $fillable = [
      
      'categoryname',
     
    ];
    public function subcategories()
    {
        return $this->hasMany(subcategory::class);
    }
}
