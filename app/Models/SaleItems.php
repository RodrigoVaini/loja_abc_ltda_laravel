<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItems extends Model {

    use HasFactory;

    protected $table = 'items';
    protected $primaryKey = 'id';
    protected $fillable = ['sales_id','products_id','quantity','amount'];

    public $timestamps = false;

    public function sale() {

        return $this->belongsTo(Sale::class);

    }

}
