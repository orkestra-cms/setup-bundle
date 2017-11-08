<?php

namespace Orkestra\Bundles\SetupBundle\Command;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Intl\Exception\NotImplementedException;

class WebpackCommand extends SetupCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('webpack')
            ->setDescription('Installs Webpack/Encore and a default Webpack configuration.')
            ->addNodePackage('@symfony/webpack-encore')
            ->addNodePackage('jquery')
            ->addNodePackage('font-awesome')
            ->addNodePackage('node-sass')
            ->addNodePackage('sass-loader')
            ->markForCopy('.gitignore')
            ->markForCopy('.nanoignore')
            ->markForCopy('boxfile.yml')
            ->addOption('bootstrap', null, InputOption::VALUE_REQUIRED, 'The Bootstrap version to use');
    }

    protected function preExecute(InputInterface $input, OutputInterface $output)
    {
        $bootstrap = (int)$input->getOption('bootstrap');
        if (!in_array($bootstrap, [3, 4], true))
            throw new InvalidArgumentException('An invalid Bootstrap version was requested.');
        switch ($bootstrap) {
            case 3:
                $this
                    ->addNodePackage('bootstrap-sass', false, '^3.3.7')
                    ->markForCopy('app/config/merges/webpack.bootstrap3.yml', 'app/config/merges/webpack.yml')
                    ->markForCopy('webpack.bootstrap3.config.js', 'webpack.config.js')
                ;
                $files = [
                    'assets/bootstrap3/css/_fontawesome.scss',
                    'assets/bootstrap3/css/_bootstrap.scss',
                    'assets/bootstrap3/css/_variables.scss',
                    'assets/bootstrap3/css/app.scss',
                    'assets/bootstrap3/css/vendor.scss',
                    'assets/bootstrap3/js/app.js',
                    'assets/bootstrap3/js/vendor.js'
                ];
                break;
            case 4:
                throw new NotImplementedException('Bootstrap 4 support is still on the TODO-list.');
                $this
                    ->addNodePackage('bootstrap-sass', false, '^3.3.7')
                    ->markForCopy('app/config/merges/webpack.bootstrap4.yml', 'app/config/merges/webpack.yml')
                    ->markForCopy('webpack.bootstrap4.config.js', 'webpack.config.js')
                ;
                $files = [
                ];
                break;
        }
        foreach($files as $file) {
            $this->markForCopy($file,
                preg_replace('/^assets\/bootstrap\d\/(.*)$/', 'assets/$1', $file));
        }
    }
}
