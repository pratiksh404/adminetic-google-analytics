<?php

namespace Adminetic\GoogleAnalytics\Adapter;

use Pratiksh\Adminetic\Contracts\PluginInterface;
use Pratiksh\Adminetic\Traits\SidebarHelper;

class AdmineticGoogleAnalyticsAdapter implements PluginInterface
{
    use SidebarHelper;

    public function assets(): array
    {
        return  [
            [
                'name' => 'Charts',
                'active' => true,
                'files' => [
                    [
                        'type' => 'js',
                        'active' => true,
                        'location' => 'adminetic/assets/js/chart/apex-chart/apex-chart.js',
                    ],
                ],
            ],
            [
                'name' => 'Vector Map',
                'active' => true,
                'files' => [
                    [
                        'type' => 'css',
                        'active' => true,
                        'location' => 'adminetic/assets/css/vendors/vector-map.css',
                    ],
                    [
                        'type' => 'js',
                        'active' => true,
                        'location' => 'adminetic/assets/js/vector-map/jquery-jvectormap-2.0.2.min.js',
                    ],
                    [
                        'type' => 'js',
                        'active' => true,
                        'location' => 'adminetic/assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js',
                    ],
                ],
            ]
        ];
    }
}
