<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operation extends Model
{
    use HasFactory;

    // Nom de la connexion (OK)
    protected $connection = 'gestion_utilisateurs';

    // Précise que la clé primaire n'est pas "id" mais "idOperation"
    protected $primaryKey = 'id_operation';

    // Laravel suppose que la clé primaire est un entier auto-incrémenté
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'libelle',
        'id_type_mouvement',
        'article_id',
    ];

    /**
     * Get the mouvements for this operation.
     */
    public function mouvements(): HasMany
    {
        return $this->hasMany(Mouvement::class);
    }

    /**
     * Get the article associated with this operation.
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get the type of mouvement associated with this operation.
     */
    public function typeMouvement()
    {
        return $this->belongsTo(TypeMouvement::class, 'id_type_mouvement', 'id_type_mouvement');
    }
}
