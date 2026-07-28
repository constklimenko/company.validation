<?php

declare(strict_types=1);

namespace Company\Validation\Crm;

use Bitrix\Crm\Item;
use Bitrix\Crm\Model\Dynamic\TypeTable;
use Bitrix\Crm\Service\Factory\Dynamic;
use Bitrix\Main\Error;
use Bitrix\Main\Result;
use Company\Validation\Validation\Validator;

final class OperationValidator
{
    private array $config;
    private ?Dynamic $dynamicFactory = null;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function validate(Item $item): ?Result
    {
        if ($item->getEntityTypeId() !== $this->config['entityTypeId']) {
            return null;
        }

        $categoryId = $item->getCategoryId();

        // проверка categoryId должна учитывать, что у нового элемента категория может быть не установлена.
        // Достаточно проверять только если категория явно задана и отличается от целевой
        if ($categoryId !== null && $categoryId !== $this->config['categoryId']) {
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

    private function buildFinalState(Item $item): array
    {
        $finalData = [];

        if (!$item->isNew()) {
            $factory = $this->getFactory();
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

    private function getFactory(): ?Dynamic
    {
        if ($this->dynamicFactory === null) {
            $type = TypeTable::getByEntityTypeId($this->config['entityTypeId'])->fetchObject();
            if ($type === null) {
                return null;
            }
            $this->dynamicFactory = new Dynamic($type);
        }

        return $this->dynamicFactory;
    }
}
