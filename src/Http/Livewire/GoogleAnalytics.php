<?php

namespace Adminetic\GoogleAnalytics\Http\Livewire;

use Livewire\Component;
use Spatie\Analytics\Period;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Facades\Analytics;

class GoogleAnalytics extends Component
{
    public $days = 365;
    // Current Active Users
    public $analytic_data;

    public $page_count;

    public $avg_time;

    public $active_users;

    public $page_views;

    protected $listeners = ['initialize_google_analytics' => 'initializeGoogleAnalytics'];
    public function mount()
    {
        $this->getData();
    }
    public function updated()
    {
        $this->getData();
    }
    public function render()
    {
        return view('livewire.google-analytics');
    }

    public function initializeGoogleAnalytics()
    {
        $this->getData();
    }

    public function getData()
    {
        $analytic_data = Analytics::get(
            Period::days($this->days),
            ['activeUsers', 'screenPageViews', 'userEngagementDuration'],
            ['browser', 'continent', 'continentId', 'country', 'countryId', 'mobileDeviceBranding', 'operatingSystem', 'pageTitle'],
            100,
        );

        $country_count = collect($analytic_data)->groupBy(fn ($d) => $d['countryId'])->map(fn ($data) => $data->first()['activeUsers'])->toArray();

        $this->dispatchBrowserEvent('initializeWorldMap', $country_count);

        $browser_count = collect($analytic_data)->groupBy(fn ($d) => $d['browser'])->map(fn ($data) => $data->first()['activeUsers'])->toArray();

        $mobile_count = collect($analytic_data)->groupBy(fn ($d) => $d['mobileDeviceBranding'])->map(fn ($data) => $data->first()['activeUsers'])->toArray();

        $os_count = collect($analytic_data)->groupBy(fn ($d) => $d['operatingSystem'])->map(fn ($data) => $data->first()['activeUsers'])->toArray();

        $new_vs_returning_visitors = collect(Analytics::fetchUserTypes(Period::days($this->days)))->mapWithKeys(fn ($d) => [$d['newVsReturning'] => $d['activeUsers']]);

        $this->dispatchBrowserEvent('initializeNewVsReturningVisitor', $new_vs_returning_visitors);

        $this->page_count = collect($analytic_data)->sortByDesc(fn ($d) => $d['screenPageViews'])->groupBy(fn ($d) => $d['pageTitle'])->map(fn ($data) => [
            'views' => $data->first()['screenPageViews'],
            'duration' => $data->first()['userEngagementDuration'],
            'browser' => $data->first()['browser'],
            'mobileDeviceBranding' => $data->first()['mobileDeviceBranding'],
            'operatingSystem' => $data->first()['operatingSystem'],
        ])->take(10)->toArray();

        $this->dispatchBrowserEvent('initializeDeviceCount', [
            'browser_count' => $browser_count,
            'mobile_count' => $mobile_count,
            'os_count' => $os_count,
        ]);

        $this->avg_time =
            Analytics::get(
                Period::days($this->days),
                ['activeUsers'],
                [],
                1,
                orderBy: [
                    OrderBy::metric('activeUsers', true),
                ],
            );

        $this->active_users =
            Analytics::get(
                Period::days($this->days),
                ['activeUsers'],
                [],
                1,
                orderBy: [
                    OrderBy::metric('activeUsers', true),
                ],
            );

        $this->page_views =
            Analytics::get(
                Period::days($this->days),
                ['screenPageViews'],
                [],
                1,
                orderBy: [
                    OrderBy::metric('screenPageViews', true),
                ],
            );
    }
}
