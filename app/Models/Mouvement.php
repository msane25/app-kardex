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
        'document_number',
        'designation',
        'demandeur',
        'quantiteServis',
        'matricule',
    ];

    protected $casts = [
        'date_mouvement' => 'date',
        'quantite' => 'integer'
    ];

    /**
     * Get the article that owns the mouvement.
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'code_article', 'code_article');
    }

    /**
     * Get the operation that owns the mouvement.
     */
    public function operation()
    {
        return $this->belongsTo(\App\Models\Operation::class, 'id_operation', 'id_operation');
    }

    public function typeMouvement()
    {
        return $this->belongsTo(\App\Models\TypeMouvement::class, 'type_mouvement_id', 'id_type_mouvement');
    }
}

