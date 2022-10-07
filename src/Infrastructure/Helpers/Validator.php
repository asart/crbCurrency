<?php

namespace App\Infrastructure\Helpers;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait Validator
{
    public function validate(ValidatorInterface $validator, $model, array $validators = []): ConstraintViolationListInterface|bool
    {
        if (!empty($validators)) {
            $violations = $validator->validate($model, $validators);
        } else {
            $violations = $validator->validate($model);
        }

        if ($violations->count() > 0) {
            return $violations;
        }

        return true;
    }

    public function createJsonResponseFromViolations(ConstraintViolationListInterface $violations): array
    {
        $violationList = [];
        for ($i = 0; $i < $violations->count(); $i++) {
            $violation = $violations->get($i);
            $violationList[] = [$violation->getPropertyPath() => $violation->getMessage()];
        }

        return $violationList;
    }
}