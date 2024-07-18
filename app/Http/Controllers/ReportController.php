<?php

namespace App\Http\Controllers;

use App\Models\PageVisit;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Datos para el reporte de ventas por fecha
        $salesByDate = Sale::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $salesDateLabels = $salesByDate->pluck('date');
        $salesDateData = $salesByDate->pluck('total');

        // Datos para el reporte de ventas por producto
        $salesByProduct = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
            ->join('products', 'sale_details.product_id', '=', 'products.id')
            ->select('products.name', Sale::raw('SUM(sale_details.quantity * sale_details.price) as total'))
            ->groupBy('products.name')
            ->orderBy('total', 'desc')
            ->get();

        $salesProductLabels = $salesByProduct->pluck('name');
        $salesProductData = $salesByProduct->pluck('total');

        // Datos para los productos más vendidos
        $topProducts = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
            ->join('products', 'sale_details.product_id', '=', 'products.id')
            ->select('products.name', Sale::raw('SUM(sale_details.quantity) as total_quantity'))
            ->groupBy('products.name')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();

        $topProductsLabels = $topProducts->pluck('name');
        $topProductsData = $topProducts->pluck('total_quantity');

        // Datos para las 10 páginas más visitadas
        $topPages = PageVisit::select('page_name', PageVisit::raw('SUM(visit_count) as total_visits'))
            ->groupBy('page_name')
            ->orderBy('total_visits', 'desc')
            ->limit(10)
            ->get();

        $topPagesLabels = $topPages->pluck('page_name');
        $topPagesData = $topPages->pluck('total_visits');

        return view('reports.index', compact('salesDateLabels', 'salesDateData', 'salesProductLabels', 'salesProductData', 'topProductsLabels', 'topProductsData', 'topPagesLabels', 'topPagesData'));
    }
}
