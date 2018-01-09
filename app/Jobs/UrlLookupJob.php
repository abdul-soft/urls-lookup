<?php

namespace App\Jobs;

use App\Services\UrlLookupService;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UrlLookupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $urls;
    protected $user;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @param string $urls
     * @param User $user
     * @return void
     */
    public function __construct($urls, User $user)
    {
        $this->urls = $urls;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param UrlLookupService $lookupService
     * @return void
     */
    public function handle(UrlLookupService $lookupService)
    {
        $lookupService->lookup($this->urls, $this->user);
    }
}
