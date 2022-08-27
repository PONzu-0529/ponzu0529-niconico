import os
from selenium import webdriver
from selenium.webdriver.chrome.options import Options


def main():

    SELENIUM_SERVER_PORT: int = os.environ.get('SELENIUM_SERVER_PORT', '4444')

    option = Options()

    option.add_argument("--headless")
    option.add_argument('--mute-audio')
    option.add_argument('--no-sandbox')
    option.add_experimental_option('excludeSwitches', ['enable-logging'])

    driver = webdriver.Remote(
        command_executor="http://selenium:%s" % (SELENIUM_SERVER_PORT),
        options=option
    )

    try:

        driver.maximize_window()

        driver.get('https://github.com/PONzu-0529/ponzu0529-niconico')

        driver.save_screenshot('test.png')

        input('Press Enter...')

    except Exception as e:

        print('ERROR:', str(e))

    finally:

        driver.quit()


if (__name__ == '__main__'):

    main()
