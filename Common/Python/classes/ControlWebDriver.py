from xmlrpc.client import Boolean
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.remote.webdriver import WebDriver, WebElement


class ControlWebDriver():

    driver: WebDriver = None

    delete_flg = False


    def __init__(self, selenium_server_host: str, selenium_server_port = '4444'):
        """
        Constructor

        * selenium_server_host:
        * selenium_server_port: (default 4444)
        """

        options = Options()

        options.add_argument("--headless")
        options.add_argument('--mute-audio')
        options.add_argument('--no-sandbox')
        options.add_experimental_option('excludeSwitches', ['enable-logging'])

        self.driver = webdriver.Remote(
            command_executor = "http://%s:%s" % (selenium_server_host, selenium_server_port),
            options = options,
            keep_alive = True
        )


    def __del__(self):
        """
        Destructor
        """

        self.delete_driver()


    def access_the_url(self, url: str):
        """
        Loads a web page in the current browser session.
        * url: target url
        """

        self.driver.get(url)


    def find_element_by_id(self, id: str, elem: WebElement = None) -> WebElement:
        """
        Finds an element by id.
        * id: ID Name
        * elem: WebDriver's Element or WebElement(default None)
        """

        if (elem == None):

            return self.driver.find_element_by_id(id)

        else:

            return elem.find_element_by_id(id)


    def find_elements_by_tag_name(self, tag: str, elem: WebElement = None) -> list[WebElement]:
        """
        Finds a list of elements within this element's children by tag name.
        * tag: Tag Name
        * elem: WebDriver's Element or WebElement(default None)
        """

        if (elem == None):

            return self.driver.find_elements_by_tag_name(tag)

        else:

            return elem.find_elements_by_tag_name(tag)


    def delete_driver(self):
        """
        Quits the driver and closes every associated window.
        """

        if (not self.delete_flg):

            self.driver.quit()

            self.delete_flg = True
