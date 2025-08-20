<?php

namespace App\Domain\Users\Listeners;

use App\Infrastructure\Abstracts\Listener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Bus\Queueable;

class UserRegisteredListener extends Listener
{
    use Queueable;

    public function __construct()
    {
        // TODO:
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     *
     * @throws \Exception
     */
    public function handle($event)
    {
        // TODO:
    }
}
