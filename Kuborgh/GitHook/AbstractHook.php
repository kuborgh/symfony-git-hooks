<?php

namespace Kuborgh\GitHook;

/**
 * Some abstraction to implement hooks
 */
abstract class AbstractHook
{
    /**
     * Filter only php files
     *
     * @param string[] $filenames
     *
     * @return string[]
     */
    protected function getPhpFiles($filenames)
    {
        $gitBaseDir = $this->getGitBaseDir();

        $phpFiles = array();
        foreach ($filenames as $filename) {
            // Skip non-php
            if (!fnmatch('*.php', $filename)) {
                continue;
            }

            // Skip nonexisting
            // Skip deleted files
            if (!file_exists($gitBaseDir.'/'.$filename)) {
                continue;
            }

            $phpFiles[] = $filename;
        }

        return $phpFiles;
    }

    /**
     * Get absolute directory path, to which the file paths are relative to
     *
     * @return string
     * @throws \Exception
     */
    protected function getGitBaseDir()
    {
        $gitBaseDir = realpath(__DIR__.'/../../../../../');
        while (!file_exists($gitBaseDir.'/.git')) {
            $gitBaseDir = realpath($gitBaseDir.'/../');
            if ($gitBaseDir == '/') {
                throw new \Exception('No git basedir found!');
            }
        }

        return $gitBaseDir;
    }
}
