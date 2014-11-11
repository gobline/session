<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Session\Provider\Pimple;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Mendo\Session\NamespacedSession;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class SessionServiceProvider implements ServiceProviderInterface
{
    private $reference;

    public function __construct($reference = 'session')
    {
        $this->reference = $reference;
    }

    public function register(Container $container)
    {
        $container[$this->reference.'.namespace'] = 'Default';

        $container[$this->reference] = function ($c) {
            return new NamespacedSession($c[$this->reference.'.namespace']);
        };
    }
}
