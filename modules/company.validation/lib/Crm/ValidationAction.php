<?php
declare(strict_types=1);

namespace Company\Validation\Crm;

use Bitrix\Crm\Item;
use Bitrix\Crm\Service\Operation\Action;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Result;
use Company\Validation\Config\SmartProcessConfig;

final class ValidationAction extends Action
{
    /**
     * @throws ArgumentException
     */
    public function process(Item $item): Result
    {
        $config = SmartProcessConfig::get();
        $operationValidator = new OperationValidator($config);
        $validationResult = $operationValidator->validate($item);

        return $validationResult ?? new Result();
    }
}