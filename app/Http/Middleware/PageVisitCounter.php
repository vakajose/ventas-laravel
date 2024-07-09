<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PageVisit;
use Carbon\Carbon;

class PageVisitCounter
{
    public function handle(Request $request, Closure $next)
    {
        $pageName = $request->path();
        $today = Carbon::today();

        $pageVisit = PageVisit::firstOrCreate(
            ['page_name' => $pageName, 'visit_date' => $today],
            ['visit_count' => 0]
        );

        $pageVisit->increment('visit_count');

        return $next($request);
    }
}
