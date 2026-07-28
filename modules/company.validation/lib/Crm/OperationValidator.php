<?php

declare(strict_types=1);

namespace Company\Validation\Crm;

use Bitrix\Crm\Item;
use Bitrix\Crm\Service\Container;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Error;
use Bitrix\Main\Result;
use Company\Validation\Validation\Validator;

class OperationValidator
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @throws ArgumentException
     */
    public function validate(Item $item): ?Result
    {
        if ($item->getEntityTypeId() !== $this->config['entityTypeId']) {
            return null;
        }

        if ($item->getCategoryId() !== $this->config['categoryId']) {
            return null;
        }

        $finalData = $this->buildFinalState($item);

        $validator = new Validator($this->config);
        $validationResult = $validator->check($finalData);

        if ($validationResult->isSuccess()) {
            return null;
        }

        $result = new Result();
        $result->addError(new Error($validationResult->getErrorMessage()));

        return $result;
    }

    /**
     * @throws ArgumentException
     */
    private function buildFinalState(Item $item): array
    {
        $finalData = [];

        if (!$item->isNew()) {
            $factory = Container::getInstance()->getFactory($this->config['entityTypeId']);
            if ($factory !== null) {
                $storedItem = $factory->getItem($item->getId());
                if ($storedItem !== null) {
                    foreach ($this->config['fields'] as $fieldName) {
                        $finalData[$fieldName] = $storedItem->get($fieldName);
                    }
                }
            }
        }

        foreach ($this->config['fields'] as $fieldName) {
            if ($item->isChanged($fieldName)) {
                $finalData[$fieldName] = $item->get($fieldName);
            }
        }

        return $finalData;
    }
}
