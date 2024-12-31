<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Backups;

class BackupTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:backup-tables';
    protected $signature = 'app:backup:tables';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';
    protected $description = 'Backup de las tablas de categorias, subcategorias y platos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $categories = DB::table('categories')->get();
        $subcategories = DB::table('subcategories')->get();
        $dishes = DB::table('dishes')->get();

        $data = [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'dishes' => $dishes,
        ];

        Backups::create([
            'data' => json_encode($data),
        ]);

        $this->info('Backup created successfully');

        // Limitar el número de backups a 30
        $this->limitBackups();
    }

    protected function limitBackups()
    {
        $maxBackups = 20;
        $backups = Backups::orderBy('created_at', 'asc')->get();

        if ($backups->count() > $maxBackups) {
            $backupsToDelete = $backups->take($backups->count() - $maxBackups);
            foreach ($backupsToDelete as $backup) {
                $backup->delete();
            }
            $this->info('Old backups deleted successfully');
        }
    }
}
