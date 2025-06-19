<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = ['libelle', 'region', 'idArticle'];

    public function article()
    {
        return $this->belongsTo(Article::class, 'idArticle');
    }
}
Schema::create('destinations', function (Blueprint $table) {
    $table->id('idDestination');
    $table->string('libelle');
    $table->string('region');
    $table->unsignedBigInteger('idArticle');
    $table->foreign('idArticle')->references('idArticle')->on('articles');
    $table->timestamps();
});
