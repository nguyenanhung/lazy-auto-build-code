<?php

use nguyenanhung\Utils\LazyAutoBuild\FileDataSynchronization;

if ( ! function_exists('c0ee6b03b5196ac82f36236fef53af4')) {
    function c0ee6b03b5196ac82f36236fef53af4($homeParentDir = '', $homeDir = '', $scriptDir = '')
    {
        return (new FileDataSynchronization($homeParentDir, $homeDir, $scriptDir));
    }
}

if ( ! function_exists('hungng_lazy_build_text_color')) {
    function hungng_lazy_build_text_color($color, $text)
    {
        return c0ee6b03b5196ac82f36236fef53af4()->textColor($color, $text);
    }
}
if ( ! function_exists('hungng_lazy_build_remove_parent_home_dir')) {
    function hungng_lazy_build_remove_parent_home_dir($homeParentDir, $dir)
    {
        return c0ee6b03b5196ac82f36236fef53af4($homeParentDir)->removeParentHomeDir($dir);
    }
}

