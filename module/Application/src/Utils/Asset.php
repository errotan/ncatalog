<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Utils;

/**
 * Asset utility functions.
 */
final class Asset
{
    const CSSDIR = 'public/vendor/css/';
    const JSDIR = 'public/vendor/js/';
    const FONTDIR = 'public/vendor/webfonts/';

    /**
     * @var array
     */
    protected $mappings = [
        ['vendor/components/jquery', Asset::JSDIR],
        ['vendor/components/font-awesome/css', Asset::CSSDIR],
        ['vendor/components/font-awesome/webfonts', Asset::FONTDIR],
        ['vendor/twbs/bootstrap/dist/css', Asset::CSSDIR],
        ['vendor/twbs/bootstrap/dist/js', Asset::JSDIR],
    ];

    /**
     * Tries to symlink assets to public directory or copy them on windows.
     *
     * @return void
     */
    public static function install()
    {
        (new Asset())->doInstall();
    }

    /**
     * Actually tries to symlink assets to public directory or copy them on windows.
     *
     * @return void
     */
    public function doInstall()
    {
        $this->createDirs();
        $this->makeAssetPublic();
    }

    /**
     * @return void
     */
    protected function createDirs()
    {
        if (!is_dir(Asset::CSSDIR)) {
            mkdir(Asset::CSSDIR, 0744, true);
            mkdir(Asset::JSDIR, 0744, true);
            mkdir(Asset::FONTDIR, 0744, true);
        }
    }

    /**
     * @return void
     */
    protected function makeAssetPublic()
    {
        foreach ($this->mappings as $mapping) {
            foreach (new \DirectoryIterator(realpath($mapping[0])) as $file) {
                if ($file->isDot()) {
                    continue;
                }

                $this->symlinkOrCopy($file->getPathname(), realpath($mapping[1]).'/'.$file->getFilename());
            }
        }
    }

    /**
     * @param string $src source path
     * @param string $dst destination path
     *
     * @return void
     */
    protected function symlinkOrCopy($src, $dst)
    {
        if ('WIN' === strtoupper(substr(PHP_OS, 0, 3))) {
            copy($src, $dst);
        } elseif (!is_file($dst)) {
            symlink($src, $dst);
        }
    }
}
