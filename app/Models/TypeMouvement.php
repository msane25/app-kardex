<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeMouvement extends Model
{
    protected $fillable = ['libelleTypeMouvement'];

    public function mouvements()
    {
        return $this->hasMany(Mouvement::class, 'idTypeMouvement');
    }
}
Schema::create('type_mouvements', function (Blueprint $table) {
    $table->id('idTypeMouvement');
    $table->string('libelleTypeMouvement');
    $table->timestamps();
});

