#!/usr/bin/php
<?php
/*
 * This will perform some symfony code checks before commiting.
 *
 * You can skip these tests with "git commit -n"
 */

require __DIR__ . '/../../../autoload.php';

// Check only staged files to be commited.
exec(sprintf('git diff-index --cached --name-only HEAD'), $files);

$numErrors = 0;

$linter = new \Kuborgh\GitHook\PhpLint();
$numErrors+=$linter->lint($files);

if ($numErrors) {
    printf('%d errors, not commiting',$numErrors);
    exit(1);
}
exit(0);
