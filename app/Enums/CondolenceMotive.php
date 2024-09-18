<?php

namespace App\Enums;

enum CondolenceMotive: string
{
    case FS811083NOV = 'FS 81-1083_NOV';

    case FS811148NOV = 'FS 81-11148_NOV';

    case FS811150NOV = 'FS 81-1150_NOV';

    case FS811065NOV = 'FS 81-1065_NOV';

    case FS811331 = 'FS 81-1331';

    case FS811335 = 'FS 81-1335';

    case FS811337 = 'FS 81-1337';

    case FS811343 = 'FS 81-1343';

    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[strtolower($case->name)] = $case->value;
        }
        return $options;
    }
}
