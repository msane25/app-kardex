<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mouvement extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_mouvement',
        'type_mouvement_id', // <-- clé étrangère
        'quantite',
        'article_id',
        'operation_id',
        'destination',
        'fournisseur',
        'document_number'
    ];

    protected $casts = [
        'date_mouvement' => 'date',
        'quantite' => 'integer'
    ];

    /**
     * Get the article that owns the mouvement.
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get the operation that owns the mouvement.
     */
    public function operation(): BelongsTo
    {
        return $this->belongsTo(Operation::class);
    }

    public function typeMouvement()
    {
        return $this->belongsTo(TypeMouvement::class, 'type_mouvement_id');
    }
}

