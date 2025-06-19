<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mouvement extends Model
{
    protected $fillable = [
        'quantite', 'date_mouvement', 'matricule',
        'idOperation', 'idArticle', 'idDestination', 'idTypeMouvement'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'matricule');
    }

    public function operation()
    {
        return $this->belongsTo(Operation::class, 'idOperation');
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'idArticle');
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'idDestination');
    }

    public function typeMouvement()
    {
        return $this->belongsTo(TypeMouvement::class, 'idTypeMouvement');
    }
}
Schema::create('mouvements', function (Blueprint $table) {
    $table->id('idMouvement');
    $table->string('quantite');
    $table->date('date_mouvement');
    $table->string('matricule');
    $table->unsignedBigInteger('idOperation');
    $table->unsignedBigInteger('idArticle');
    $table->unsignedBigInteger('idDestination');
    $table->unsignedBigInteger('idTypeMouvement');

    $table->foreign('matricule')->references('matricule')->on('utilisateurs');
    $table->foreign('idOperation')->references('idOperation')->on('operations');
    $table->foreign('idArticle')->references('idArticle')->on('articles');
    $table->foreign('idDestination')->references('idDestination')->on('destinations');
    $table->foreign('idTypeMouvement')->references('idTypeMouvement')->on('type_mouvements');
    $table->timestamps();
});

