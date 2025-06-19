<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $primaryKey = 'matricule';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['matricule', 'nom', 'prenom', 'idRole'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'idRole');
    }

    public function mouvements()
    {
        return $this->hasMany(Mouvement::class, 'matricule');
    }

    public function connexion()
    {
        return $this->hasOne(Connexion::class, 'matricule');
    }
}

Schema::create('utilisateurs', function (Blueprint $table) {
    $table->string('matricule')->primary();
    $table->string('nom');
    $table->string('prenom');
    $table->unsignedBigInteger('idRole')->nullable();
    $table->foreign('idRole')->references('idRole')->on('roles');
    $table->timestamps();
});
