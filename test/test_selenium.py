import os
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.remote.webdriver import WebElement


def main():

    SELENIUM_SERVER_HOST = 'selenium'
    SELENIUM_SERVER_PORT: int = os.environ.get('SELENIUM_SERVER_PORT', '4444')

    GITHUB_USER_NAME = 'PONzu-0529'
    GITHUB_REPOSITORY_NAME = 'ponzu0529-niconico'

    option = Options()

    option.add_argument("--headless")
    option.add_argument('--mute-audio')
    option.add_argument('--no-sandbox')
    option.add_experimental_option('excludeSwitches', ['enable-logging'])

    driver = webdriver.Remote(
        command_executor="http://%s:%s" % (SELENIUM_SERVER_HOST, SELENIUM_SERVER_PORT),
        options=option
    )

    try:

        driver.maximize_window()

        driver.get("https://github.com/%s/%s" % (GITHUB_USER_NAME, GITHUB_REPOSITORY_NAME))

        repositoryContainerHeaderElem = driver.find_element_by_id('repository-container-header')

        aTags: list[WebElement] = repositoryContainerHeaderElem.find_elements_by_tag_name('a')

        print(aTags[1].text)

    except Exception as e:

        print('ERROR:', str(e))

    finally:

        driver.quit()


if (__name__ == '__main__'):

    main()
