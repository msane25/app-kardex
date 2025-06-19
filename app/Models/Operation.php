<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = ['type_operation', 'libelle'];

    public function mouvements()
    {
        return $this->hasMany(Mouvement::class, 'idOperation');
    }
}
Schema::create('operations', function (Blueprint $table) {
    $table->id('idOperation');
    $table->string('type_operation');
    $table->string('libelle');
    $table->timestamps();
});

