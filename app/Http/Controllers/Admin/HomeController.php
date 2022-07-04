<?php

namespace App\Http\Controllers\Admin;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Illuminate\Support\Facades\Cache;
use App\Models\Game;
use App\Models\Customer;
use App\Models\Deposit;
use App\Models\Withdraw;

class HomeController
{
    public function index()
    {
        $homeValue = Cache::remember('HomeController:index:homeValue', 2, function () {

            $settings1 = [
                'chart_title'           => 'New Users',
                'chart_type'            => 'number_block',
                'report_type'           => 'group_by_date',
                'model'                 => 'App\Models\Customer',
                'group_by_field'        => 'created_at',
                'group_by_period'       => 'day',
                'aggregate_function'    => 'count',
                'filter_field'          => 'created_at',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class'          => 'col-md-4',
                'entries_number'        => '5',
                'translation_key'       => 'customer',
                'filter_days'           => 1,
            ];

            $settings1['total_number'] = 0;
            if (class_exists($settings1['model'])) {
                $settings1['total_number'] = $settings1['model']::when(isset($settings1['filter_field']), function ($query) use ($settings1) {
                    if (isset($settings1['filter_days'])) {
                        return $query->where($settings1['filter_field'], '>=',
                    now()->subDays($settings1['filter_days'])->format('Y-m-d'));
                    }
                    if (isset($settings1['filter_period'])) {
                        switch ($settings1['filter_period']) {
                    case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                    case 'month': $start = date('Y-m') . '-01'; break;
                    case 'year': $start = date('Y') . '-01-01'; break;
                }
                        if (isset($start)) {
                            return $query->where($settings1['filter_field'], '>=', $start);
                        }
                    }
                })
                    ->{$settings1['aggregate_function'] ?? 'count'}($settings1['aggregate_field'] ?? '*');
            }

            $settings2['total_number'] = Customer::where('status','active')->count();
            $settings2['chart_title'] = 'Users';

            $settings3['total_number'] = Game::where('status','on')->count();
            $settings3['chart_title'] = 'Games';

            $settings4 = [
                'chart_title'           => 'User Channel',
                'chart_type'            => 'bar',
                'report_type'           => 'group_by_relationship',
                'model'                 => 'App\Models\Customer',

                'relationship_name'     => 'channel', // represents function user() on Transaction model
                'group_by_field'        => 'name', // users.name

                'aggregate_function'    => 'count',
                'aggregate_field'       => 'name',
                'column_class'          => 'col-md-4',
                'chart_color'           => '23,105,255',
            ];

            $chart4 = new LaravelChart($settings4);

            $settings5= [
                'chart_title'           => 'User Game',
                'chart_type'            => 'bar',
                'report_type'           => 'group_by_relationship',
                'model'                 => 'App\Models\GameAccount',

                'relationship_name'     => 'game', // represents function user() on Transaction model
                'group_by_field'        => 'name', // users.name

                'aggregate_function'    => 'count',
                'aggregate_field'       => 'name',
                'column_class'          => 'col-md-4',
                'chart_color'           => '23,105,255',
            ];

            $chart5 = new LaravelChart($settings5);

            $settings6['total_number'] = Deposit::where('status','successfully')->where('txn_type','deposit')->count();
            $settings6['chart_title'] = 'รายการฝากสำเร็จ';

            $settings7['total_number'] = Withdraw::where('status','waiting')->where('txn_type','withdraw')->where('remark','NORMAL-WITHDRAW')->count();
            $settings7['chart_title'] = 'รายการถอนรออนุมัติ';

            $settings8['total_number'] = Withdraw::where('status','successfully')->where('txn_type','withdraw')->where('remark','NORMAL-WITHDRAW')->count();
            $settings8['chart_title'] = 'รายการถอนสำเร็จ';

            // return view('home', compact('settings1', 'settings2', 'settings3', 'chart4', 'chart5', 'settings6', 'settings7', 'settings8'));
            return compact('settings1', 'settings2', 'settings3', 'chart4', 'chart5', 'settings6', 'settings7', 'settings8');
        });
        // dd($homeValue);
        return view('home', $homeValue);
    }
}
