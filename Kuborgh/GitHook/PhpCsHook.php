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
            $output = array();
            $cmd = sprintf('%s/phpcs -s -p --standard=Symfony2 %s', $this->getBinDir(), escapeshellarg($gitBaseDir.'/'.$filename));
            exec($cmd, $output, $return);
            if ($return != 0) {
                printf("PHP CS error: %s\n", implode("\n", $output));
                $numErr++;
            }
        }
        printf("PHP CS checked %d files\n", count($files));

        return $numErr;
    }
}
