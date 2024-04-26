<?php

namespace App\Console\Commands;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class deleteFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = Storage::files(formattedStorageString());

        foreach ($files as $file) {
            $strPath = str_replace('public', '/storage', $file);

            if (! Post::query()->where('image', $strPath)->exists()) {
                Storage::delete(str_replace('storage', 'public', $strPath));
            }
        }
    }
}
