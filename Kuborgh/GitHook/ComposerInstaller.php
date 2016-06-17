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
     *
     * @param PackageEvent $event
     */
    public static function installHooks(PackageEvent $event)
    {
        // Check if hooks package was changed/added
        $operation = $event->getOperation();
        if ($operation instanceof InstallOperation) {
            $installedPackage = $operation->getPackage();
        } elseif ($operation instanceof UpdateOperation) {
            $installedPackage = $operation->getTargetPackage();
        } else {
            # return;
        }
        if (!preg_match('/^kuborgh\/symfony-git-hooks/', $installedPackage)) {
            # return;
        }

        echo("Install git hooks \n");
        $srcDir = realpath(__DIR__.'/../../hooks');
        $gitDir = self::getGitBaseDir();
        $dstDir = $gitDir.'/.git/hooks/';
        foreach (glob($srcDir.'/*') as $srcHook) {
            $dstHook = $dstDir.preg_replace('/\.php$/', '', basename($srcHook));
            copy($srcHook, $dstHook);
            chmod($dstHook, 0755);
            echo $srcHook.' => '.$dstHook."\n";
        }

        // Install coding standard
        echo "Installing coding standard \n";
        $installedPath = realpath(__DIR__.'/../../../../escapestudios/symfony2-coding-standard');
        exec('bin/phpcs --config-set installed_paths '.escapeshellarg($installedPath), $output, $return);
        if ($return != 0) {
            printf("Error: %s\n", implode("\n", $output));
        }
    }
}
