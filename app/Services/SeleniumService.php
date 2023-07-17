<?php

namespace App\Services;

use Exception;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Exception\WebDriverException;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;

/**
 * Selenium Service
 */
class SeleniumService
{
    /**
     * Number of Attempts
     *
     * @var integer
     */
    private int $ATTEMPT_COUNT = 10;

    /**
     * Wait Time
     *
     * @var integer
     */
    private int $WAIT_TIME = 5;

    /**
     * Driver
     *
     * @var RemoteWebDriver
     */
    private RemoteWebDriver $driver;

    /**
     * Driver Disposed Flag
     *
     * @var boolean
     */
    private bool $is_driver_disposed;

    /**
     * Constructor
     *
     * @param string $host Server Host
     */
    public function __construct(string $host)
    {
        $this->is_driver_disposed = false;

        $this->setupDriver($host);
    }

    /**
     * Open Page
     *
     * @param string $url URL
     * @return void
     */
    public function openPage(string $url): void
    {
        $this->checkDriverDisposed();

        try {
            $this->driver->get($url);
        } catch (WebDriverException $ex) {
            $this->handleError($ex);
        }
    }

    /**
     * Click Button
     *
     * @param string $cssSelector CSS Selector
     * @return void
     */
    public function clickButton(string $cssSelector): void
    {
        $this->checkDriverDisposed();

        try {
            $button = $this->driver->findElement(
                WebDriverBy::cssSelector($cssSelector)
            );

            $button->click();
        } catch (WebDriverException $ex) {
            $this->handleError($ex);
        }
    }

    /**
     * Wait for Element
     *
     * @param string $cssSelector CSS Selector
     * @param integer $timeout Timeout
     * @return void
     */
    public function waitForElement(string $cssSelector, int $timeout = 10)
    {
        $this->checkDriverDisposed();

        try {
            $wait = new WebDriverWait($this->driver, $timeout);

            $wait->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(
                    WebDriverBy::cssSelector($cssSelector)
                )
            );
        } catch (WebDriverException $ex) {
            $this->handleError($ex);
        }
    }

    /**
     * Save ScreenShot
     *
     * @param string $filename FileName
     * @return void
     */
    public function saveScreenshot(string $filename)
    {
        $this->checkDriverDisposed();
        try {
            $screenshot = $this->driver->takeScreenshot($filename);
        } catch (WebDriverException $ex) {
            $this->handleError($ex);
        }
    }

    /**
     * Quit Driver
     *
     * @return void
     */
    public function quit(): void
    {
        if (!$this->is_driver_disposed) {
            $this->is_driver_disposed = true;

            $this->driver->quit();
        }
    }

    /**
     * Setup Driver
     *
     * @param string $host Server Host
     * @return void
     */
    private function setupDriver(string $host): void
    {
        $options = new ChromeOptions();
        $options->addArguments([
            '--headless',
            '--mute-audio',
            '--no-sandbox',
            '--disable-gpu'
        ]);
        $options->setExperimentalOption('excludeSwitches', ['enable-logging']);

        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        try {
            $attempts = 0;

            while ($attempts < $this->ATTEMPT_COUNT) {
                try {
                    $this->driver = RemoteWebDriver::create($host, $capabilities);
                    return;
                } catch (Exception $ex) {
                }

                sleep($this->WAIT_TIME);
                $attempts++;
            }
        } catch (Exception $ex) {
            throw new Exception('Failed to Connect.');
        }
    }

    /**
     * Check Driver Disposed
     *
     * @return void
     */
    private function checkDriverDisposed(): void
    {
        if ($this->is_driver_disposed) {
            throw new WebDriverException('The driver has already been disposed.');
        }
    }

    /**
     * Handle Error
     *
     * @param WebDriverException $ex Exception
     * @return void
     */
    private function handleError(WebDriverException $ex): void
    {
        $this->driver->quit();

        throw $ex;
    }
}
