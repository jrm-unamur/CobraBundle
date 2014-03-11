<?php

namespace Unamur\CobraBundle;

use Claroline\CoreBundle\Library\PluginBundle;
use Claroline\KernelBundle\Bundle\ConfigurationBuilder;

class UnamurCobraBundle extends PluginBundle
{
    public function getConfiguration($environment)
    {
        $config = new ConfigurationBuilder();

        if (file_exists($routingFile = __DIR__ . '/Resources/config/routing.yml'))
        {
            $config->addRoutingResource($routingFile, null, 'cobra');
        }
        return $config;
    }

}
