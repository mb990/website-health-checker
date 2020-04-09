<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\InviteService;

class DeleteInvites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deleteInvites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if an invite is older than 5 days, delete if true.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $inviteService;

    public function __construct(InviteService $inviteService)
    {
        parent::__construct();
        $this->inviteService = $inviteService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->inviteService->delete('Ne2rrym3DBpwWbL5kXMmAM75DvGnYnmL');
    }
}
