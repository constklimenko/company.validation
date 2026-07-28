<?php
declare(strict_types=1);

namespace Company\Validation\Crm;

use Bitrix\Crm\Item;
use Bitrix\Crm\Service\Operation\Action;
use Bitrix\Main\Error;
use Bitrix\Main\Result;
use Company\Validation\Config\SmartProcessConfig;

final class ValidationAction extends Action
{
    public function process(Item $item): Result
    {
        try {
            $config = SmartProcessConfig::get();
            $operationValidator = new OperationValidator($config);
            $validationResult = $operationValidator->validate($item);

            return $validationResult ?? new Result();
        } catch (\Throwable $e) {
            $result = new Result();
            $result->addError(new Error('Внутренняя ошибка валидации.'));
            return $result;
        }
    }
}