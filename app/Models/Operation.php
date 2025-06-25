<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operation extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_operation',
        'destination_operation',
        'date_operation',
        'description'
    ];

    protected $casts = [
        'date_operation' => 'date'
    ];

    /**
     * Get the mouvements for this operation.
     */
    public function mouvements(): HasMany
    {
        return $this->hasMany(Mouvement::class);
    }
}

