<?php

namespace App\Controllers;

use App\Services\MixService;

class HomeController
{
    private MixService $mixService;

    public function __construct()
    {
        $this->mixService = new MixService();
    }

    public function home(array $vars = []): void
    {
        $mixes = $this->mixService->getAllPublicMixes();
        $featuredMixes = array_slice($mixes, 0, 3);

        require __DIR__ . '/../Views/home/index.php';
    }
}