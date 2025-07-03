<?php

namespace App\Http\Controllers;

use App\Charts\grafikChart;
use App\Charts\grafikmingguChart;
use App\Models\Produk;
use App\Models\PembelianItem;
use App\Models\Transaction;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(grafikChart $chart, grafikmingguChart $chartminggu)
    {
        // Calculate total sales (totalIncome)
        $sales = Transaction::with('items.produk')->get();
        $totalIncome = 0;
        foreach ($sales as $sale) {
            foreach ($sale->items as $item) {
                $totalIncome += $item->subtotal ?? 0;
            }
        }

        // Calculate total purchase cost
        $purchaseStocks = PembelianItem::selectRaw('produk_id, SUM(quantity) as total_quantity')
            ->join('pembelians', 'pembelian_items.pembelian_id', '=', 'pembelians.id')
            ->groupBy('produk_id')
            ->pluck('total_quantity', 'produk_id');

        $produks = Produk::all();

        $totalPurchaseCost = 0;
        foreach ($produks as $produk) {
            $purchaseStock = $purchaseStocks->get($produk->id, 0);
            $totalPurchaseCost += ($produk->harga_beli * $purchaseStock);
        }

        // Calculate total purchase sum (totalSum) for pembelian
        $totalSum = 0;
        foreach ($produks as $product) {
            $purchaseStock = $purchaseStocks->get($product->id, 0);
            $lineTotal = $product->harga_beli && $purchaseStock ? $product->harga_beli * $purchaseStock : 0;
            $totalSum += $lineTotal;
        }

        $totalSales = $totalIncome;

        // Calculate total expenses
        $totalExpenses = Expense::sum('jumlah');

        // Calculate profit or loss
        $profitOrLoss = $totalSales - ($totalSum + $totalExpenses);

        // Prepare monthly data for chart
        $months = [];
        $monthlyExpenses = [];
        $monthlyPurchases = [];
        $monthlyIncome = [];

        // Generate last 6 months dynamically
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months[] = $month->format('F');
        }

        foreach ($months as $month) {
            $monthNumber = date('m', strtotime($month));

            $monthlyExpense = Expense::whereMonth('created_at', $monthNumber)->sum('jumlah');
            $monthlyPurchaseItems = PembelianItem::selectRaw('produk_id, SUM(quantity) as total_quantity')
                ->join('pembelians', 'pembelian_items.pembelian_id', '=', 'pembelians.id')
                ->whereMonth('pembelians.created_at', $monthNumber)
                ->groupBy('produk_id')
                ->pluck('total_quantity', 'produk_id');

            $monthlyPurchaseCost = 0;
            foreach ($produks as $produk) {
                $purchaseStock = $monthlyPurchaseItems->get($produk->id, 0);
                $monthlyPurchaseCost += ($produk->harga_beli * $purchaseStock);
            }

            $monthlySaleItems = Transaction::with('items.produk')
                ->whereMonth('created_at', $monthNumber)
                ->get();

            $monthlySaleIncome = 0;
            foreach ($monthlySaleItems as $sale) {
                foreach ($sale->items as $item) {
                    $monthlySaleIncome += $item->subtotal ?? 0;
                }
            }

            $monthlyExpenses[] = $monthlyExpense;
            $monthlyPurchases[] = $monthlyPurchaseCost;
            $monthlyIncome[] = $monthlySaleIncome;
        }

        // Combine monthly expenses and purchases
        $combinedExpensesPurchases = [];
        for ($i = 0; $i < count($months); $i++) {
            $combinedExpensesPurchases[] = ($monthlyExpenses[$i] ?? 0) + ($monthlyPurchases[$i] ?? 0);
        }

        // Debug: dump the data arrays to verify content
        \Log::debug('combinedExpensesPurchases: ', $combinedExpensesPurchases);
        \Log::debug('monthlyIncome: ', $monthlyIncome);

        // Prepare weekly data for chartminggu
        $weeklyExpenses = [];
        $weeklyIncome = [];

        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        for ($week = 1; $week <= 6; $week++) {
            $weekStart = $startDate->copy()->addWeeks($week - 1)->startOfDay();
            $weekEnd = $weekStart->copy()->addDays(6)->endOfDay();

            if ($weekStart > $endDate) {
                break;
            }

            if ($weekEnd > $endDate) {
                $weekEnd = $endDate->copy()->endOfDay();
            }

            $weeklyExpense = Expense::whereBetween('created_at', [$weekStart, $weekEnd])->sum('jumlah');

            // Calculate weekly pembelian cost
            $weeklyPurchaseItems = PembelianItem::selectRaw('produk_id, SUM(quantity) as total_quantity')
                ->join('pembelians', 'pembelian_items.pembelian_id', '=', 'pembelians.id')
                ->whereBetween('pembelians.created_at', [$weekStart, $weekEnd])
                ->groupBy('produk_id')
                ->pluck('total_quantity', 'produk_id');

            $weeklyPurchaseCost = 0;
            $produks = Produk::all();
            foreach ($produks as $produk) {
                $purchaseStock = $weeklyPurchaseItems->get($produk->id, 0);
                $weeklyPurchaseCost += ($produk->harga_beli * $purchaseStock);
            }

            $weeklySaleItems = Transaction::with('items.produk')
                ->whereBetween('created_at', [$weekStart, $weekEnd])
                ->get();

            $weeklySaleIncome = 0;
            foreach ($weeklySaleItems as $sale) {
                foreach ($sale->items as $item) {
                    $weeklySaleIncome += $item->subtotal ?? 0;
                }
            }

            $weeklyExpenses[] = $weeklyExpense + $weeklyPurchaseCost;
            $weeklyIncome[] = $weeklySaleIncome;
        }

        // Pad weeklyExpenses and weeklyIncome to length 6 with zeros if needed
        $weeklyExpenses = array_pad($weeklyExpenses, 6, 0);
        $weeklyIncome = array_pad($weeklyIncome, 6, 0);

        // Fetch recent transactions for sales history
        $recentTransactions = Transaction::with('items.produk')->orderBy('created_at', 'desc')->limit(5)->get();

        $data = array_merge(
            compact('profitOrLoss', 'totalSum', 'totalSales', 'totalExpenses', 'recentTransactions'),
            ['chart' => $chart->build($combinedExpensesPurchases, $monthlyIncome, $months), 'chartminggu' => $chartminggu->build($weeklyExpenses, $weeklyIncome)]
        );

        return view('admin.dashboard', $data);
    }
}