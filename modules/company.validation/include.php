<?php

use Bitrix\Main\Loader;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

Loader::registerNamespace(
    'Company\\Validation',
    __DIR__ . '/lib'
);

\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'main',
    'OnProlog',
    [\Company\Validation\Event\Handler::class, 'onProlog']
);
