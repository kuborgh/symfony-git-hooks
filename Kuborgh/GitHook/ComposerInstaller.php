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
        if (! $operation instanceof InstallOperation) {
            return;
        }
        $installedPackage = $operation->getPackage();
        if (!preg_match('/^kuborgh\/symfony-git-hooks/', $installedPackage)) {
            return;
        }
        echo ("Installed git hooks \n");
        // @todo
        // do stuff
    }
}
