<?php

namespace App\Console\Commands;

use App\Services\ProjectUrlService;
use Illuminate\Console\Command;

class CheckUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:urlCheck';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check url and save stats';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $projectUrlService;

    public function __construct(ProjectUrlService $projectUrlService)
    {
        parent::__construct();
        $this->projectUrlService = $projectUrlService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->projectUrlService->checkUrl();
    }
}
