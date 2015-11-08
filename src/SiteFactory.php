<?php

namespace App;

use App\Model\Entity;
use Interop\Container\ContainerInterface;
use Symfony\Component\Yaml\Yaml;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
/**
 * Creates the site entity
 */
class SiteFactory
{
    /**
     * Create the site entity.
     *
     * @param ContainerInterface $container The app container.
     *
     * @return Entity The site entity.
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        if (!isset($config['site-config-path'])) {
            throw new ServiceNotCreatedException('The `site-config-path` must be set in the container `config` service');
        }

        $siteData = Yaml::parse($config['site-config-path']);

        if (!is_array($siteData)) {
            throw new ServiceNotCreatedException('Could not load array of site data from: ' . $config['site-config-path']);
        }

        return new Entity('site', $siteData);
    }
}
