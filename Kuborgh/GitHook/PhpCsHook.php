<?php

namespace Kuborgh\GitHook;

/**
 * Run phpcs on files, before committing
 */
class PhpCsHook extends AbstractHook
{
    /**
     * @param $filenames
     *
     * @return int
     */
    public function check($filenames)
    {
        $gitBaseDir = $this->getGitBaseDir();
        $numErr = 0;
        $files = $this->getPhpFiles($filenames);
        foreach ($files as $filename) {
            $lintOutput = array();
            exec('bin/phpcs -s -p --standard=Symfony2 '.escapeshellarg($gitBaseDir.'/'.$filename), $lintOutput, $return);
            if ($return != 0) {
                printf("PHP CS error: %s\n", implode("\n", $lintOutput));
                $numErr++;
            }
        }
        printf("PHP CS checked %d files\n", count($files));

        return $numErr;
    }
}
