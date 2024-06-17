<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarrierServices extends Model
{
    protected $fillable = [
        'carrierServiceId',
        'shopId',
        'callbackUrl',
        'nombre',
        'state',
    
    ];
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/carriers/'.$this->getKey());
    }
}
