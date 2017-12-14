<?php

namespace App\Http\Controllers;

use App\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Report $report)
    {
        $dt = Carbon::now();
        $year = $dt->year;
        $weeks = $report->prepareWeeksInYear($year);
        $thisWeek = $dt->weekOfYear;
        $months = $report->prepareMonthsInYear($year);
        $thisMonth = $dt->month;
        $years = $report->prepareYears();
        $thisYear = $dt->year;

        return view('reports.index',compact(['weeks','thisWeek','months','thisMonth','years','thisYear']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function weeks(Request $request, Report $report)
    {
        // Prepare Variables
        
        $dt = new Carbon();
        $today = $dt->now();
        $year = $today->year;
        $years = $report->prepareYears();
        // $years = [2017=>2017,2018=>2018];
        $week = $today->weekOfYear;
        $weeks = $report->prepareWeeksInYear($year);
        $thisWeek = $dt->setISODate($year,$week);
        $data = $report->prepareWeeksChart($year);
        $invoices = $report->prepareWeekData($year,$week);
        $totals = $report->prepareWeekTotals($year,$week);

        return view('reports.weeks',compact(['data','totals','invoices','weeks','years','year','week']));
    }

    public function months(Request $request, Report $report)
    {
        // Prepare Variables
        
        $dt = new Carbon();
        $today = $dt->now();
        $year = $today->year;
        $years = $report->prepareYears();
        // $years = [2017=>2017,2018=>2018];
        $month = $today->month;
        $months = $report->prepareMonthsInYear($year);
        $data = $report->prepareMonthsChart($year);
        $invoices = $report->prepareMonthsData($year,$month);
        $totals = $report->prepareMonthsTotals($year,$month);

        return view('reports.months',compact(['data','totals','invoices','months','years','year','month']));
    }

    public function years(Request $request, Report $report)
    {
        // Prepare Variables
        
        $dt = new Carbon();
        $today = $dt->now();
        $year = $today->year;
        $years = $report->prepareYears();
        // $years = [2017=>2017,2018=>2018];
        $data = $report->prepareYearChart($year);
        $invoices = $report->prepareYearData($year);
        $totals = $report->prepareYearTotals($year);

        return view('reports.years',compact(['data','totals','invoices','years','year']));
    }

    public function getWeeksFromYear(Request $request, Report $report)
    {
        $year = $request->year;
        $weeks = $report->prepareWeeksInYear($year);
        $dataset = $report->prepareWeeksChart($year);
        $invoices = $report->prepareWeekData($year,1);
        $totals = $report->prepareWeekTotals($year,1);
        return response()->json([
            'status' => true,
            'weeks' => $weeks,
            'dataset'=>$dataset,
            'invoices'=>$invoices,
            'totals'=>$totals
        ]);
    }   
    public function updateTableWeeks(Request $request, Report $report)
    {
        $year = $request->year;
        $week = $request->week;
        $invoices = $report->prepareWeekData($year,$week);
        $totals = $report->prepareWeekTotals($year,$week);
        return response()->json([
            'status' => true,
            'invoices'=>$invoices,
            'totals'=>$totals
        ]);
    }

    public function getMonthsFromYear(Request $request, Report $report)
    {
        $year = $request->year;
        $months = $report->prepareMonthsInYear($year);
        $dataset = $report->prepareMonthsChart($year);
        $invoices = $report->prepareMonthsData($year,1);
        $totals = $report->prepareMonthsTotals($year,1);
        return response()->json([
            'status' => true,
            'months' => $months,
            'dataset'=>$dataset,
            'invoices'=>$invoices,
            'totals'=>$totals
        ]);
    }   
    public function updateTableMonths(Request $request, Report $report)
    {
        $year = $request->year;
        $month = $request->month;
        $invoices = $report->prepareMonthsData($year,$month);
        $totals = $report->prepareMonthsTotals($year,$month);
        return response()->json([
            'status' => true,
            'invoices'=>$invoices,
            'totals'=>$totals
        ]);
    }   
    public function getYears(Request $request, Report $report)
    {
        // Prepare Variables
        
        $dt = new Carbon();
        $today = $dt->now();
        $year = $request->year;
        $dataset = $report->prepareYearChart($year);
        $invoices = $report->prepareYearData($year);
        $totals = $report->prepareYearTotals($year);
        return response()->json([
            'status' => true,
            'dataset'=>$dataset,
            'invoices'=>$invoices,
            'totals'=>$totals
        ]);
    }
}
