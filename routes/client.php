<?php

use App\Http\Controllers\Client\ProjectsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'client',
    'as' => 'client.',
    'middleware' => ['auth:web', 'role:client'],
], function () {
    Route::patch('projects/{project}/proposals/{proposal}', [ProjectsController::class, 'updateProposal'])
        ->name('projects.proposals.update');

    Route::resource('projects', ProjectsController::class);
});
