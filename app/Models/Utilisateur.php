<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'Matricule';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['Matricule', 'prénom', 'nom', 'Email', 'idRole'];

    // Configuration pour l'authentification
    public function getAuthPassword()
    {
        return $this->connexion->password ?? null;
    }

    public function getAuthIdentifierName()
    {
        return 'Email';
    }

    public function getAuthIdentifier()
    {
        return $this->Email;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'idRole');
    }

    public function mouvements()
    {
        return $this->hasMany(Mouvement::class, 'matricule', 'Matricule');
    }

    public function connexion()
    {
        return $this->hasOne(Connexion::class, 'matricule', 'Matricule');
    }
}
