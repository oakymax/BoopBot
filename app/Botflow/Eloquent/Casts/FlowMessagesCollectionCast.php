<?php

namespace App\Botflow\Eloquent\Casts;

use App\Botflow\Eloquent\FlowState;
use DefStudio\Telegraph\DTO\Message;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class FlowMessagesCollectionCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model  $model
     * @param string $key
     * @param mixed  $value
     * @param array  $attributes
     *
     * @return Collection
     */
    public function get($model, string $key, $value, array $attributes): Collection
    {
        $rawArray = json_decode($value, true);
        $messages = [];
        foreach ($rawArray as $rawMessage) {
            $message = Message::fromArray($rawMessage);
            $messages[$message->id()] = $message;
        }
        return collect($messages);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param FlowState $model
     * @param string    $key
     * @param mixed     $value
     * @param array     $attributes
     *
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        $messagesArray = $model->messages->map(fn (Message $item) => $item->toArray());

        return json_encode($messagesArray, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
