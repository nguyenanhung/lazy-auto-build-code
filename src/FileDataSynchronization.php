<?php
/**
 * Project lazy-auto-build-code
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 6/7/24
 * Time: 13:42
 */

namespace nguyenanhung\Utils\LazyAutoBuild;

class FileDataSynchronization
{
    const VERSION = '1.0.0';
    const POWERED_BY = 'Powered by Hung Nguyen - hungna.dev@gmail.com';
    const COLOR_NC = "\033[0m";
    const COLOR_GREEN = "\033[0;32m";
    const COLOR_YELLOW = "\033[0;33m";
    const COLOR_CYAN = "\033[0;36m";

    protected $homeParentDir;
    protected $homeDir;
    protected $scriptDir;

    public function __construct($homeParentDir = '/home', $homeDir = '', $scriptDir = '')
    {
        $this->homeParentDir = $homeParentDir;
        $this->homeDir = $homeDir;
        $this->scriptDir = $scriptDir;
    }

    public function textColor($color, $text)
    {
        return $color . $text . "\033[0m";
    }

    public function echoBreakLine()
    {
        echo "===================================================\n";
    }

    public function echoAuthor()
    {
        echo "\n";
        echo "  _    _                           _   _    _____ \n";
        echo " | |  | |                         | \\ | |  / ____|\n";
        echo " | |__| |  _   _   _ __     __ _  |  \\| | | |  __ \n";
        echo " |  __  | | | | | | '_ \\   / _` | | . ` | | | |_ |\n";
        echo " | |  | | | |_| | | | | | | (_| | | |\\  | | |__| |\n";
        echo " |_|  |_|  \\__,_| |_| |_|  \\__, | |_| \\_|  \\_____|\n";
        echo "                            __/ |                 \n";
        echo "                           |___/                  \n";
        echo "\n";
    }

    public function echoFinishedMessage()
    {
        echo "\n";
        $this->echoBreakLine();
        echo "Finished script\n";
        $this->echoBreakLine();
    }

    public function echoHeaderScript($projectName = '', $scriptName = '', $scriptLocation = '')
    {
        $this->echoBreakLine();
        $this->echoAuthor();
        echo $this->textColor(self::COLOR_YELLOW, self::POWERED_BY . "\n");
        echo "\n";
        echo $this->textColor(self::COLOR_YELLOW, "Lazy Auto Build Code - version " . self::VERSION . "\n");
        echo "\n";
        echo $this->textColor(self::COLOR_YELLOW, $projectName . "\n");
        echo "\n";
        echo $this->textColor(self::COLOR_YELLOW, $scriptName . "\n");
        echo $this->textColor(self::COLOR_GREEN, "Run: " . $scriptLocation . ".\n");
        echo "\n";
        $this->echoBreakLine();
    }

    public function echoPathToRun()
    {
        echo "HOME_PARENT_DIR: " . $this->textColor(self::COLOR_CYAN, $this->homeParentDir) . "\n";
        echo "HOME_DIR: " . $this->textColor(self::COLOR_CYAN, $this->homeDir) . "\n";
        echo "SCRIPT_DIR: " . $this->textColor(self::COLOR_CYAN, $this->scriptDir) . "\n";
    }

    public function echoFunctionSync($name = '', $sourceName = '', $sourceDir = '', $targetName = '', $targetDir = '')
    {
        echo PHP_EOL;
        echo $this->textColor(self::COLOR_YELLOW, "Script " . $name . "\n");
        echo $sourceName . ": " . $this->textColor(self::COLOR_CYAN, $sourceDir) . "\n";
        echo $targetName . ": " . $this->textColor(self::COLOR_CYAN, $targetDir) . "\n";
    }

    public function removeParentHomeDir($dir)
    {
        return str_replace($this->homeParentDir, '', $dir);
    }

    public function copyFiles($sourceFile, $destinationFile)
    {
        if ( ! file_exists($sourceFile)) {
            echo "Source file does not exist: " . $this->textColor(self::COLOR_YELLOW, $sourceFile) . "\n";
            return false;
        }

        if ( ! is_dir(dirname($destinationFile))) {
            echo "Destination directory does not exist: " . $this->textColor(
                    self::COLOR_YELLOW,
                    dirname($destinationFile)
                ) . "\n";
            return false;
        }

        if (copy($sourceFile, $destinationFile)) {
            echo "Successfully copied " . $this->textColor(
                    self::COLOR_GREEN,
                    $this->removeParentHomeDir($sourceFile)
                ) . "\n                 to " . $this->textColor(
                    self::COLOR_CYAN,
                    $this->removeParentHomeDir($destinationFile)
                ) . "\n";
            return true;
        } else {
            echo "Failed to copy " . $this->textColor(
                    self::COLOR_YELLOW,
                    $this->removeParentHomeDir($sourceFile)
                ) . "\n            to " . $this->textColor(
                    self::COLOR_YELLOW,
                    $this->removeParentHomeDir($destinationFile)
                ) . "\n";
            return false;
        }
    }

    public function copyDirectory($source, $destination)
    {
        if ( ! is_dir($source)) {
            echo "Source directory does not exist: " . $this->textColor(self::COLOR_YELLOW, $source) . "\n";
            return false;
        }

        if ( ! is_dir($destination)) {
            if ( ! mkdir($destination, 0755, true)) {
                echo "Failed to create destination directory: " . $this->textColor(
                        self::COLOR_YELLOW,
                        $destination
                    ) . "\n";
                return false;
            }
        }

        $dir = opendir($source);
        if ($dir === false) {
            echo "Failed to open source directory: " . $this->textColor(self::COLOR_YELLOW, $source) . "\n";
            return false;
        }

        while (($file = readdir($dir)) !== false) {
            if ($file != '.' && $file != '..') {
                $srcFile = rtrim($source, '\\/') . DIRECTORY_SEPARATOR . $file;
                $destFile = rtrim($destination, '\\/') . DIRECTORY_SEPARATOR . $file;
                if (is_dir($srcFile)) {
                    $this->copyDirectory($srcFile, $destFile);
                } else {
                    if (copy($srcFile, $destFile)) {
                        echo "Successfully copied " . $this->textColor(
                                self::COLOR_GREEN,
                                $this->removeParentHomeDir($srcFile)
                            ) . "\n                 to " . $this->textColor(
                                self::COLOR_CYAN,
                                $this->removeParentHomeDir($destFile)
                            ) . "\n";
                    } else {
                        echo "Failed to copy " . $this->textColor(
                                self::COLOR_YELLOW,
                                $this->removeParentHomeDir($srcFile)
                            ) . "\n            to " . $this->textColor(
                                self::COLOR_YELLOW,
                                $this->removeParentHomeDir($destFile)
                            ) . "\n";
                    }
                }
            }
        }
        closedir($dir);
        return true;
    }
}
