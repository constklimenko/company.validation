<?php

declare(strict_types=1);

namespace Company\Validation\Crm;

use Bitrix\Crm\Model\Dynamic\TypeTable;
use Bitrix\Crm\Service\Factory\Dynamic;
use Company\Validation\Config\SmartProcessConfig;
use Bitrix\Crm\Item;
use Bitrix\Crm\Service\Context;
use Bitrix\Crm\Service\Operation;

final class CustomFactory extends Dynamic
{
    private array $config;
    public function __construct()
    {
        $this->config = SmartProcessConfig::get();
        $type = TypeTable::getByEntityTypeId($this->config['entityTypeId'])->fetchObject();

        if (!is_null($type))
        {
            parent::__construct($type);
        }
        else
        {
            throw new \Exception("Smart process type with ID {$this->config['entityTypeId']} not found.");
        }
    }

    public function getUpdateOperation(Item $item, Context $context = null): Operation\Update
    {
        // 1. Получаем стандартную операцию обновления
        $operation = parent::getUpdateOperation($item, $context);

        // Выносим добавление действий в отдельный метод
        $this->registerBeforeSaveActions($operation);

        return $operation;
    }

    public function getAddOperation(Item $item, Context $context = null): Operation\Add
    {
        $operation = parent::getAddOperation($item, $context);
        // Выносим добавление действий в отдельный метод
        $this->registerBeforeSaveActions($operation);

        return $operation;
    }

    protected function registerBeforeSaveActions(Operation\Update | Operation\Add $operation): void
    {
        $actions = [
            new ValidationAction()
        ];

        foreach ($actions as $action)
        {
            $operation->addAction(Operation::ACTION_BEFORE_SAVE, $action);
        }
    }


}