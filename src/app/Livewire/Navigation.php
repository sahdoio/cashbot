<?php

declare(strict_types=1);

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Navigation extends Component
{
    public string $userName = 'Hi';

    public string $userEmail;

    public function __construct()
    {
        $this->userName = auth()->user()->name ?? 'Guest';
        $this->userEmail = auth()->user()->email ?? 'guest@example.com';
    }

    public function render(): View|string
    {
        return view('livewire.navigation');
    }
}
