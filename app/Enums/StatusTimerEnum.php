<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StatusTimerEnum extends Enum
{
    const BAT_HEN_GIO = 1;
    const TAT_HEN_GIO = 0;
    const HET_HAN = 2;
}
