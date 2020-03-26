<?php

namespace App\Console\Commands;

use App\Check;
use App\Services\ProjectService;
use App\Services\CheckService;
use App\Services\ProjectUrlService;
use App\ProjectUrl;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Exception;

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
    protected $checkService;
    protected $projectUrlService;

    public function __construct(ProjectService $projectService, CheckService $checkService, ProjectUrlService $projectUrlService)
    {
        parent::__construct();
        $this->projectService = $projectService;
        $this->checkService = $checkService;
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

            if (Carbon::now()->diffInSeconds($url->last_checked_at) > $url->checkFrequency->value) {

                $check = new Check();

                $timeBefore = Carbon::now();

                try {
                    $response = Http::get($url->url);
                    $check->response_code = $response->status();
                } catch (Exception $e) {
                    $check->response_code = 0;
                }

                $timeAfter = Carbon::now();

                $check->url_id = $url->id;
                $check->response_time = $timeAfter->diffInMilliseconds($timeBefore);

                $url->last_checked_at = Carbon::now();

                $url->save();
                $check->save();

                if ($this->checkService->successful($check->id) == false && $this->projectService->active($url->id)) {

                    $this->projectService->notificationDown($url->project->creator->id);
                    $this->projectService->setProjectDown($url->id);
                }

                else if($this->projectService->active($url->id) == false && $this->checkService->successful($check->id)) {

                    $this->projectService->notificationUp($url->project->creator->id);
                    $this->projectService->setProjectUp($url->id);
                }
            }
        }
    }
}
