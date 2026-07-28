<?php

declare(strict_types=1);

namespace Company\Validation\Event;

use Bitrix\Crm\Service\Container;
use Bitrix\Crm\Service\Operation;
use Company\Validation\Config\SmartProcessConfig;
use Company\Validation\Crm\CustomFactory;
use Company\Validation\Crm\ValidationAction;


class Handler
{
    public static function onProlog(): void
    {
        $config = SmartProcessConfig::get();
        \Bitrix\Main\DI\ServiceLocator::getInstance()->addInstance(
            "crm.service.factory.dynamic.{$config['entityTypeId']}",
            new CustomFactory()
        );
    }
}
