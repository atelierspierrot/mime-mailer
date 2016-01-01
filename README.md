MIME Mailer
===========

[![demonstation](http://img.ateliers-pierrot-static.fr/see-the-demo.svg)](http://sites.ateliers-pierrot.fr/mime-mailer/)
[![documentation](http://img.ateliers-pierrot-static.fr/read-the-doc.svg)](http://docs.ateliers-pierrot.fr/mime-mailer/)
A PHP package to send rich MIME emails.


Usage
-----

To create a Mailer instance, just write:

```php
$mailer = \MimeMailer\Mailer::getInstance();
```

You can define a set of user options writing:

```php
$mailer = \MimeMailer\Mailer::getInstance(array(
    'options name' => 'option value',
    //...
));
```

The `Mailer` instance acts like a global container to build messages and send them. It handles
a set of messages as an array. From this container, you can access to:

```php
$mailer->getMessage() // the current message object
$mailer->getTransporter() // the current transporter object
$mailer->getSpooler() // the current spooler object
```

To work on current message, you can write:

```php
$mailer->getMessage() // the message will be created if none was defined
    ->setTo(...)
    ->setSubject(...)
    ->setText(...)
    //...
    ;
```

Many methods are defined to build a message, please refer to the PHP class itself to learn more.

All "persons" fields can be defined as the followings:

```php
 ( 'my@email.address' )
 ( 'my@email.address', 'my name' )
 ( array( 'my name'=>'my@email.address' ) )
 ( array( 'my name'=>'my@email.address', 'another name'=>'another@email.address' ) )
 ( array( 'my name'=>'my@email.address', 'another@email.address' ) )
```

Finally, to send built messages, just write:

```php
$mailer->send()
```

Some logs are accessibles from the container with:

```php
$mailer->getErrors()
$mailer->getInfos()
```


Installation
------------

For a complete information about how to install this package and load its namespace, 
please have a look at [our *USAGE* documentation](http://github.com/atelierspierrot/atelierspierrot/blob/master/USAGE.md).

If you are a [Composer](http://getcomposer.org/) user, just add the package to the 
requirements of your project's `composer.json` manifest file:

```json
"atelierspierrot/mime-mailer": "@stable"
```

You can use a specific release or the latest release of a major version using the appropriate
[version constraint](http://getcomposer.org/doc/01-basic-usage.md#package-versions).

Please note that this package depends on the externals [PHP Patterns](http://github.com/atelierspierrot/patterns),
[PHP Library](http://github.com/atelierspierrot/library) and [PHP Validators](http://github.com/atelierspierrot/validators).


Author & License
----------------

>    MIME Mailer

>    http://github.com/atelierspierrot/mime-mailer

>    Copyright (c) 2013-2016 Pierre Cassat and contributors

>    Licensed under the Apache Version 2.0 license.

>    http://www.apache.org/licenses/LICENSE-2.0

>    ----

>    Les Ateliers Pierrot - Paris, France

>    <http://www.ateliers-pierrot.fr/> - <contact@ateliers-pierrot.fr>
