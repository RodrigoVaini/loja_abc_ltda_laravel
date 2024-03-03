<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $primaryKey = 'id';
    protected $fillable = ['date','amount'];

    public $timestamps = false;

    public function items() {

        return $this->hasMany(SaleItems::class, 'sales_id', 'id');

    }

}
