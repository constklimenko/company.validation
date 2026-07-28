<?php

declare(strict_types=1);

namespace Company\Validation\Validation;

final class Validator
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function check(array $data): ValidationResult
    {
        $resultField = $this->config['fields']['result'];
        $resultValue = $data[$resultField] ?? null;

        if ($resultValue == $this->config['stopResultId']) {
            return new ValidationResult(true);
        }

        $emptyFields = [];
        $requiredFields = $this->config['fieldsMap'];


        foreach ($requiredFields as $key => $item) {
            $fieldName = $this->config['fields'][$key];
            $value = $data[$fieldName] ?? null;

            if (EmptyValueChecker::isEmpty($value, $fieldName)) {
                $emptyFields[] = $item;
            }
        }

        if ($emptyFields !== []) {
            return new ValidationResult(false, $emptyFields);
        }

        return new ValidationResult(true);
    }
}
