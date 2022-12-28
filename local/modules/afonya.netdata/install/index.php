<?php

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

Class afonya_netdata extends CModule
{
    public function __construct()
    {
        $this->MODULE_ID = 'afonya.netdata';
        $this->MODULE_VERSION = '1';
        $this->MODULE_VERSION_DATE = '2022-12-25 00:00:00';
        $this->MODULE_NAME = 'netdata';
        $this->MODULE_DESCRIPTION = 'Тестовое задание';
        $this->MODULE_GROUP_RIGHTS = 'Y';
        $this->PARTNER_NAME = 'Евгений Яковлев';
    }
    public function doInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->registerEventHandlerCompatible('sale', 'OnOrderAdd', $this->MODULE_ID, 'Afonya\Netdata\getnetdata', 'GetIP');
    }
    public function doUninstall()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandler('sale', 'OnOrderAdd', $this->MODULE_ID, 'Afonya\Netdata\getnetdata', 'GetIP');
        ModuleManager::unregisterModule($this->MODULE_ID);
    }

}