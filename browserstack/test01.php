<?php
require_once('vendor/autoload.php');
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

//$caps = array("browserName"=>"chrome", "browserstack.debug"=>"true", "build"=>"First build");
//$caps = array("platform"=>"WINDOWS", "browserName"=>"firefox"));
//$caps = array("browser" => "IE", "browser_version" => "8.0", "os" => "Windows", "os_version" => "7", "resolution" => "1024x768");
$caps = array("browser" => "IE", "browser_version" => "9.0", "os" => "Windows", "os_version" => "7", "resolution" => "1024x768", "build"=>"First build");

$username = "";
$accessKey = "";

$web_driver = RemoteWebDriver::create("https://$username:$accessKey@hub-cloud.browserstack.com/wd/hub", $caps);
$web_driver->get("http://google.com");
$element = $web_driver->findElement(WebDriverBy::name("q"));
if($element) {
    $element->sendKeys("Gabe is a code destroyer");
    $element->submit();
}
print $web_driver->getTitle();
$web_driver->quit();
?>
