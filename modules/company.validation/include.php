<?php

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Loader;
use Company\Validation\Config\SmartProcessConfig;
use Company\Validation\Crm\CustomFactory;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

Loader::registerNamespace(
    'Company\\Validation',
    __DIR__ . '/lib'
);

if(Loader::requireModule('crm')){
    try {
        $config = SmartProcessConfig::get();
        ServiceLocator::getInstance()->addInstance(
            "crm.service.factory.dynamic.{$config['entityTypeId']}",
            new CustomFactory()
        );
    } catch (\Throwable $e) {
        addMessage2Log('company.validation: factory registration failed - ' . $e->getMessage());
    }
}

