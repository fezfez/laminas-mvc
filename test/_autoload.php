<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;

if (
    ! class_exists(phpunit_framework_assert::class)
    && class_exists(Assert::class)
) {
    class_alias(Assert::class, phpunit_framework_assert::class);
}
