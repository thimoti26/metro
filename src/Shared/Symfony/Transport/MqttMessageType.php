<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Transport;

class MqttMessageType
{
    public const PUBLISH                     = 'PUBLISH';
    public const PUBLISH_ACKNOWLEDGEMENT     = 'PUBACK';
    public const PUBLISH_RECEIPT             = 'PUBREC';
    public const PUBLISH_RELEASE             = 'PUBREL';
    public const PUBLISH_COMPLETE            = 'PUBCOMP';
    public const SUBSCRIBE_ACKNOWLEDGEMENT   = 'SUBACK';
    public const UNSUBSCRIBE_ACKNOWLEDGEMENT = 'UNSUBACK';
    public const PING_REQUEST                = 'PINGREQ';
    public const PING_RESPONSE               = 'PINGRESP';
}
