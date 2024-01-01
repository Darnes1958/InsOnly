<?php

namespace App\Providers;

use App\Livewire\Traits\AksatTrait;
use App\Models\Bank;
use App\Models\Main;
use App\Models\Overkst;
use App\Models\Taj;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    use AksatTrait;
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Overkst::creating(function($blog){
            $blog->user_id = auth()->id();
        });
        Main::creating(function($blog){
            $blog->user_id = auth()->id();
            $blog->NextKst=$this->setMonth($blog->sul_begin);
            $blog->LastUpd=now();
        });
        Taj::creating(function($blog){
            $blog->user_id = auth()->id();
        });

        Taj::updating(function($blog){
            $blog->user_id = auth()->id();
        });
        Bank::creating(function($blog){
            $blog->user_id = auth()->id();
        });

        Bank::updating(function($blog){
            $blog->user_id = auth()->id();
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
