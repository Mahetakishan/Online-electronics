<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class state extends Model
{
    use HasFactory;
    protected $table = 'states';
    protected $fillable = [
      
      'state_name',
      'country_id',
     
    ];
}
