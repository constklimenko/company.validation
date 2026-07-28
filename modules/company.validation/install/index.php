<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\EventManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

class company_validation extends CModule
{
    public $MODULE_ID = 'company.validation';
    public $MODULE_NAME = 'Валидация смарт-процесса';
    public $MODULE_DESCRIPTION = 'Серверная валидация обязательных полей элементов смарт-процесса';

    public function DoInstall(): void
    {
        ModuleManager::registerModule($this->MODULE_ID);
    }

    public function DoUninstall(): void
    {
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }
}
