<?php

namespace Kuborgh\GitHook;

use Composer\Installer\PackageEvent;

/**
 * Installation routine for composer
 */
class ComposerInstaller
{
    public static function postPackageInstall(PackageEvent $event)
    {
        $installedPackage = $event->getOperation()->getPackage();
        // @todo
        // do stuff
    }
}
