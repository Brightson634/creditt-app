<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\DbBackup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DbBackupController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth:webmaster');
   }

   public function dbbackups()
   {
      $page_title = 'Database Backups';
      $dbbackups = DbBackup::all();
      return view('webmaster.dbbackups.index', compact('page_title', 'dbbackups'));
   }

   public function dbbackupGenerate()
   {
      try {
         $fileName = Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
         $filePath = 'assets/uploads/dbbackups/' . $fileName;
         $result = shell_exec('mysqldump ' . env('DB_DATABASE') . ' --user=' . env('DB_USERNAME') . ' --password=' . env('DB_PASSWORD') . ' > ' . storage_path($filePath));
         $fileSize = filesize(storage_path($result));

         $backup = new DbBackup();
         $backup->file_name = $fileName;
         $backup->file = $filePath;
         $backup->file_size = $fileSize;
         $backup->save();

         $notify[] = ['success', 'DB Backup generated and added Successfully!'];
      } catch (\Exception $e) 
      {
        $notify[] = ['error', 'Failed to generate DB Backup: ' . $e->getMessage()];
      }
      session()->flash('notify', $notify);

      return response()->json([
        'status' => 200
      ]);
   }


}