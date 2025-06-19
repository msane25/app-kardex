<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connexion extends Model
{
    protected $fillable = ['password', 'matricule'];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'matricule');
    }
}

Schema::create('connexions', function (Blueprint $table) {
    $table->id('idConnexion');
    $table->string('password');
    $table->string('matricule');
    $table->foreign('matricule')->references('matricule')->on('utilisateurs');
    $table->timestamps();
});
