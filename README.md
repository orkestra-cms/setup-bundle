Installation
============

Prerequisites
-------------

Make sure you [install Node.js](https://nodejs.org/en/download/) and also the [Yarn package manager](https://yarnpkg.com/lang/en/docs/install/).

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require --dev orkestra/setup-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php
// ...

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        // ...
        if (in_array($this->getEnvironment(), array('dev'), true)) {
            // ...
            $bundles[] = new Orkestra\Bundles\SetupBundle\OrkestraSetupBundle();
        }

        return $bundles;
    }

    // ...
}
```

Available commands
------------------

## Nanobox

```bash
$ php bin/console setup:nanobox
```

Creates a [Nanobox](https://nanobox.io) environment for your project. Make sure to add
a Nanobox DNS entry as well as an evar `SYMFONY_ENV`. Also, enable the bundle 
`Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle` in your `app/AppKernel.php`.

Adjust your `parameters.yml` file to contain the following values:

```yaml
database_host: '%env(DATA_DB_HOST)%'
database_port: null
database_name: gonano
database_user: '%env(DATA_DB_USER)%'
database_password: '%env(DATA_DB_PASS)%'
```

## CKEditor

```bash
$ php bin/console setup:ckeditor
```

Installs the CKEditor bundle and a default toolbar configuration. This will also 
adjust the `boxfile.yml` to ensure the CKEditor assets get installed on deployment.

Make sure to import `merges/ckeditor.yml` in `app/config/config.yml` and enable the 
bundle `Ivory\CKEditorBundle\IvoryCKEditorBundle` in your `app/AppKernel.php`.

After that install the CKEditor assets for your development environment:

```bash
$ php bin/console ckeditor:install web/bundles/ivoryckeditor
```

## MailHog

```bash
$ php bin/console setup:mailhog
```

Installs [MailHog](https://github.com/mailhog/MailHog) with required configuration 
files and adds a reverse proxy on your Nanobox environment so MailHog is accessible at 
the URL `/mailbox` (except for production).

Make sure to remove the default `swiftmailer` options from `config.yml` and 
`config_test.yml` and import `merges/mailhog.yml` for every environment you wish. 
Import `merges/mail_prod.yml` into your `config_prod.yml`. Also add the two Nanobox 
evars `MAIL_USER` and `MAIL_PASS` so online environments require authentication to access 
the mailbox.

## Memcached

Configures Symfony to use [memcached](https://memcached.org) for session handling and 
Doctrine caching.

Make sure to import `merges/memcached.yml` for every environment you wish to use it.

```bash
$ php bin/console setup:memcached
```

## Namespaced sessions

```bash
$ php bin/console setup:session
```

Configures Symfony to use Namespaced sessions.

Make sure to import `merges/session.yml` for every environment you wish to use it.

## Webpack/Encore

```bash
$ php bin/console setup:webpack --bootstrap 3 # Includes Bootstrap v3
$ php bin/console setup:webpack --bootstrap 4 # Includes Bootstrap v4
```

Installs Webpack/Encore and a default Webpack configuration. This also includes
a default set of stylesheets/scripts for [Bootstrap](https://getbootstrap.com) 
and [Font-Awesome](http://fontawesome.io). 

Make sure to import `merges/webpack.yml` in `app/config/config.yml` and remove
the default `framework.assets` configuration.

During development you may run `node_modules/.bin/encore dev --watch` to have
real-time compilation of your assets.