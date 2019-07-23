<?php

namespace Guym4c\ActionNetwork\Entity\Utils;

use MyCLabs\Enum\Enum;

class SubscriptionStatus extends Enum {

    const SUBSCRIBED = 'subscribed';
    const UNSUBSCRIBED = 'unsubscribed';
    const BOUNCING = 'bouncing';
    const SPAM_COMPLAINT = 'spam complaint';

}