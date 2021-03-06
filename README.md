# Session component

```Gobline\Session\NamespacedSession``` allows to **segregate all session data into different namespaces**.
A default namespace exists for those who only want one namespace for all their session data.

## Usage

```php
$session = new Gobline\Session\NamespacedSession('MyNamespace');

$session->set('foo', 'bar');

$session->get('foo'); // returns "bar"

$session->get('corge'); // "corge" not found, throws \InvalidArgumentException

$session->get('corge', 'grault'); // "corge" not found, returns default "grault" value

$session->remove('foo');

$session->clearAll(); // removes all session variables from "MyNamespace" namespace

$session->setNamespace('AnotherNamespace'); // switch namespace
```

## Installation

You can install the Session component using the dependency management tool [Composer](https://getcomposer.org/).
Run the *require* command to resolve and download the dependencies:

```
composer require gobline/session
```