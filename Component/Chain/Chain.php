<?php

/*
 * This file is part of the VinceCms bundle.
 *
 * (c) Vincent Chalamon <http://www.vincent-chalamon.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\CmsBundle\Component\Chain;

/**
 * Manage tagged services for forms in contents
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class Chain
{
    /**
     * Services
     *
     * @var array
     */
    protected $services = array();

    /**
     * Add a tagged service
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     * @param object $service Service
     * @param string $alias   Service alias
     */
    public function add($service, $alias)
    {
        $this->services[$alias] = $service;
    }

    /**
     * Get a tagged service from its alias
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     * @param  string      $alias Service alias
     * @return object|null
     */
    public function get($alias)
    {
        return isset($this->services[$alias]) ? $this->services[$alias] : null;
    }

    /**
     * Check if tagged service exists from specified alias
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     * @param  string  $alias Service alias
     * @return boolean
     */
    public function has($alias)
    {
        return isset($this->services[$alias]);
    }

    /**
     * Get all tagged services
     *
     * @author Vincent Chalamon <vincent@ylly.fr>
     * @return array
     */
    public function all()
    {
        return $this->services;
    }
}
