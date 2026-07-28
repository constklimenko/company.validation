<?php

declare(strict_types=1);

namespace Company\Validation\Event;

use Bitrix\Main\DI\ServiceLocator;
use Company\Validation\Config\SmartProcessConfig;
use Company\Validation\Crm\CustomFactory;

final class Handler
{
    public static function onProlog(): void
    {
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
}
