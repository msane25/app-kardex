<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;
use Illuminate\Support\Facades\DB;

class UpdateArticlesInitialQuantity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:update-initial-quantity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Met à jour la quantité initiale des articles existants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Début de la mise à jour des quantités initiales...');

        try {
            DB::beginTransaction();

            // Récupérer tous les articles
            $articles = Article::all();
            $bar = $this->output->createProgressBar(count($articles));
            $bar->start();

            foreach ($articles as $article) {
                // Si la quantité initiale n'est pas définie, on utilise la quantité de stock actuelle
                if ($article->quantiteInitiale == 0) {
                    $article->update([
                        'quantiteInitiale' => $article->quantiteStock
                    ]);
                }
                $bar->advance();
            }

            $bar->finish();
            DB::commit();

            $this->newLine();
            $this->info('Mise à jour terminée avec succès !');
            $this->table(
                ['Statistiques', 'Nombre'],
                [
                    ['Articles traités', count($articles)],
                ]
            );
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Une erreur est survenue : ' . $e->getMessage());
        }
    }
}
