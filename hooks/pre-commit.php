#!/usr/bin/php
<?php
/*
 * This will perform some symfony code checks before commiting.
 *
 * You can skip these tests with "git commit -n"
 */

$vendorFolder = getVendorFolder();
require $vendorFolder.'/autoload.php';

// Check only staged files to be commited.
exec(sprintf('git diff-index --cached --name-only HEAD'), $files);

$numErrors = 0;

// Lint
$linter = new \Kuborgh\GitHook\PhpLintHook();
$numErrors += $linter->lint($files);

// PHPCS
$phpcs = new \Kuborgh\GitHook\PhpCsHook();
$numErrors += $phpcs->check($files);
// @todo

// PHPMD
// @todo

if ($numErrors) {
    printf("%d error(s), not committing!\n", $numErrors);
    exit(1);
}
exit(0);

/**
 * @return string
 */
function getVendorFolder()
{
    $vendorFolder = realpath(__DIR__.'/../../');
    do {
        // Check for a symfony subfolder
        if (file_exists($vendorFolder.'/symfony/vendor')) {
            return $vendorFolder.'/symfony/vendor';
        }
        // Check for a vendor folder directly
        if (file_exists($vendorFolder.'/vendor')) {
            return $vendorFolder.'/vendor';
        }
        // Go one level more up
        $vendorFolder = realpath($vendorFolder.'/../');
    } while ($vendorFolder != '/');

    echo "Vendor folder not found!\n";
    exit(1);
}
