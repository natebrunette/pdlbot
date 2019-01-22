<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace App\Serialization;

use App\Model\Interaction;
use Tebru\Gson\Element\JsonElement;
use Tebru\Gson\JsonDeserializationContext;
use Tebru\Gson\JsonDeserializer;
use Tebru\PhpType\TypeToken;

class InteractionDeserializer implements JsonDeserializer
{
    /**
     * Called during deserialization process, passing in the JsonElement for the type.  Use
     * the JsonDeserializationContext if you want to delegate deserialization of sub types.
     *
     * @param JsonElement $jsonElement
     * @param TypeToken $type
     * @param JsonDeserializationContext $context
     * @return mixed
     */
    public function deserialize(JsonElement $jsonElement, TypeToken $type, JsonDeserializationContext $context)
    {
        $object = $jsonElement->asJsonObject();

        $interaction = new Interaction();
        $interaction->setChannelId($object->get('channel')->asJsonObject()->get('id')->asString());
        $interaction->setCallbackId($object->get('callback_id')->asString());
        $interaction->setSearchText(
            $object->get('user')->asJsonObject()->get('id')->asString(),
            $object->get('actions')->asJsonArray()->get(0)->asJsonObject()->get('value')->asString()
        );

        return $interaction;
    }
}
