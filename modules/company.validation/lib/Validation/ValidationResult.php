<?php

declare(strict_types=1);

namespace Company\Validation\Validation;

final class ValidationResult
{
    private bool $success;
    private array $emptyFields;

    public function __construct(bool $success, array $emptyFields = [])
    {
        $this->success = $success;
        $this->emptyFields = $emptyFields;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getEmptyFields(): array
    {
        return $this->emptyFields;
    }

    public function getErrorMessage(): string
    {
        if ($this->success) {
            return '';
        }

        $message = 'Невозможно сохранить элемент. Заполните обязательные поля:';

        $fieldsList = $this->getEmptyFields();
        foreach ($fieldsList as $key => $field) {
            $message .= "\n " . $field ;
            if($key < count($fieldsList) - 1) $message .= ",";
        }

        return $message;
    }
}
