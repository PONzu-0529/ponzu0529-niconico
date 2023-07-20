<?php

namespace App\Services;

use Exception;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Exception\WebDriverException;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\DriverCommand;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;

class CustomRemoteWebDriver extends RemoteWebDriver
{
    /**
     * Override Method
     * Find the first WebDriverElement using the given mechanism.
     *
     * @param WebDriverBy $by
     * @return RemoteWebElement NoSuchElementException is thrown in
     *    HttpCommandExecutor if no element is found.
     * @see WebDriverBy
     */
    public function findElement(WebDriverBy $by)
    {
        $params = ['using' => $by->getMechanism(), 'value' => $by->getValue()];
        $raw_element = $this->execute(
            DriverCommand::FIND_ELEMENT,
            $params
        );

        // return $this->newElement($raw_element['ELEMENT']);
        return $this->newElement(current($raw_element));
    }

    /**
     * Find all WebDriverElements within the current page using the given
     * mechanism.
     *
     * @param WebDriverBy $by
     * @return RemoteWebElement[] A list of all WebDriverElements, or an empty
     *    array if nothing matches
     * @see WebDriverBy
     */
    public function findElements(WebDriverBy $by)
    {
        $params = ['using' => $by->getMechanism(), 'value' => $by->getValue()];
        $raw_elements = $this->execute(
            DriverCommand::FIND_ELEMENTS,
            $params
        );

        $elements = [];
        foreach ($raw_elements as $raw_element) {
            // $elements[] = $this->newElement($raw_element['ELEMENT']);
            $elements[] = $this->newElement(current($raw_element));
        }

        return $elements;
    }
}

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
     * @var CustomRemoteWebDriver
     */
    protected CustomRemoteWebDriver $driver;

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
     * Get WebElement by CSS Selector
     *
     * @param string $cssSelector CSS Selector
     * @return RemoteWebElement WebElement
     */
    public function getWebElementByCssSelector(string $cssSelector): RemoteWebElement
    {
        $this->checkDriverDisposed();

        try {
            return $this->driver->findElement(
                WebDriverBy::cssSelector($cssSelector)
            );
        } catch (WebDriverException $ex) {
            $this->handleError($ex);

            return null;
        }
    }

    /**
     * ClickButton
     *
     * @param RemoteWebElement $button Button
     * @return void
     */
    public function clickButton(RemoteWebElement $button): void
    {
        $this->checkDriverDisposed();

        try {
            $button->click();
        } catch (WebDriverException $ex) {
            $this->handleError($ex);
        }
    }

    /**
     * Input Text
     *
     * @param string $selector Selector
     * @param string $text Text
     * @return void
     */
    public function typeInInput(RemoteWebElement $input, string $text): void
    {
        $this->checkDriverDisposed();

        try {
            $input->clear();
            $input->sendKeys($text);
        } catch (WebDriverException $ex) {
            $this->handleError($ex);
        }
    }

    /**
     * Wait for Element
     *
     * @param RemoteWebElement $element RemoteWebElement
     * @param integer $timeout Timeout
     * @return void
     */
    public function waitForElement(RemoteWebElement $element, int $timeout = 10)
    {
        $this->checkDriverDisposed();

        try {
            $wait = new WebDriverWait($this->driver, $timeout);

            $wait->until(
                WebDriverExpectedCondition::visibilityOf($element)
            );
        } catch (WebDriverException $ex) {
            $this->handleError($ex);
        }
    }


    /**
     * Wait for Element By CSS Selector
     *
     * @param string $cssSelector CSS Selector
     * @param integer $timeout Timeout
     * @return void
     */
    public function waitForElementByCssSelector(string $cssSelector, int $timeout = 10)
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
                    $this->driver = CustomRemoteWebDriver::create($host, $capabilities);
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
