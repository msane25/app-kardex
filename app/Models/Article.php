<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_article',
        'description',
        'unite_mesure',
        'quantite_stock',
        'seuil_critique',
        'prix_unitaire',
    ];

    protected $casts = [
        'quantite_stock' => 'float',
        'seuil_alerte' => 'float',
        'prix_unitaire' => 'float',
    ];

    /**
     * Get the organisation that owns the article.
     */
    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'id_organisation');
    }

    /**
     * Get the mouvements for this article.
     */
    public function mouvements(): HasMany
    {
        return $this->hasMany(Mouvement::class);
    }

    public function destinations()
    {
        return $this->hasMany(Destination::class, 'idArticle');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }
}


