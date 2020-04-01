<?php

namespace App\Console\Commands;

use App\Services\HttpService;
use App\Services\ProjectService;
use App\Services\ProjectUrlService;
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
    protected $httpService;
    protected $projectUrlService;

    public function __construct(ProjectService $projectService, HttpService $httpService, ProjectUrlService $projectUrlService)
    {
        parent::__construct();
        $this->projectService = $projectService;
        $this->httpService = $httpService;
        $this->projectUrlService = $projectUrlService;
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

            if (!$this->httpService->requestSuccessful($check) && $this->projectService->isActive($url)) {

                $this->projectService->notifyMembersProjectDown($url);
                $this->projectService->setProjectDown($url->id);

            }

            else if(!$this->projectService->isActive($url) && $this->httpService->requestSuccessful($check)) {

                $this->projectService->notifyMembersProjectUp($url);
                $this->projectService->setProjectUp($url->id);
            }
        }
    }
}
