<?php

namespace Guym4c\ActionNetwork\Entity\Utils;

use MyCLabs\Enum\Enum;

class AttendanceStatus extends Enum {

    const ACCEPTED = 'accepted';
    const TENTATIVE = 'tentative';
    const DECLINED = 'declined';
    const NEEDS_ACTION = 'needs action';
}