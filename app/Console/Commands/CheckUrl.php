<?php

namespace App\Console\Commands;

use App\Services\ProjectService;
use App\Services\ProjectUrlService;
use App\Services\HttpService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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
    protected $projectService;
    protected $projectUrlService;
    protected $httpService;

    public function __construct(ProjectService $projectService, ProjectUrlService $projectUrlService, HttpService $httpService)
    {
        parent::__construct();
        $this->projectService = $projectService;
        $this->projectUrlService = $projectUrlService;
        $this->httpService = $httpService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $urls = $this->projectUrlService->all();

        foreach ($urls as $url) {

            $check = $this->projectUrlService->createCheck($url);

            if (!$this->httpService->requestSuccessful($check) && $this->projectService->isActive($url->id)) {

                $this->projectService->notifyMembersProjectDown($url);
                $this->projectService->setProjectDown($url->id);
            }

            else if (!$this->projectService->isActive($url->id) && $this->httpService->requestSuccessful($check)) {

                $this->projectService->notifyMembersProjectUp($url);
                $this->projectService->setProjectUp($url->id);
            }
        }
    }
}
