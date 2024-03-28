<?php

namespace App\Botflow\Contracts;

enum FlowStatus: string
{

    case QUEUED = 'queued';

    case ACTIVE = 'active';

    case OK = 'ok';

    case INTERRUPTED = 'interrupted';
}
