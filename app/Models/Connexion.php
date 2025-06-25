<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connexion extends Model
{
    protected $primaryKey = 'idConnexion';
    
    protected $fillable = ['password', 'matricule'];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'matricule', 'Matricule');
    }
}
