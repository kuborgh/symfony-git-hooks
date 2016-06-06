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
        $srcDir = realpath(__DIR__.'/../../hooks');
        $gitDir = self::getGitBaseDir();
        $dstDir = $gitDir.'/.git/hooks/';
        foreach(glob($srcDir.'/*') as $srcHook) {
            $dstHook = $dstDir.basename($srcHook);
            copy($srcHook, $dstHook);
            chmod($dstHook, 'a+x');
            echo $srcHook .' => '.$dstHook."\n";
        }
    }
}
