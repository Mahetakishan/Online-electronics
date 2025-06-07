<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
      
      'product_id',
      'user_id',
      'country_id',
      'state_id',
      'city_id',
      'pincode',
      'quantity',
      'total',
    ];
    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }
    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }
    public function country()
    {
        return $this->belongsTo(country::class, 'country_id');
    }
    public function state()
    {
        return $this->belongsTo(state::class, 'state_id');
    }
    public function city()
    {
        return $this->belongsTo(city::class, 'city_id');
    }
}
