<?php

namespace App\View\Components\Themes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navywhitegold extends Component
{
                    public function __construct()
                    {
                    }

                    public function render(): View|Closure|string
                    {
                                        return view('components.themes.navywhitegold');
                    }
}
