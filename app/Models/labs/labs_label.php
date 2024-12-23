<?php

namespace App\Models\labs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class labs_label extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'labs_label';
    protected $primaryKey = 'id_label';
    protected $fillable = [
        'brand', 'customer', 'PO', 'type', 'qty', 'scale', 'input'
    ];

    protected $dates = ['deleted_at'];
}
