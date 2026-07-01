<?php

namespace App\Providers;

use App\Contracts\Services\EventServiceInterface;
use App\Contracts\Services\KeuanganServiceInterface;
use App\Contracts\Services\MemberServiceInterface;
use App\Contracts\Services\OrganizationServiceInterface;
use App\Contracts\Services\ProkerServiceInterface;
use App\Contracts\Services\SuratServiceInterface;
use App\Contracts\Services\TugasServiceInterface;
use App\Services\EventService;
use App\Services\KeuanganService;
use App\Services\MemberService;
use App\Services\OrganizationService;
use App\Services\ProkerService;
use App\Services\SuratService;
use App\Services\TugasService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrganizationServiceInterface::class, OrganizationService::class);
        $this->app->bind(MemberServiceInterface::class, MemberService::class);
        $this->app->bind(ProkerServiceInterface::class, ProkerService::class);
        $this->app->bind(EventServiceInterface::class, EventService::class);
        $this->app->bind(SuratServiceInterface::class, SuratService::class);
        $this->app->bind(KeuanganServiceInterface::class, KeuanganService::class);
        $this->app->bind(TugasServiceInterface::class, TugasService::class);
    }

    public function boot(): void
    {
        URL::forceScheme('https');
    }
}
