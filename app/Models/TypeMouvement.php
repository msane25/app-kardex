<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeMouvement extends Model
{
    protected $table = 'type_mouvements';
    protected $primaryKey = 'id_type_mouvement';
    public $timestamps = true;
    protected $fillable = ['mouvement'];

    public function mouvements()
    {
        return $this->hasMany(Mouvement::class, 'idTypeMouvement');
    }
}

