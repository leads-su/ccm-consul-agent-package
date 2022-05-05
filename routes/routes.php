<?php

use Illuminate\Support\Facades\Route;

Route::prefix('agent')->group(static function (): void {
    Route::prefix('services')->group(static function (): void {
        Route::get('', \ConsulConfigManager\Consul\Agent\Http\Controllers\ServiceListController::class)
            ->name('domain.consul.agent.services.list');

        Route::get('{identifier}', \ConsulConfigManager\Consul\Agent\Http\Controllers\ServiceGetController::class)
            ->name('domain.consul.agent.services.information');
    });
});
