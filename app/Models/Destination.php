<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $primaryKey = 'idDestination';
    
    protected $fillable = ['libelle', 'region', 'idArticle'];

    public function article()
    {
        return $this->belongsTo(Article::class, 'idArticle');
    }
}
