<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Backups;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
class BackupsController extends Controller
{
    public function index()
    {
        $backups = Backups::latest()->get();
        // $backups = Backups::orderBy('created_at', 'desc')->get();
        return inertia('Backups/Index', ['backups' => $backups]);
    }

    public function createBackup()
    {
        // Lógica para crear un punto de guardado
        // Por ejemplo, podrías llamar a un comando de Artisan que realice la tarea de backup
        
        Artisan::call('app:backup:tables');
        
        return redirect()->route('backups.index');
    }

    public function restore($id)
    {
    
        $backup = Backups::find($id);
        $data = json_decode($backup->data, true);

        

        DB::beginTransaction();
        
        try {
            // Desactivar restricciones de claves foráneas
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            // Truncar las tablas
            DB::table('categories')->truncate();
            DB::table('subcategories')->truncate();
            DB::table('dishes')->truncate();
            
            // Reactivar restricciones de claves foráneas
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            // Insertar los datos desde el backup
            DB::table('categories')->insert($data['categories']);
            DB::table('subcategories')->insert($data['subcategories']);
            DB::table('dishes')->insert($data['dishes']);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('backups.index')->with('error', 'Error restoring backup: ' . $e->getMessage());
        }

        return redirect()->route('backups.index')->with('success', 'Backup restored successfully');
    }
}
