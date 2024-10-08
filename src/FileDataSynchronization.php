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
    const VERSION = '1.0.3';
    const PROJECT_NAME = 'Lazy Auto Build Code';
    const POWERED_BY = 'Powered by Hung Nguyen - hungna.dev@gmail.com';
    const COLOR_NC = "\033[0m";
    const COLOR_GREEN = "\033[0;32m";
    const COLOR_YELLOW = "\033[0;33m";
    const COLOR_CYAN = "\033[0;36m";
    const CLI_ONLY_MSG = "This script is only for CLI environment.\n";

    protected $isTest = false;
    protected $homeParentDir;
    protected $homeDir;
    protected $vendorDir;
    protected $scriptDir;
    protected $profileName;
    protected $profilePrefix;
    protected $scriptName;
    protected $scriptLocation;
    protected $folderSync;
    protected $vendorDataMigrationsDir;
    protected $vendorSyncDir;
    protected $vendorTemplatesDir;

    public function __construct(
        $vendorDir = '',
        $scriptDir = ''
    ) {
        $homeDir = dirname($vendorDir);
        $homeParentDir = dirname($homeDir);
        $this->homeParentDir = $homeParentDir;
        $this->homeDir = $homeDir;
        $this->vendorDir = $vendorDir;
        $this->scriptDir = $scriptDir;
    }

    public function setupProfile(
        $profileName = '',
        $profilePrefix = '',
        $scriptName = '',
        $scriptLocation = ''
    ) {
        $this->profileName = $profileName;
        $this->profilePrefix = $profilePrefix;
        $this->scriptName = $scriptName;
        $this->scriptLocation = $scriptLocation;
        return $this;
    }

    public function setupSyncDir(
        $folderSync = '',
        $vendorSyncDir = '',
        $vendorDataMigrationsDir = '',
        $vendorTemplatesDir = ''
    ) {
        $this->folderSync = $folderSync;
        $this->vendorSyncDir = $vendorSyncDir;
        $this->vendorDataMigrationsDir = $vendorDataMigrationsDir;
        $this->vendorTemplatesDir = $vendorTemplatesDir;
        return $this;
    }

    public function isCLI()
    {
        return php_sapi_name() === 'cli';
    }

    public function isTest()
    {
        $this->isTest = true;
        return $this;
    }

    public function textColor($color, $text)
    {
        if ( ! $this->isCLI()) {
            echo self::CLI_ONLY_MSG;
            return false;
        }
        return $color . $text . "\033[0m";
    }

    public function echoBreakLine()
    {
        if ( ! $this->isCLI()) {
            echo self::CLI_ONLY_MSG;
        } else {
            echo "===================================================\n";
        }
    }

    public function echoAuthor()
    {
        if ( ! $this->isCLI()) {
            echo self::CLI_ONLY_MSG;
        } else {
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
    }

    public function echoFinishedMessage($scriptName = '')
    {
        if ( ! $this->isCLI()) {
            echo self::CLI_ONLY_MSG;
        } else {
            echo "\n";
            $this->echoBreakLine();
            echo "Finished " . $scriptName . " at " . date('Y-m-d H:i:s') . "\n";
            echo self::POWERED_BY . PHP_EOL;
            $this->echoBreakLine();
        }
    }

    public function echoHeaderScript($profileName = '', $scriptName = '', $scriptLocation = '')
    {
        if ( ! $this->isCLI()) {
            echo self::CLI_ONLY_MSG;
        } else {
            $this->echoBreakLine();
            $this->echoAuthor();
            if (empty($profileName)) {
                $profileName = $this->profileName;
            }
            if (empty($scriptName)) {
                $scriptName = $this->scriptName;
            }
            if (empty($scriptLocation)) {
                $scriptLocation = $this->scriptLocation;
            }
            echo $this->textColor(self::COLOR_YELLOW, self::POWERED_BY . "\n");
            echo $this->textColor(self::COLOR_YELLOW, self::PROJECT_NAME . ' - version ' . self::VERSION . "\n");
            echo "\n";
            echo $this->textColor(self::COLOR_YELLOW, $profileName . "\n");
            echo "\n";
            echo $this->textColor(self::COLOR_YELLOW, $scriptName . "\n");
            echo $this->textColor(self::COLOR_GREEN, "Run: " . $scriptLocation . "\n");
            echo "\n";
            $this->echoBreakLine();
            $this->echoPathToRun();
        }
        return $this;
    }

    public function echoPathToRun()
    {
        if ( ! $this->isCLI()) {
            echo self::CLI_ONLY_MSG;
        } else {
            echo "HOME_PARENT_DIR: " . $this->textColor(self::COLOR_CYAN, $this->homeParentDir) . "\n";
            echo "HOME_DIR: " . $this->textColor(self::COLOR_CYAN, $this->homeDir) . "\n";
            echo "VENDOR_DIR: " . $this->textColor(self::COLOR_CYAN, $this->vendorDir) . "\n";
            echo "SCRIPT_DIR: " . $this->textColor(self::COLOR_CYAN, $this->scriptDir) . "\n";
        }
    }

    public function laravelFunctionName($name = '')
    {
        return trim($this->profileName) . ' -> Update ' . trim($name) . ' to Project Laravel Framework';
    }

    public function laravelEchoFunctionSync(
        $name = '',
        $sourceName = '',
        $sourceDir = '',
        $targetName = '',
        $targetDir = ''
    ) {
        $this->echoFunctionSync(
            $this->laravelFunctionName($name),
            $this->profilePrefix . $sourceName,
            $sourceDir,
            $targetName,
            $targetDir
        );
    }

    public function echoFunctionSync($name = '', $sourceName = '', $sourceDir = '', $targetName = '', $targetDir = '')
    {
        if ( ! $this->isCLI()) {
            echo "This script is only for CLI environment.\n";
        } else {
            echo PHP_EOL;
            echo $this->textColor(self::COLOR_YELLOW, "Script " . $name . "\n");
            if ( ! empty($sourceName) && ! empty($sourceDir)) {
                echo $sourceName . ": " . $this->textColor(self::COLOR_CYAN, $sourceDir) . "\n";
            }
            if ( ! empty($targetName) && ! empty($targetDir)) {
                echo $targetName . ": " . $this->textColor(self::COLOR_CYAN, $targetDir) . "\n";
            }
        }
    }

    public function removeParentHomeDir($dir)
    {
        if ( ! $this->isCLI()) {
            echo self::CLI_ONLY_MSG;
            return false;
        }

        return str_replace($this->homeParentDir, '', $dir);
    }

    public function copyFiles($sourceFile, $destinationFile)
    {
        if ( ! $this->isCLI()) {
            echo self::CLI_ONLY_MSG;
            return false;
        }

        if ($this->isTest === true) {
            echo "Script copied files version: " . self::VERSION . PHP_EOL;
        }

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
        if ( ! $this->isCLI()) {
            echo self::CLI_ONLY_MSG;
            return false;
        }

        if ($this->isTest === true) {
            echo "Script copied directory version: " . self::VERSION . PHP_EOL;
        }

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
