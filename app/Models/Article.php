<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['codeArticle', 'uniteDeMesure', 'quantiteStock', 'seuilAlerte', 'quantiteInitiale'];

    public function mouvements()
    {
        return $this->hasMany(Mouvement::class, 'idArticle');
    }

    public function destinations()
    {
        return $this->hasMany(Destination::class, 'idArticle');
    }
}
Schema::create('articles', function (Blueprint $table) {
    $table->id('idArticle');
    $table->string('codeArticle');
    $table->string('uniteDeMesure')->nullable();
    $table->integer('quantiteStock')->default(0);
    $table->integer('seuilAlerte')->default(0);
    $table->string('quantiteInitiale')->nullable();
    $table->timestamps();
});


