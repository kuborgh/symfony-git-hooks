#!/usr/bin/php
<?php
/*
 * This will perform some symfony code checks before commiting.
 *
 * You can skip these tests with "git commit -n"
 */

require __DIR__.'/../../../autoload.php';

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
