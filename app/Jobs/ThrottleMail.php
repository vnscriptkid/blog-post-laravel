<?php
// php artisan make:job ThrottleMail
namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class ThrottleMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 15;
    public $timeout = 10;

    public $mailable;
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Mailable $mailable, User $user)
    {
        $this->mailable = $mailable;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::throttle('mailtrap')
            ->allow(5)
            ->every(60)
            ->then(function () {
                Mail::to($this->user)->send(
                    $this->mailable
                );
            }, function () {
                return $this->release(5);
            });
    }
}
