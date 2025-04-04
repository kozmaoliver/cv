<?php

namespace App\Enum\User;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum LoginFailureReason: string implements TranslatableInterface
{
    case INVALID_CREDENTIALS = 'invalid_credentials';
    case TWO_FACTOR_FAILURE = 'two_factor_failure';
    case OTHER = 'other';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans('login_failure_reason.' . $this->value, domain: 'enums', locale: $locale);
    }

}
