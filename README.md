# Event Sourcing and CQRS with Broadway Workshop

 * [Download](https://beau.io/es-cqrs-broadway-workshop.zip) (includes vendor)
 * Talks
   * PHP Benelux 2016
     * ["Introduction to Event Sourcing and CQRS with Broadway" slides](https://beau.io/talks/2016/01/29/introduction-to-event-sourcing-and-cqrs-with-broadway-phpbnl16/)
   * DPC 2015
     * ["Introduction to Event Sourcing and CQRS with Broadway" (afternoon session) slides](https://beau.io/talks/2015/06/25/introduction-to-event-sourcing-and-cqrs-with-broadway-dpc-2015)
     * ["Introduction to Event Sourcing and CQRS" (morning session) slides](https://beau.io/talks/2015/06/25/introduction-to-event-sourcing-and-cqrs-dpc-2015)
   * phpDay 2015
     * ["Introduction to Event Sourcing and CQRS with Broadway" slides](https://beau.io/talks/2015/05/15/introduction-to-event-sourcing-and-cqrs-with-broadway-phpday-2015)

## Tutorial Setup

To be able to do the exercises in this tutorial, you need to have the following things set-up on your machine:

1. Composer
2. PHP 7.0 (or later)

It is expected that you know how to edit PHP files, and run them on the command line. All exercises will revolve around writing command line scripts.

If you have questions related to any of the installation instructions below, please email me at beau@dflydev.com, or find me (simensen) on IRC's Freenode network.

### Composer

Make sure you can call Composer through either just `composer`, or by calling `php /path/to/composer.phar`. I would recommend that you follow the instructions at https://getcomposer.org/download/ by running the 4 PHP commands, and then copy the installed `composer.phar` file to `/usr/local/bin/composer`:

    sudo cp composer.phar /usr/local/bin/composer

Now verify whether Composer works by running:

    composer --version

### PHP 7.0

Please install the PHP package through your package manager. For Debian and Ubuntu, this package is named `php`.

To verify whether your installation worked, run the following commands:

    php --version

Running this command should output something like this (pay attention to the version numbers):

    PHP 7.0.13-dev (cli) (built: Oct 30 2016 14:53:59) ( NTS DEBUG )
    Copyright (c) 1997-2016 The PHP Group
    Zend Engine v3.0.0, Copyright (c) 1998-2016 Zend Technologies
            with Xdebug v2.6.0-dev, Copyright (c) 2002-2017, by Derick Rethans
            with Zend OPcache v7.0.13-dev, Copyright (c) 1999-2016, by Zend Technologies
