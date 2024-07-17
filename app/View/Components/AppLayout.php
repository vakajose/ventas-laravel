<?php

namespace App\View\Components;

use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\PageVisit;

class AppLayout extends Component
{
    public $visitCount;
    public $menus;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->visitCount = $this->getPageVisitCount();
        $this->menus = $this->getMenus();

    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }

    /**
     * Get the page visit count based on the configuration.
     */
    protected function getPageVisitCount()
    {
        $pageName = request()->path();
        $today = Carbon::today();

        return PageVisit::where('page_name', $pageName)
            ->when(config('settings.show_total_visits', false), function ($query) {
                return $query;
            }, function ($query) use ($today) {
                return $query->where('visit_date', $today);
            })
            ->sum('visit_count');
    }

    protected function getMenus()
    {
        return Menu::orderBy('order')->get();
    }
}
