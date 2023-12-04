<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 登録時
        Gate::define('store-task', function (User $user) {
            return $user->id === Auth::id();
        });
        // 更新時
        Gate::define('update-task', function (User $user, Task $task) {
            return $user->id === $task->user->id;
        });
        // 削除時
        Gate::define('delete-task', function (User $user, Task $task) {
            return $user->id === $task->user->id;
        });
    }
}
