<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application;

/**
 * Asset utility functions.
 */
class Asset
{
    /**
     * Tries to symlink assets to public directory or copy them on windows.
     *
     * @return void
     */
    public static function install()
    {
        $cssDst = 'public/vendor/css/';
        $jsDst = 'public/vendor/js/';
        $fontDst = 'public/vendor/webfonts/';
        $mappings = [
            ['vendor/components/jquery', $jsDst],
            ['vendor/components/font-awesome/css', $cssDst],
            ['vendor/components/font-awesome/webfonts', $fontDst],
            ['vendor/twbs/bootstrap/dist/css', $cssDst],
            ['vendor/twbs/bootstrap/dist/js', $jsDst],
        ];

        if (!is_dir($cssDst)) {
            mkdir($cssDst, 0744, true);
            mkdir($jsDst, 0744, true);
            mkdir($fontDst, 0744, true);
        }

        foreach ($mappings as $mapping) {
            foreach (new \DirectoryIterator(realpath($mapping[0])) as $file) {
                if ($file->isDot()) {
                    continue;
                }

                $dstPath = realpath($mapping[1]).'/'.$file->getFilename();

                if ('WIN' === strtoupper(substr(PHP_OS, 0, 3))) {
                    copy($file->getPathname(), $dstPath);
                } elseif (!is_file($dstPath)) {
                    symlink($file->getPathname(), $dstPath);
                }
            }
        }
    }
}
