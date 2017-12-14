<?php

namespace App;
use App\Invoice;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    
    public function prepareWeeksInYear($year)
    {
    	$dt = new Carbon();
    	$today = Carbon::create($year,1,1,0,0,0);

    	$last = Carbon::parse('last day of december this year');
    	$weeks = [];

    	for ($i=1; $i <= $last->weekOfYear; $i++) { 
    		$thisWeek = $dt->setISODate($today->year,$i);
    		$weeks[$i] = $thisWeek->format('n/d/Y').' - '.$thisWeek->endOfWeek()->format('n/d/Y');
    	}

    	return $weeks;
    }

    public function prepareMonthsInYear()
    {
    	$start = Carbon::parse('january this year');
    	$months = [];
    	for ($i=1; $i <=12; $i++) { 
    		$thisMonth = $start->copy()->addMonths($i-1);
    		$months[$i] = $thisMonth->copy()->format('F');
    	}
    	return $months;
    }

    public function prepareYears()
    {
    	$start = 2017;
    	$today = Carbon::now();
    	$diff = $today->year - $start;
    	$years = [];
    	for ($i=$start; $i<=$start ; $i++) { 
    		$years[$start] = $i;
    	}

    	return $years;
    }

    public function prepareWeeksChart($year = null)
    {
    	$dt = Carbon::now();
    	$year = (isset($year)) ? $year : $dt->year;
    	$labels = $this->makeWeeksLabels($year);
    	$_data = $this->makeWeeksData($year);
    	$datasets = $this->makeWeeksDataSets($year, $_data);

    	$options = $this->makeWeeksOptions();

    	return [
    		'type'=>'line',
    		'labels'=>$labels,
    		'datasets'=>$datasets,
    		'options'=>$options
    	];
    }

    public function prepareWeekData($year, $week = null) {
    	// prepare variables
    	$dt = new Carbon();
    	
    	$last = Carbon::parse('last day of december this year');
    	$_data = [];
    	$invoices = new Invoice();
    	$thisWeek = $dt->setISODate($year,$week);
		$sw = $thisWeek->copy()->startOfWeek();
		$startWeek = $dt->create($sw->year,$sw->month,$sw->day,0,0,0);
		$startWeekFormatted = $startWeek->copy()->toDateTimeString();
		$ew = $thisWeek->copy()->endOfWeek();
		$endWeek = $dt->create($ew->year,$ew->month,$ew->day,23,59,59);
		$endWeekFormatted = $endWeek->copy()->toDateTimeString();

		// query 
		$data = $invoices->where('status','>',2)
			->whereBetween('created_at',[$startWeekFormatted,$endWeekFormatted])
			->get();

		// prepare totals
		if (count($data) > 0) {
			foreach ($data as $key => $value) {
				if (isset($value->id)){
					$data[$key]['id_formatted'] = str_pad($value->id,6,0, STR_PAD_LEFT);
				}

				if (isset($value->subtotal)){
					$data[$key]['subtotal'] = '$'.number_format($value->subtotal,2,'.',',');
				}

				if (isset($value->tax)){
					$data[$key]['tax'] = '$'.number_format($value->tax,2,'.',',');
				}

				if (isset($value->shipping_total)){
					$data[$key]['shipping_total'] = '$'.number_format($value->shipping_total,2,'.',',');
				}

				if (isset($value->total)){
					$data[$key]['total'] = '$'.number_format($value->total,2,'.',',');
				}

				
			}
		}

		return $data;
    }

    public function prepareWeekTotals($year, $week = null)
    {
    	// prepare variables
    	$dt = new Carbon();
    	$last = Carbon::parse('last day of december this year');
    	$_data = [];
    	$invoices = new Invoice();
    	$thisWeek = $dt->setISODate($year,$week);
		$sw = $thisWeek->copy()->startOfWeek();
		$startWeek = $dt->create($sw->year,$sw->month,$sw->day,0,0,0);
		$startWeekFormatted = $startWeek->copy()->toDateTimeString();
		$ew = $thisWeek->copy()->endOfWeek();
		$endWeek = $dt->create($ew->year,$ew->month,$ew->day,23,59,59);
		$endWeekFormatted = $endWeek->copy()->toDateTimeString();

		// query 
		$totals = $invoices->where('status','>',2)
			->whereBetween('created_at',[$startWeekFormatted,$endWeekFormatted])
			->select(\DB::raw('sum(quantity) as _quantity'),\DB::raw('sum(subtotal) as _subtotal'),\DB::raw('sum(tax) as _tax'),\DB::raw('sum(shipping_total) as _shipping_total'),\DB::raw('sum(total) as _total'))
			->get();

		// prepare totals
		if (count($totals) > 0) {
			foreach ($totals as $key => $value) {
				if (isset($value->_subtotal)){
					$totals[$key]['subtotal'] = '$'.number_format($value->_subtotal,2,'.',',');
				}

				if (isset($value->_tax)){
					$totals[$key]['tax'] = '$'.number_format($value->_tax,2,'.',',');
				}

				if (isset($value->_shipping_total)){
					$totals[$key]['shipping_total'] = '$'.number_format($value->_shipping_total,2,'.',',');
				}

				if (isset($value->_total)){
					$totals[$key]['total'] = '$'.number_format($value->_total,2,'.',',');
				}

				
			}
		}

    	return $totals;   
    }
    //Month
    public function prepareMonthsChart($year)
    {
    	$dt = Carbon::now();
    	$year= (isset($year)) ? $year : $dt->year;
    	$labels = $this->makeMonthsLabels($year);
    	$_data = $this->makeMonthsData($year);
    	$datasets = $this->makeMonthsDataSets($year, $_data);

    	$options = $this->makeMonthsOptions();

    	return [
    		'type'=>'bar',
    		'labels'=>$labels,
    		'datasets'=>$datasets,
    		'options'=>$options
    	];
    }

    public function prepareMonthsData($year, $month) {
    	// prepare variables
    	$dt = new Carbon();
    	
    	$_data = [];
    	$invoices = new Invoice();
        $thisMonth = $dt->create($year,$month,1,0,0,0);
		$sm = $thisMonth->copy()->startOfMonth();
		$startMonth = $dt->create($sm->year,$sm->month,$sm->day,0,0,0);
		$startMonthFormatted = $startMonth->copy()->toDateTimeString();
		$em = $thisMonth->copy()->endOfMonth();
		$endMonth = $dt->create($em->year,$em->month,$em->day,23,59,59);
		$endMonthFormatted = $endMonth->copy()->toDateTimeString();

		// query 
		$data = $invoices->where('status','>',2)
			->whereBetween('created_at',[$startMonthFormatted,$endMonthFormatted])
			->get();

		// prepare totals
		if (count($data) > 0) {
			foreach ($data as $key => $value) {
				if (isset($value->id)){
					$data[$key]['id_formatted'] = str_pad($value->id,6,0, STR_PAD_LEFT);
				}

				if (isset($value->subtotal)){
					$data[$key]['subtotal'] = '$'.number_format($value->subtotal,2,'.',',');
				}

				if (isset($value->tax)){
					$data[$key]['tax'] = '$'.number_format($value->tax,2,'.',',');
				}

				if (isset($value->shipping_total)){
					$data[$key]['shipping_total'] = '$'.number_format($value->shipping_total,2,'.',',');
				}

				if (isset($value->total)){
					$data[$key]['total'] = '$'.number_format($value->total,2,'.',',');
				}

				
			}
		}

		return $data;
    }

    public function prepareMonthsTotals($year, $month = null)
    {
    	// prepare variables
    	$dt = new Carbon();
    	$_data = [];
    	$invoices = new Invoice();
    	$thisMonth = $dt->create($year,$month,1,0,0,0);
		$sm = $thisMonth->copy()->startOfMonth();
		$startMonth = $dt->create($sm->year,$sm->month,$sm->day,0,0,0);
		$startMonthFormatted = $startMonth->copy()->toDateTimeString();
		$em = $thisMonth->copy()->endOfMonth();
		$endMonth = $dt->create($em->year,$em->month,$em->day,23,59,59);
		$endMonthFormatted = $endMonth->copy()->toDateTimeString();

		// query 
		$totals = $invoices->where('status','>',2)
			->whereBetween('created_at',[$startMonthFormatted,$endMonthFormatted])
			->select(\DB::raw('sum(quantity) as _quantity'),\DB::raw('sum(subtotal) as _subtotal'),\DB::raw('sum(tax) as _tax'),\DB::raw('sum(shipping_total) as _shipping_total'),\DB::raw('sum(total) as _total'))
			->get();

		// prepare totals
		if (count($totals) > 0) {
			foreach ($totals as $key => $value) {
				if (isset($value->_subtotal)){
					$totals[$key]['subtotal'] = '$'.number_format($value->_subtotal,2,'.',',');
				}

				if (isset($value->_tax)){
					$totals[$key]['tax'] = '$'.number_format($value->_tax,2,'.',',');
				}

				if (isset($value->_shipping_total)){
					$totals[$key]['shipping_total'] = '$'.number_format($value->_shipping_total,2,'.',',');
				}

				if (isset($value->_total)){
					$totals[$key]['total'] = '$'.number_format($value->_total,2,'.',',');
				}
			}
		}

    	return $totals;   
    }

    //Year
    public function prepareYearChart($year = null)
    {
    	$dt = Carbon::now();
    	$year = (isset($year)) ? $year : $dt->year;
    	$labels = $this->makeYearLabels($year);
    	$_data = $this->makeYearData($year);
    	$datasets = $this->makeYearDataSets($year, $_data);

    	$options = $this->makeYearOptions();

    	return [
    		'type'=>'bar',
    		'labels'=>$labels,
    		'datasets'=>$datasets,
    		'options'=>$options
    	];
    }

    public function prepareYearData($year = null) {
    	// prepare variables
    	$dt = new Carbon();
    	$_data = [];
    	$invoices = new Invoice();
        $thisYear = $dt->create($year,1,1,0,0,0);
		$sy = $thisYear->copy()->startOfYear();
		$startYear = $dt->create($sy->year,$sy->month,$sy->day,0,0,0);
		$startYearFormatted = $startYear->copy()->toDateTimeString();
		$ey = $thisYear->copy()->endOfYear();
		$endYear = $dt->create($ey->year,$ey->month,$ey->day,23,59,59);
		$endYearFormatted = $endYear->copy()->toDateTimeString();

		// query 
		$data = $invoices->where('status','>',2)
			->whereBetween('created_at',[$startYearFormatted,$endYearFormatted])
			->get();

		// prepare totals
		if (count($data) > 0) {
			foreach ($data as $key => $value) {
				if (isset($value->id)){
					$data[$key]['id_formatted'] = str_pad($value->id,6,0, STR_PAD_LEFT);
				}

				if (isset($value->subtotal)){
					$data[$key]['subtotal'] = '$'.number_format($value->subtotal,2,'.',',');
				}

				if (isset($value->tax)){
					$data[$key]['tax'] = '$'.number_format($value->tax,2,'.',',');
				}

				if (isset($value->shipping_total)){
					$data[$key]['shipping_total'] = '$'.number_format($value->shipping_total,2,'.',',');
				}

				if (isset($value->total)){
					$data[$key]['total'] = '$'.number_format($value->total,2,'.',',');
				}

				
			}
		}

		return $data;
    }

    public function prepareYearTotals($year = null)
    {
    	// prepare variables
    	$dt = new Carbon();
    	$_data = [];
    	$invoices = new Invoice();
    	$thisYear = $dt->create($year,1,1,0,0,0);
		$sy = $thisYear->copy()->startOfYear();
		$startYear = $dt->create($sy->year,$sy->month,$sy->day,0,0,0);
		$startYearFormatted = $startYear->copy()->toDateTimeString();
		$ey = $thisYear->copy()->endOfYear();
		$endYear = $dt->create($ey->year,$ey->month,$ey->day,23,59,59);
		$endYearFormatted = $endYear->copy()->toDateTimeString();

		// query 
		$totals = $invoices->where('status','>',2)
			->whereBetween('created_at',[$startYearFormatted,$endYearFormatted])
			->select(\DB::raw('sum(quantity) as _quantity'),\DB::raw('sum(subtotal) as _subtotal'),\DB::raw('sum(tax) as _tax'),\DB::raw('sum(shipping_total) as _shipping_total'),\DB::raw('sum(total) as _total'))
			->get();

		// prepare totals
		if (count($totals) > 0) {
			foreach ($totals as $key => $value) {
				if (isset($value->_subtotal)){
					$totals[$key]['subtotal'] = '$'.number_format($value->_subtotal,2,'.',',');
				}

				if (isset($value->_tax)){
					$totals[$key]['tax'] = '$'.number_format($value->_tax,2,'.',',');
				}

				if (isset($value->_shipping_total)){
					$totals[$key]['shipping_total'] = '$'.number_format($value->_shipping_total,2,'.',',');
				}

				if (isset($value->_total)){
					$totals[$key]['total'] = '$'.number_format($value->_total,2,'.',',');
				}
			}
		}

    	return $totals;   
    }




    // PRivate functions

    private function makeWeeksLabels($year)
    {
		$data = [];
    	$dt = new Carbon();
    	$last = Carbon::create($year,1,1,0,0,0);

    	for ($i=1; $i <= 52; $i++) { 

    		$thisWeek = $dt->setISODate($year,$i);

    		array_push($data, $thisWeek->format('n/d/Y').' - '.$thisWeek->endOfWeek()->format('n/d/Y'));
    	}

    	return $data;    	
    }

    private function makeWeeksData($year)
    {
    	$dt = new Carbon();
    	$last = Carbon::create($year,1,1,0,0,0);
    	$_data = [];
    	$invoices = new Invoice();
    	

    	for ($i=1; $i <= 52; $i++) { 

    		$thisWeek = $dt->setISODate($year,$i);
    		$sw = $thisWeek->copy()->startOfWeek();
    		$startWeek = $dt->create($sw->year,$sw->month,$sw->day,0,0,0);
    		$startWeekFormatted = $startWeek->copy()->toDateTimeString();
    		$ew = $thisWeek->copy()->endOfWeek();
    		$endWeek = $dt->create($ew->year,$ew->month,$ew->day,23,59,59);
    		$endWeekFormatted = $endWeek->copy()->toDateTimeString();
    		$total = $invoices->where('status','>',2)->whereBetween('created_at',[$startWeekFormatted,$endWeekFormatted])->sum('total');
    		array_push($_data, $total);
  
    	}
    	return $_data;    	
    }

    private function makeWeeksDataSets($year, $_data)
    {
  
    	$dt = new Carbon();
    	$today = $dt->now();
    	$get = Carbon::create($year, 1,1,0,0,0);
    	$last = Carbon::create($year,12,31,0,0,0);
    	$data = [];
    	$label = "Total";
    	$row = (object) [
    		'label'=>$label,
    		'backgroundColor'=>'rgba(32,168,216,.2)',
    		'borderColor'=>'rgba(32,168,216,1)',
    		'pointHoverBackgroundColor'=> '#fff',
    		'borderWidth'=>2,
    		'data'=>$_data
    	];
    	array_push($data, $row);

    	return $data;



    }

    private function makeWeeksOptions()
    {
    	$options = (object) [
    		'maintainAspectRatio'=> false,
    		'legend' => (object) ['display'=>false],
    		'scales' => (object) [
    			'xAxes'=>[
    				(object) [
    					'gridLines' => (object) [
    						'drawOnChartArea'=> false,
    					]
    				]
    			],
    			'yAxes'=> [
    				(object) [
    					'ticks'=> (object) [
    						'beginAtZero'=> true
    					]

    				]
    			]
    		],
    		'elements' => (object) [
    			'point' => (object) [
    				'radius'=> 0,
    				'hitRadius'=> 10,
    				'hoverRadius'=> 4,
    				'hoverBorderWidth'=> 3
    			]
    		]
    	];

    	return $options;
    }
    // Month
    private function makeMonthsLabels($year)
    {
		$data = [];
    	$dt = new Carbon();

    	for ($i=1; $i <= 12; $i++) { 

    		$thisMonth = $dt->create($year,$i,1,0,0,0);

    		array_push($data, $thisMonth->format('F'));
    	}

    	return $data;    	
    }

    private function makeMonthsData($year)
    {
    	$data = [];
    	$dt = new Carbon();
    	$_data = [];
    	$invoices = new Invoice();
  
    	

    	for ($i=1; $i <= 12; $i++) { 

    		$thisMonth = $dt->create($year,$i,1,0,0,0);
    		$sm = $thisMonth->copy()->startOfMonth();
			$startMonth = $dt->create($sm->year,$sm->month,$sm->day,0,0,0);
			$startMonthFormatted = $startMonth->copy()->toDateTimeString();
			$em = $thisMonth->copy()->endOfMonth();
			$endMonth = $dt->create($em->year,$em->month,$em->day,23,59,59);
			$endMonthFormatted = $endMonth->copy()->toDateTimeString();
    		$total = $invoices->where('status','>',2)->whereBetween('created_at',[$startMonthFormatted,$endMonthFormatted])->sum('total');
    		array_push($_data, $total);
    	}

    	return $_data;    	
    }

    private function makeMonthsDataSets($year, $_data)
    {
  
    	$dt = new Carbon();
    	$label = 'Total';
    	$data = [];

    	$row = (object) [
    		'label'=>$label,
    		'backgroundColor'=>'rgba(32,168,216,.2)',
    		'borderColor'=>'rgba(32,168,216,1)',
    		'pointHoverBackgroundColor'=> '#fff',
    		'borderWidth'=>2,
    		'data'=>$_data

    	];

    	array_push($data, $row);

    	return $data;



    }

    private function makeMonthsOptions()
    {
    	$options = (object) [
    		'maintainAspectRatio'=> false,
    		'legend' => (object) ['display'=>false],
    		'scales' => (object) [
    			'xAxes'=>[
    				(object) [
    					'gridLines' => (object) [
    						'drawOnChartArea'=> false,
    					]
    				]
    			],
    			'yAxes'=> [
    				(object) [
    					'ticks'=> (object) [
    						'beginAtZero'=> true
    					]

    				]
    			]
    		],
    		'elements' => (object) [
    			'point' => (object) [
    				'radius'=> 0,
    				'hitRadius'=> 10,
    				'hoverRadius'=> 4,
    				'hoverBorderWidth'=> 3
    			]
    		]
    	];

    	return $options;
    }

    // Year
    private function makeYearLabels($year)
    {
		$data = [];
    	$dt = new Carbon();
    	$today = Carbon::now();

    	for ($i=2017; $i <= $year+10; $i++) { 

    		$thisYear = $dt->create($i,1,1,0,0,0);

    		array_push($data, $i);
    	}

    	return $data;    	
    }

    private function makeYearData($year)
    {
    	$data = [];
    	$dt = new Carbon();
    	$_data = [];
    	$invoices = new Invoice();
  
    	

    	for ($i=2017; $i <= $year+10; $i++) { 

    		$thisYear = $dt->create($i,1,1,0,0,0);
    		$sy = $thisYear->copy()->startOfYear();
			$startYear = $dt->create($sy->year,$sy->month,$sy->day,0,0,0);
			$startYearFormatted = $startYear->copy()->toDateTimeString();
			$ey = $thisYear->copy()->endOfYear();
			$endYear = $dt->create($ey->year,$ey->month,$ey->day,23,59,59);
			$endYearFormatted = $endYear->copy()->toDateTimeString();
    		$total = $invoices->where('status','>',2)->whereBetween('created_at',[$startYearFormatted,$endYearFormatted])->sum('total');
    		array_push($_data, $total);
    	}

    	return $_data;    	
    }

    private function makeYearDataSets($year, $_data)
    {
  
    	$dt = new Carbon();
    	$thisYear = $dt->create($year,1,1,0,0,0);
    	$label = 'Total';
    	$data = [];

    	$row = (object) [
    		'label'=>$label,
    		'backgroundColor'=>'rgba(32,168,216,.2)',
    		'borderColor'=>'rgba(32,168,216,1)',
    		'pointHoverBackgroundColor'=> '#fff',
    		'borderWidth'=>2,
    		'data'=>$_data

    	];

    	array_push($data, $row);

    	return $data;



    }

    private function makeYearOptions()
    {
    	$options = (object) [
    		'maintainAspectRatio'=> false,
    		'legend' => (object) ['display'=>false],
    		'scales' => (object) [
    			'xAxes'=>[
    				(object) [
    					'gridLines' => (object) [
    						'drawOnChartArea'=> false,
    					]
    				]
    			],
    			'yAxes'=> [
    				(object) [
    					'ticks'=> (object) [
    						'beginAtZero'=> true
    					]

    				]
    			]
    		],
    		'elements' => (object) [
    			'point' => (object) [
    				'radius'=> 0,
    				'hitRadius'=> 10,
    				'hoverRadius'=> 4,
    				'hoverBorderWidth'=> 3
    			]
    		]
    	];

    	return $options;
    }
}
