<?php

namespace Kuborgh\GitHook;

use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\Installer\PackageEvent;

/**
 * Installation routine for composer
 */
class ComposerInstaller
{
    public static function postPackageInstall(PackageEvent $event)
    {
        $operation = $event->getOperation();
        if ($operation instanceof InstallOperation) {
            $installedPackage = $operation->getPackage();
        } else {
            $installedPackage = 'unknown';
        }
        echo ('Installed package '.$installedPackage);
        // @todo
        // do stuff
    }
}
