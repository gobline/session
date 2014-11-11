<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Session;

/**
 * Allows to segregate all session data into different namespaces.
 *
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
interface NamespacedSessionInterface
{
    /**
     * @param string $name
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function has($name);

    /**
     * @param string $name
     * @param string $value
     *
     * @return NamespacedSession
     */
    public function set($name, $value);

    /**
     * This method takes one or two arguments.
     * The first argument is the session variable you want to get.
     * The second optional argument is the default value you want to get back
     * in case the session variable hasn't been found.
     * If the second argument is omitted and the variable
     * hasn't been found, an exception will be thrown.
     *
     * @param mixed $args
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function get(...$args);

    /**
     * Returns an array of the session variables
     * for the current session namespace.
     *
     * @return array
     */
    public function getArrayCopy();

    /**
     * @param string $name
     *
     * @throws \InvalidArgumentException
     *
     * @return NamespacedSession
     */
    public function remove($name);

    /**
     * @return NamespacedSession
     */
    public function clearAll();

    /**
     * @param string $namespace
     *
     * @throws \InvalidArgumentException
     *
     * @return NamespacedSession
     */
    public function setNamespace($namespace);
}
