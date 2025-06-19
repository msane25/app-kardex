<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks'; // nom de ta table dans la base de données

    protected $fillable = [
        'nomenclature',
        'designation',
        'date',
        'document_number',
        'fournisseur',
        'entrees',
        'sorties',
        'stock',
    ];
}