<?php

namespace App\Console\Commands;

use App\Check;
use App\Notifications\projectDownEmail;
use App\Notifications\projectUpEmail;
use App\ProjectUrl;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Notifications\Notifiable;

class CheckUrl extends Command
{

    use Notifiable;
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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $urls = ProjectUrl::all();

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

                if (!in_array($check->response_code, range(200, 299)) && $url->project->up == 1) {

                    $url->project->creator->notify(new projectDownEmail());
                    $url->project->up = 0;

                    $url->project->save();
                }

                else if($url->project->up != 1 && in_array($check->response_code, range(200, 299))) {

                    $url->project->creator->notify(new projectUpEmail());
                    $url->project->up = 1;
                    $url->project->save();
                }
            }
        }
    }
}
