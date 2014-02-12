<?php

namespace JrmUnamur\CobraBundle;

use Claroline\CoreBundle\Library\PluginBundle;
use Claroline\KernelBundle\Bundle\ConfigurationBuilder;

class JrmUnamurCobraBundle extends PluginBundle
{
    public function getConfiguration($environment)
    {
        $config = new ConfigurationBuilder();

        if (file_exists($routingFile = __DIR__ . '/Resources/config/routing.yml'))
        {
            $config->addRoutingResource($routingFile, null, 'icap_cobra');
        }
        return $config;
    }

}
