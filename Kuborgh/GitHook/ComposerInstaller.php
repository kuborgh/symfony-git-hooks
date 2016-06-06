<?php

namespace Kuborgh\GitHook;

use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\DependencyResolver\Operation\UpdateOperation;
use Composer\Installer\PackageEvent;

/**
 * Installation routine for composer
 */
class ComposerInstaller extends AbstractHook
{
    /**
     * Install hooks after package was installed or updated
     * @param PackageEvent $event
     */
    public static function installHooks(PackageEvent $event)
    {
        // Check if hooks package was changed/added
        $operation = $event->getOperation();
        if ($operation instanceof InstallOperation) {
            $installedPackage = $operation->getPackage();
        } elseif($operation instanceof UpdateOperation) {
            $installedPackage = $operation->getTargetPackage();
        } else {
            return;
        }
        if (!preg_match('/^kuborgh\/symfony-git-hooks/', $installedPackage)) {
            return;
        }
        
        echo ("Install git hooks \n");
        $gitDir = self::getGitBaseDir();
        $dst = $gitDir.'/hooks/';
        $src = realpath(__DIR__.'/../../hooks');
        echo $src .' => '.$dst."\n";
        // @todo
        // do stuff
    }
}
