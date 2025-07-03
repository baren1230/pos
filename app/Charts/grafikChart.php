<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class grafikChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($combinedExpensesPurchases = [], $totalIncome = [], $months = [])
    {
        // Ensure data arrays have 6 elements and are numeric
        $combinedExpensesPurchases = array_map(function ($value) {
            return is_numeric($value) ? $value : 0;
        }, array_pad($combinedExpensesPurchases, 6, 0));

        $totalIncome = array_map(function ($value) {
            return is_numeric($value) ? $value : 0;
        }, array_pad($totalIncome, 6, 0));

        // Use dynamic months for X-axis if provided, else default to fixed months
        $xAxisLabels = !empty($months) ? $months : ['January', 'February', 'March', 'April', 'May', 'June'];

        return $this->chart->lineChart()
            ->setTitle('Grafik Pengeluaran dan Pemasukan')
            ->setSubtitle('Periode Bulanan')
            ->addData('Total Pengeluaran', $combinedExpensesPurchases)
            ->addData('Total Pemasukan', $totalIncome)
            ->setXAxis($xAxisLabels);
    }
}