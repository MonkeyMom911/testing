<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;

class DynamicLogo extends Component
{
    public $logoPath;

    public function __construct()
    {
        $path = Setting::where('key', 'logo')->value('value');
        $this->logoPath = ($path && Storage::exists($path)) ? Storage::url($path) : null;
    }

    public function render()
    {
        return view('components.dynamic-logo');
    }
}

