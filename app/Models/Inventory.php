<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory; 

    public $table = "inventorys";

    protected $guarded = ['id'];

    protected $hidden = [];

    public function storage_units(){
        return $this->belongsTo(Storage_Unit::class,'storage_unit_id','id');
    }
}
