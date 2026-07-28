<?php

declare(strict_types=1);

namespace Company\Validation\Validation;

class ValidationResult
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

    public function getErrorMessage(): string
    {
        if ($this->success) {
            return '';
        }

        $message = 'Невозможно сохранить элемент. Заполните обязательные поля:';
        foreach ($this->emptyFields as $field) {
            $message .= "\n— " . $field;
        }

        return $message;
    }
}
