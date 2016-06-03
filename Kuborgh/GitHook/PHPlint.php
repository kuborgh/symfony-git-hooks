<?php

namespace Kuborgh\GitHook;

/**
 * Run phplint on files, before commiting
 */
class PhpLint
{
    public function lint($filenames)
    {
        $numErr = 0;
        foreach ($filenames as $filename) {
            $lintOutput = array();
            exec('php -l '.escapeshellarg($filename), $lintOutput, $return);
            if ($return != 0) {
                echo implode("\n", $lintOutput), "\n";
                $numErr++;
            }
        }

        return $numErr;
    }
}
