<?php

/**
 * @author Mark Wilson <mark@89allport.co.uk>
 */

namespace Tickit\DashboardBundle\Listener;

use Tickit\CoreBundle\Entity\NavigationItem;
use Tickit\CoreBundle\Listener\NavigationBuilder as AbstractNavigationBuilder;

/**
 * Dashboard navigation builder
 *
 * @package Tickit\DashboardBundle\Listener
 */
class NavigationBuilder extends AbstractNavigationBuilder
{
    /**
     * Get navigation routes
     *
     * @return array
     */
    public function getRoutes()
    {
        return array(
            new NavigationItem('Dashboard', 'dashboard_index', 10)
        );
    }
}