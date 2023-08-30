<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage_Unit extends Model
{
    use HasFactory;

    public $table = "storage_units";

    protected $guarded = ['id'];

    protected $hidden = [];

    public function invetories(){
        return $this->hasMany(Inventory::class);
    }

    public function vendors(){
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
}
