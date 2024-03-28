<?php

namespace App\Botflow\Eloquent;

use App\Botflow\Contracts\FlowStatus;
use App\Botflow\Eloquent\Casts\FlowMessagesCollectionCast;
use DefStudio\Telegraph\DTO\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Состояние диалога, хранимое в базе
 *
 * @property-read int             $id
 * @property-read int             $created_at
 * @property-read int             $updated_at
 * @property-read int             $deleted_at
 *
 * @property string               $class
 * @property FlowStatus           $status
 * @property array                $params
 * @property array                $state
 * @property array                $data
 * @property Collection|Message[] $messages
 * @property int                  $telegram_id
 */
class FlowState extends Model
{

    protected $table = 'botflow_state';

    protected $casts = [
        'status'   => FlowStatus::class,
        'params'   => 'array',
        'state'    => 'array',
        'data'     => 'array',
        'messages' => FlowMessagesCollectionCast::class,
    ];
}
