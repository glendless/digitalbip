<?php

namespace App\Providers;

use App\Interfaces\FamilyMemberRepositoryInterface as InterfacesFamilyMemberRepositoryInterface;
use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\FamilyMemberRepository as RepositoriesFamilyMemberRepository;
// use App\Models\HeadOfFamily;
use App\Repositories\HeadOfFamilyRepository;
use App\Repositories\UserRepository;
use FamilyMemberRepository;
use FamilyMemberRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(HeadOfFamilyRepositoryInterface::class,
        HeadOfFamilyRepository::class);
        $this->app->bind(InterfacesFamilyMemberRepositoryInterface::class, RepositoriesFamilyMemberRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
