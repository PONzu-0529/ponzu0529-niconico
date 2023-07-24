<?php

namespace App\Services;

use Facebook\WebDriver\WebDriverBy;
use App\Services\SeleniumService;

/**
 * MylistAssistant Selenium Service
 */
class MylistAssistantSeleniumService extends SeleniumService
{
    /**
     * Create Mylist
     *
     * @param string $mylist_title Mylist Title
     * @return void
     */
    public function createMylist(string $mylist_title): void
    {
        $this->openPage('https://www.nicovideo.jp/my/mylist');

        $NEW_BUTTON_SELECTOR = '#UserPage-app > section > section > main > div > section > div > div.MylistsContainer-section.MylistsContainer-actionSection > button:nth-child(1)';
        $new_button_element = $this->getWebElementByCssSelector($NEW_BUTTON_SELECTOR);
        $this->waitForElement($new_button_element);
        $this->clickButton($new_button_element);

        $MYLIST_TITLE_SELECTOR = '#undefined-title';
        $mylist_title_element = $this->getWebElementByCssSelector($MYLIST_TITLE_SELECTOR);
        $this->waitForElement($mylist_title_element);
        $this->typeInInput($mylist_title_element, $mylist_title);

        $CREATE_BUTTON_SELECTOR = 'body > div.Fade.Modal.EditMylistModal.MylistCreateModalContainer > div > div > article > footer > button';
        $create_button_element = $this->getWebElementByCssSelector($CREATE_BUTTON_SELECTOR);
        $this->waitForElement($create_button_element);
        $this->clickButton($create_button_element);
    }

    /**
     * Delete Mylist
     *
     * @param string $mylist_title Mylist Title
     * @return void
     */
    public function deleteMylist(string $mylist_title): void
    {
        $this->openPage('https://www.nicovideo.jp/my/mylist');

        $MYLIST_CONTENTS_XPATH = '//*[@id="UserPage-app"]/section/section/main/div/section/div/div[3]/div';
        $mylist_elements = $this->driver->findElements(
            WebDriverBy::xpath($MYLIST_CONTENTS_XPATH)
        );

        $mylist_element_list = [];

        foreach ($mylist_elements as $mylist_element) {
            $title = preg_split('/\r\n|\r|\n/', $mylist_element->getText())[1];
            $mylist_element_list[$title] = $mylist_element;
        }

        $mylist_element = $mylist_element_list[$mylist_title];
        $this->clickButton($mylist_element);

        $THREE_POINT_MENU_SELECTOR = '#UserPage-app > section > section > main > div > section > div > header > div > div.NC-ThreePointMenu.MylistHeaderMenu.MylistHeaderAction-item.NC-ThreePointMenu_dark > button';
        $this->waitForElementByCssSelector($THREE_POINT_MENU_SELECTOR);
        $three_point_menu_element = $this->getWebElementByCssSelector($THREE_POINT_MENU_SELECTOR);
        $this->clickButton($three_point_menu_element);

        $DELETE_BUTTON_SELECTOR = '#UserPage-app > section > section > main > div > section > div > header > div > div.NC-ThreePointMenu.MylistHeaderMenu.MylistHeaderAction-item.NC-ThreePointMenu_dark > div > button:nth-child(3)';
        $this->waitForElementByCssSelector($DELETE_BUTTON_SELECTOR);
        $delete_button_element = $this->getWebElementByCssSelector($DELETE_BUTTON_SELECTOR);
        $this->clickButton($delete_button_element);

        $this->handleAlert();
    }

    /**
     * Add Video to Mylist
     *
     * @param string $video_id Video ID
     * @param string $mylist_title Mylist Title
     * @return void
     */
    public function addVideoToMylist(string $video_id, string $mylist_title): void
    {
        $this->openPage("https://www.nicovideo.jp/watch/$video_id");

        $ADD_MYLIST_BUTTON_SELECTOR = '#js-app > div > div.WatchAppContainer-main > div.MainContainer > div.MainContainer-playerPanel > div.Grid.VideoMenuContainer > div.GridCell.col-fill.VideoMenuContainer-areaLeft > div:nth-child(2) > button';
        $this->waitForElementByCssSelector($ADD_MYLIST_BUTTON_SELECTOR);
        $add_mylist_button_element = $this->getWebElementByCssSelector($ADD_MYLIST_BUTTON_SELECTOR);
        $this->clickButton($add_mylist_button_element);

        $MYLIST_PANEL_SELECTOR = '#js-app > div > div.WatchAppContainer-main > div.MainContainer > div.MainContainer-floatingPanel > div';
        $this->waitForElementByCssSelector($MYLIST_PANEL_SELECTOR);

        $MYLIST_ITEMS_XPATH = '//*[@id="js-app"]/div/div[2]/div[2]/div[3]/div/div/div[2]/div/div/div/div/div[2]/div';
        $mylist_elements = $this->driver->findElements(
            WebDriverBy::xpath($MYLIST_ITEMS_XPATH)
        );

        $mylist_element_list = [];

        foreach ($mylist_elements as $mylist_element) {
            $mylist_element_list[$mylist_element->getText()] = $mylist_element;
        }

        $mylist_element = $mylist_element_list[$mylist_title];
        $this->clickButton($mylist_element);

        $REGISTER_BUTTON_SELECTOR = '#js-app > div > div.WatchAppContainer-main > div.MainContainer > div.MainContainer-floatingPanel > div > div > div.AddVideoListPanelContainer-content > div.AddMylistModal > div.AddMylistModal-buttonGroup > button.ActionButton.AddMylistModal-submit';
        $this->waitForElementByCssSelector($REGISTER_BUTTON_SELECTOR);
        $register_button_element = $this->getWebElementByCssSelector($REGISTER_BUTTON_SELECTOR);
        $this->clickButton($register_button_element);

        $ADD_MYLIST_BUTTON_SELECTOR = '#js-app > div > div.WatchAppContainer-main > div.MainContainer > div.MainContainer-playerPanel > div.Grid.VideoMenuContainer > div.GridCell.col-fill.VideoMenuContainer-areaLeft > div:nth-child(2) > button';
        $this->waitForElementByCssSelector($ADD_MYLIST_BUTTON_SELECTOR);
    }

    /**
     * Login Niconico
     *
     * @param string $email Email
     * @param string $password Password
     * @return void
     */
    public function loginNiconico(string $email, string $password)
    {
        $EMAIL_SELECTOR = '#input__mailtel';
        $PASSWORD_SELECTOR = '#input__password';
        $LOGIN_BUTTON_SELECTOR = '#login__submit';

        $this->openPage('https://account.nicovideo.jp/login');

        $this->waitForElementByCssSelector($EMAIL_SELECTOR);
        $this->typeInInput(
            $this->getWebElementByCssSelector($EMAIL_SELECTOR),
            $email
        );

        $this->waitForElementByCssSelector($PASSWORD_SELECTOR);
        $this->typeInInput(
            $this->getWebElementByCssSelector($PASSWORD_SELECTOR),
            $password
        );

        $this->waitForElementByCssSelector($LOGIN_BUTTON_SELECTOR);
        $this->clickButton(
            $this->getWebElementByCssSelector($LOGIN_BUTTON_SELECTOR)
        );
    }
}
