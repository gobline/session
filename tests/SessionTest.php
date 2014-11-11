<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Mendo\Session\NamespacedSession;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class SessionTest extends PHPUnit_Framework_TestCase
{
    private $session;

    public function setUp()
    {
        @session_destroy();
        @session_start();

        $this->session = new NamespacedSession();
    }

    public function testEmptyNamespace()
    {
        $this->setExpectedException('\InvalidArgumentException', 'empty');
        new NamespacedSession('');
    }

    public function testAddSessionVariableAndRetrieveIt()
    {
        $this->session->set('hello', 'world');

        $this->assertSame('world', $this->session->get('hello'));
    }

    public function testGetSessionVariableNonExistent()
    {
        $this->setExpectedException('\InvalidArgumentException', 'not found');
        $this->session->get('hello');
    }

    public function testGetSessionVariableOrDefaultIfNonExistent()
    {
        $this->assertSame('default', $this->session->get('hello', 'default'));
    }

    public function testAddEmptySessionVariable()
    {
        $this->setExpectedException('\InvalidArgumentException', 'empty');
        $this->session->set('', 'world');
    }

    public function testAddSessionVariableAndRemoveIt()
    {
        $this->session->set('hello', 'world');

        $this->assertSame('world', $this->session->get('hello', 'default'));

        $this->session->remove('hello');

        $this->assertSame('default', $this->session->get('hello', 'default'));
    }

    public function testAddSessionVariablesAndClearAll()
    {
        $this->session->set('hello', 'world')
            ->set('foo', 'bar');

        $this->assertSame('world', $this->session->get('hello', 'default'));
        $this->assertSame('bar', $this->session->get('foo', 'default'));

        $this->session->clearAll();

        $this->assertSame('default', $this->session->get('hello', 'default'));
        $this->assertSame('default', $this->session->get('foo', 'default'));
    }

    public function testSwitchSessionNamespace()
    {
        @session_destroy();
        @session_start();

        $session1 = new NamespacedSession('namespace1');
        $session1->set('hello', 'world');

        $session2 = new NamespacedSession('namespace2');
        $session2->set('foo', 'bar');

        $this->assertSame('world', $session1->get('hello', 'default'));
        $this->assertSame('default', $session1->get('foo', 'default'));

        $session1->setNamespace('namespace2');

        $this->assertSame('default', $session1->get('hello', 'default'));
        $this->assertSame('bar', $session1->get('foo', 'default'));
    }
}
