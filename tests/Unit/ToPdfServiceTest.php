<?php

use App\Services\toPDFService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('accepts an array of district ids for the collectors export', function () {
    $service = app(toPDFService::class);

    $result = $service->collectorsList([12, 13], null, null);

    expect($result)->toBeArray();
});
