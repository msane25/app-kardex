<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['libelle'];

    public function utilisateurs()
    {
        return $this->hasMany(Utilisateur::class, 'idRole');
    }
}

Schema::create('roles', function (Blueprint $table) {
    $table->id('idRole');
    $table->string('libelle');
    $table->timestamps();
});
