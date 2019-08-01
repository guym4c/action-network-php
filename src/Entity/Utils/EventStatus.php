<?php

namespace Guym4c\ActionNetwork\Entity\Utils;

use MyCLabs\Enum\Enum;

class EventStatus extends Enum {

    const CONFIRMED = 'confirmed';
    const TENTATIVE = 'tentative';
    const CANCELLED = 'cancelled';
}