<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organisation extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'adresse',
        'telephone',
        'email'
    ];

    /**
     * Get the articles for this organisation.
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'idOrganisation');
    }
}
