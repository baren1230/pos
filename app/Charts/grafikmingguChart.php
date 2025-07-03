<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class grafikmingguChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(array $weeklyExpenses = [], array $weeklyIncome = []): \ArielMejiaDev\LarapexCharts\BarChart
    {
        return $this->chart->barChart()
            ->setTitle('Pengeluaran dan Pemasukan')
            ->setSubtitle('Periode Mingguan')
            ->addData('Total Pengeluaran', $weeklyExpenses)
            ->addData('Total Pemasukan', $weeklyIncome)
            ->setXAxis(['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6']);
    }
}