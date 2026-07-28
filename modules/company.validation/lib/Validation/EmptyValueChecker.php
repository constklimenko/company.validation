<?php

declare(strict_types=1);

namespace Company\Validation\Validation;

final class EmptyValueChecker
{
    /**
     * @param mixed $value
     * @return bool
     * Пустыми должны считаться:
     *  null;
     *  пустая строка;
     *  пустой массив
     *  массив пустых элементов
     */
    public static function isEmpty(mixed $value): bool
    {
        if ($value === null) {
            return true;
        }
        if ($value === false) {
            return true;
        }

        if ($value === '') {
            return true;
        }

        if (is_array($value)) {
            if (count($value) === 0) {
                return true;
            }

            foreach ($value as $item) {
                if ($item !== null) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }
}
