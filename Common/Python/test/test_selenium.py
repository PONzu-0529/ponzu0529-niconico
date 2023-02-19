import os
import sys
import unittest
from selenium.webdriver.remote.webdriver import WebElement

sys.path.append('/app')

from Common.Python.classes.ControlWebDriver import ControlWebDriver


class TestSelenium(unittest.TestCase):

    def test_docker_selenium_server(self):

        SELENIUM_SERVER_HOST = 'selenium'
        SELENIUM_SERVER_PORT: int = os.environ.get('SELENIUM_SERVER_PORT', '4444')

        GITHUB_USER_NAME = 'PONzu-0529'
        GITHUB_REPOSITORY_NAME = 'ponzu0529-niconico'

        control_web_driver = ControlWebDriver(SELENIUM_SERVER_HOST, SELENIUM_SERVER_PORT)

        try:

            control_web_driver.access_the_url("https://github.com/%s/%s" % (GITHUB_USER_NAME, GITHUB_REPOSITORY_NAME))

            repositoryContainerHeaderElem = control_web_driver.find_element_by_id('repository-container-header')
            aTags: list[WebElement] = control_web_driver.find_elements_by_tag_name('a', repositoryContainerHeaderElem)

            self.assertEqual(aTags[0].text, GITHUB_USER_NAME)
            self.assertEqual(aTags[1].text, GITHUB_REPOSITORY_NAME)

        except Exception as e:

            self.fail("ERROR: %s" % str(e))

        finally:

            control_web_driver.delete_driver()

            del control_web_driver


if (__name__ == '__main__'):

    unittest.main()
