<?php

namespace Tysdever\EloquentAttachment\Commands;

use Illuminate\Console\Command;
use File;

class ClearTmpFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attachment:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all temp files used to file populate.';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $directory = '';

        if(File::cleanDirectory($directory))
        {
            $this->success(PHP_EOL. 'Dir is now empty.' .PHP_EOL);
        } else {
            $this->error(PHP_EOL .'Something went wrong!' . PHP_EOL);
        }

        

        
    }
}
