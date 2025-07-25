<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RoleEnum extends Enum
{
    const SUPERADMIN = 'SUPERADMIN';
    const ADMINISTRATOR = 'ADMINISTRATOR';
    const STUDENT = 'STUDENTS';
    const TEACHER = 'TEACHER';

    public static function roles()
    {
        $roles = [
            'SUPERADMIN',
            'ADMINISTRATOR',
            'STUDENTS',
            'TEACHER',
        ];
        return $roles;
    }
}
