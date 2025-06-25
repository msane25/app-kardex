<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $fillable = [
        'article_id',
        'quantite',
        'date_mise_a_jour'
    ];

    protected $casts = [
        'date_mise_a_jour' => 'datetime'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}