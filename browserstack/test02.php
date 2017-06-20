<?php require_once('vendor/autoload.php');

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

/**
 * url: https://mortgageadvisor.com/home-loans-mortgage-loan
 * url: https://mortgageadvisor.com/refinance-mortgage
 * url: https://mortgageadvisor.com/home-equity-loan
 * url: https://mortgageadvisor.com/va-loan
 * url: https://mortgageadvisor.com/fha-loan
 * url: https://mortgageadvisor.com/reverse-mortgage
 */

$url = 'https://mortgageadvisor.com/home-loans-mortgage-loan';

$caps = array(
    "browser" => "Chrome",
    "os" => "Windows",
    "os_version" => "10",
    "resolution" => "1024x768",
    "build"=>"First build"
);

$username = "";
$accessKey = "";

$driver = RemoteWebDriver::create("https://$username:$accessKey@hub-cloud.browserstack.com/wd/hub", $caps);

//$host = 'http://localhost:4444/wd/hub'; // this is the default
//$capabilities = DesiredCapabilities::chrome();
//$driver = RemoteWebDriver::create($host, $capabilities, 5000);

$driver->get("https://mortgageadvisor.com/");

$elements = $driver->findElements(WebDriverBy::partialLinkText("Check Eligibility"));

$element = null;

for ($i=0; $i<sizeof($elements); $i++) {
    $currentElement = $elements[$i];

    $currentURL = $currentElement->getAttribute('href');
    //echo('currentURL: ' . $currentURL . PHP_EOL);

    if ($currentURL === $url) {
        $element = $currentElement;
        break;
    }
}

if (!empty($element)) {
    $element->click();

    if ($url === 'https://mortgageadvisor.com/home-loans-mortgage-loan') {
        $city = $driver->findElement(WebDriverBy::name('ll_city'));
        $city ->sendKeys('Clearwater');

        $state = $driver->findElement(WebDriverBy::cssSelector("select[name='ll_state'] option[value='FL']"));
        $state->click();

        $checkEligibility = $driver->findElement(WebDriverBy::cssSelector("section#loan-form form button"));
        $checkEligibility->click();

        //

        $notFound = true;

        $currentAttempt = 1;
        $maxAttempts = 10;

        $formContainer = null;

        while ($notFound) {
            if ($currentAttempt > $maxAttempts) {
                break;
            }

            echo "Attempt $currentAttempt of $maxAttempts" . PHP_EOL;

            try {
                $formContainer = $driver->findElement(
                    WebDriverBy::cssSelector('div.formio-form')
                );
            } catch (Exception $e) {
                echo $e->getMessage() . PHP_EOL;
            }

            if (!empty($formContainer)) {
                $notFound = false;
            } else {
                $currentAttempt++;
            }

            sleep(1);
        }

        $city = $driver->findElement(WebDriverBy::name('data[zip]'));
        $city ->sendKeys('33761');

        $nextPage1 = $driver->findElement(WebDriverBy::cssSelector('button.next'));
        $nextPage1->click();

        // Page 2

        $formControl = $driver->findElement(WebDriverBy::cssSelector("div.form-control"));
        $formControl->click();

        $elements = $driver->findElements(
            WebDriverBy::cssSelector(
                "div.choices__item.choices__item--choice.choices__item--selectable"
            )
        );

        $currentElement = $elements[0];
        $currentElement->click();

        $nextPage2 = $driver->findElement(WebDriverBy::cssSelector('button.next'));
        $nextPage2->click();

        // Page 3

        $formControl = $driver->findElement(WebDriverBy::cssSelector("div.form-control"));
        $formControl->click();

        $elements = $driver->findElements(
            WebDriverBy::cssSelector(
                "div.choices__item.choices__item--choice.choices__item--selectable"
            )
        );

        $currentElement = $elements[0];
        $currentElement->click();

        $nextPage3 = $driver->findElement(WebDriverBy::cssSelector('button.next'));
        $nextPage3->click();

        // Page 4

        $formControl = $driver->findElement(WebDriverBy::cssSelector("div.form-control"));
        $formControl->click();

        $elements = $driver->findElements(
            WebDriverBy::cssSelector(
                "div.choices__item.choices__item--choice.choices__item--selectable"
            )
        );

        $currentElement = $elements[0];
        $currentElement->click();

        $nextPage4 = $driver->findElement(WebDriverBy::cssSelector('button.next'));
        $nextPage4->click();
    }
}

$driver->quit();
