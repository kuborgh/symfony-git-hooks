<?php

namespace Kuborgh\GitHook;

/**
 * Run phplint on files, before committing
 */
class PhpLintHook extends AbstractHook
{
    /**
     * @param $filenames
     *
     * @return int
     */
    public function lint($filenames)
    {
        $gitBaseDir = $this->getGitBaseDir();
        $numErr = 0;
        $files = $this->getPhpFiles($filenames);
        foreach ($files as $filename) {
            $lintOutput = array();
            exec('php -l '.escapeshellarg($gitBaseDir.'/'.$filename), $lintOutput, $return);
            if ($return != 0) {
                printf("PHP Lint error: %s\n", implode("\n", $lintOutput));
                $numErr++;
            }
        }
        printf("PHP Lint checked %d files\n", count($files));

        return $numErr;
    }
}
