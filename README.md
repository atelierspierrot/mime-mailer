MIME Mailer
===========

A PHP package to send rich MIME emails.

## How-to

As for all our work, we try to follow the coding standards and naming rules most commonly in use:

-   the [PEAR coding standards](http://pear.php.net/manual/en/standards.php)
-   the [PHP Framework Interoperability Group standards](https://github.com/php-fig/fig-standards).

Knowing that, all classes are named and organized in an architecture to allow the use of the
[standard SplClassLoader](https://gist.github.com/jwage/221634).

The whole package is embedded in the `MimeMailer` namespace.


## Installation

You can use this package in your work in many ways.

First, you can clone the [GitHub](https://github.com/atelierspierrot/mime-mailer) repository
and include it "as is" in your poject:

    https://github.com/atelierspierrot/mime-mailer

You can also download an [archive](https://github.com/atelierspierrot/mime-mailer/downloads)
from Github.

Then, to use the package classes, you just need to register the `MimeMailer` namespace directory
using the [SplClassLoader](https://gist.github.com/jwage/221634) or any other custom autoloader:

    require_once '.../src/SplClassLoader.php'; // if required, a copy is proposed in the package
    $classLoader = new SplClassLoader('MimeMailer', '/path/to/package/src');
    $classLoader->register();

If you are a [Composer](http://getcomposer.org/) user, just add the package to your requirements
in your `composer.json`:

    "require": {
        ...
        "atelierspierrot/mime-mailer": "dev-master"
    }

The namespace will be automatically added to the project Composer autoloader.


## Usage

To create a Mailer instance, just write:

    $mailer = \MimeMailer\Mailer::getInstance();

You can define a set of user options writing:

    $mailer = \MimeMailer\Mailer::getInstance(array(
        'options name' => 'option value',
        ...
    ));

The `Mailer` instance acts like a global container to build messages and send them. It handles
a set of messages as an array. From this container, you can access to:

    $mailer->getMessage() // the current message object
    $mailer->getTransporter() // the current transporter object
    $mailer->getSpooler() // the current spooler object

To work on current message, you can write:

    $mailer->getMessage() // the message will be created if none was defined
        ->setTo(...)
        ->setSubject(...)
        ->setText(...)
        ...
        ;

Many methods are defined to build a message, please refer to the PHP class itself to learn more.

All "persons" fields can be defined as the followings:

	 ( 'my@email.address' )
	 ( 'my@email.address', 'my name' )
	 ( array( 'my name'=>'my@email.address' ) )
	 ( array( 'my name'=>'my@email.address', 'another name'=>'another@email.address' ) )
	 ( array( 'my name'=>'my@email.address', 'another@email.address' ) )

Finally, to send built messages, just write:

    $mailer->send()

Some logs are accessibles from the container with:

    $mailer->getErrors()
    $mailer->getInfos()


## Development

To install all PHP packages for development, just run:

    ~$ composer install --dev

A documentation can be generated with [Sami](https://github.com/fabpot/Sami) running:

    ~$ php vendor/sami/sami/sami.php render sami.config.php

The latest version of this documentation is available online at <http://docs.ateliers-pierrot.fr/mime-mailer/>.


## Author & License

>    Assets Manager

>    https://github.com/atelierspierrot/mime-mailer

>    Copyleft 2013, Pierre Cassat and contributors

>    Licensed under the GPL Version 3 license.

>    http://opensource.org/licenses/GPL-3.0

>    ----

>    Les Ateliers Pierrot - Paris, France

>    <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
