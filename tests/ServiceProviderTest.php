<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Mendo\Session\Provider\Pimple\SessionServiceProvider;
use Pimple\Container;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class ServiceProviderTest extends PHPUnit_Framework_TestCase
{
    public function testServiceProvider()
    {
        @session_destroy();
        @session_start();

        $container = new Container();
        $container->register(new SessionServiceProvider());
        $this->assertInstanceOf('Mendo\Session\NamespacedSession', $container['session']);
    }
}
