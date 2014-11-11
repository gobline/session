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
 * A default namespace exists for those who only want one namespace for all their session data.
 *
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class NamespacedSession implements NamespacedSessionInterface
{
    const DEFAULT_NAMESPACE = 'Default';

    private $namespace;

    /**
     * @param string $namespace
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($namespace = self::DEFAULT_NAMESPACE)
    {
        if (session_id() == '') {
            session_start();
        }

        $this->setNamespace($namespace);
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        return array_key_exists($name, $_SESSION[$this->namespace]);
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
        if ((string) $name === '') {
            throw new \InvalidArgumentException('$name cannot be empty');
        }

        $_SESSION[$this->namespace][$name] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get(...$args)
    {
        switch (count($args)) {
            default:
                throw new \InvalidArgumentException('get() takes one or two arguments');
            case 1:
                if (!$this->has($args[0])) {
                    throw new \InvalidArgumentException('Session variable "'.$args[0].'" in namespace "'.$this->namespace.'" not found');
                }

                return $_SESSION[$this->namespace][$args[0]];
            case 2:
                if (!$this->has($args[0])) {
                    return $args[1];
                }

                return $_SESSION[$this->namespace][$args[0]];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getArrayCopy()
    {
        return $_SESSION[$this->namespace];
    }

    /**
     * {@inheritdoc}
     */
    public function remove($name)
    {
        unset($_SESSION[$this->namespace][$name]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function clearAll()
    {
        $_SESSION[$this->namespace] = [];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setNamespace($namespace)
    {
        $namespace = (string) $namespace;
        if ($namespace === '') {
            throw new \InvalidArgumentException('$namespace cannot be empty');
        }

        if (!ctype_alpha($namespace[0]) && $namespace[0] !== '_') {
            throw new \InvalidArgumentException('$namespace must start with a letter or underscore');
        }

        if (!isset($_SESSION[$namespace])) {
            $_SESSION[$namespace] = [];
        } elseif (!is_array($_SESSION[$namespace])) {
            throw new \InvalidArgumentException('Cannot use namespace "'.$namespace.'": session key "'.$namespace.'" already in use');
        }

        $this->namespace = $namespace;

        return $this;
    }
}
