<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'idRole';
    protected $fillable = ['libelle'];

    public function utilisateurs()
    {
        return $this->hasMany(Utilisateur::class, 'idRole');
    }
}
