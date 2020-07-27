<?php

namespace App\Architect;

use JPeters\Architect\Dashboards\DashboardContract;
use JPeters\Architect\Dashboards\DashboardGenerator;

class Dashboard implements DashboardContract
{
    public function build(): DashboardGenerator
    {
        return (new DashboardGenerator())
            ->redirectTo('blueprintList', true, ['blueprint' => 'group']);
    }
}
