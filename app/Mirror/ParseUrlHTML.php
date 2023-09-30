<?php

namespace App\Mirror;

use Exception;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use MGGFLOW\ExceptionManager\Interfaces\UniException;
use MGGFLOW\ExceptionManager\ManageException;

class ParseUrlHTML
{
    private array $chromeArguments = [
        '--ignore-certificate-errors',
        '--ignore-ssl-errors',
    ];

    private string $driverServerUri;
    private int $waitTime;

    private bool $preWait;
    private string $pageUrl;
    private RemoteWebDriver $driver;
    private ?string $html = '';

    public function __construct($serverUri, $waitTime = 11, $extraArguments = [], $preWait = false)
    {
        $this->driverServerUri = $serverUri;
        $this->waitTime = $waitTime;
        $this->preWait = $preWait;

        $this->chromeArguments = array_merge($this->chromeArguments, $extraArguments);
    }

    /**
     * @throws UniException
     */
    public function parse(string $url): ?string
    {
        $this->pageUrl = $url;

        try {
            $this->setUpDriver();
            $this->loadPage();
            $this->parseHtml();
            $this->shutDownDriver();
        } catch (Exception $e) {
            $this->shutDownDriver();
            throw ManageException::build()->e()->import($e);
        }

        return $this->html;
    }

    private function setUpDriver(): void
    {
        $desiredCapabilities = DesiredCapabilities::chrome();
        $chromeOptions = new ChromeOptions();
        $chromeOptions->addArguments($this->chromeArguments);
        $chromeOptions->setExperimentalOption(
            'excludeSwitches',
            ["enable-logging"]
        );
        $desiredCapabilities->setCapability(ChromeOptions::CAPABILITY, $chromeOptions);

        $this->driver = RemoteWebDriver::create($this->driverServerUri, $desiredCapabilities);
        $this->driver->manage()->timeouts()->implicitlyWait($this->waitTime);
    }

    private function loadPage(): void
    {
        $this->driver->get($this->pageUrl);
        if ($this->preWait) {
            try {
                $this->driver->wait($this->waitTime, $this->waitTime)->until(function () {
                    return false;
                });
            } catch (Exception $_e) {
            }
        }
        try {
            $this->driver->wait($this->waitTime, 1000)->until(
                function () {
                    return ($this->driver->executeScript("return document.readyState;") == "complete");
                }, 'Page not loaded?'
            );
        } catch (Exception $_e) {
            sleep((int)($this->waitTime / 3));
        }
    }

    private function parseHtml(): void
    {
        $this->html = $this->driver->executeScript('return document.documentElement.outerHTML;');
    }

    private function shutDownDriver(): void
    {
        if (!empty($this->driver)) $this->driver->quit();
    }
}

