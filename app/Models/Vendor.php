<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    public $table = "vendors";

    protected $guarded = ['id'];

    protected $hidden  = [];

    public function storage_units() {
        return $this->hasMany(Storage_Unit::class);
    }
}
