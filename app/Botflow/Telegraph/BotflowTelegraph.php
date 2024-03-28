<?php

namespace App\Botflow\Telegraph;

use DefStudio\Telegraph\Client\TelegraphResponse;
use DefStudio\Telegraph\Telegraph;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

/**
 * Кастомный телеграф с блэкджеком
 */
class BotflowTelegraph extends Telegraph
{

    const REACTION_THUMBS_UP = "👍";
    const REACTION_THUMBS_DOWN = "👎";
    const REACTION_HEART = "❤";
    const REACTION_FIRE       = "🔥";
    const REACTION_KISSES     = "🥰";
    const REACTION_CLAP_HANDS = "👏";
    const REACTION_LAUGH      = "😁";
    const REACTION_HMM = "🤔";
    const REACTION_HEAD_BLOW = "🤯";
    const REACTION_SCREAM = "😱";
    const REACTION_SWEARS = "🤬";
    const REACTION_SAD = "😢";
    const REACTION_CELEBRATE = "🎉";
    const REACTION_IN_LOVE = "🤩";
    const REACTION_DISGUSTING = "🤮";
    const REACTION_SHIT = "💩";
    const REACTION_THANKS = "🙏";
    const REACTION_OK = "👌";
    const REACTION_PEACE = "🕊";
    const REACTION_CLOWN = "🤡";
    const REACTION_BORING = "🥱";
    const REACTION_CRINGE = "🥴";
    const REACTION_SMILE = "😍";
    const REACTION_WHALE = "🐳";
    const REACTION_HEARTFIRE = "❤‍🔥";
    const REACTION_MOON      = "🌚";
    const REACTION_HOTDOG    = "🌭";
    const REACTION_TOP    = "💯";
    const REACTION_LOL = "🤣";
    const REACTION_LIGHTNING = "⚡";
    const REACTION_BANANA = "🍌";
    const REACTION_PRIZE = "🏆";
    const REACTION_BROKEN_HEART = "💔";
    const REACTION_CONFUSED    = "🤨";
    const REACTION_INDIFFERENT = "😐";
    const REACTION_STRAWBERRY  = "🍓";
    const REACTION_CHAMPAGNE = "🍾";
    const REACTION_KISS = "💋";
    const REACTION_MIDDLE_FINGER = "🖕";
    const REACTION_DEVIL = "😈";
    const REACTION_SLEEPING = "😴";
    const REACTION_CRY = "😭";
    const REACTION_CHILD_PRODIGY = "🤓";
    const REACTION_GHOST = "👻";
    const REACTION_WORK = "👨‍💻";
    const REACTION_SEE = "👀";
    const REACTION_PUMPKIN      = "🎃";
    const REACTION_MONKEY_BLIND = "🙈";
    const REACTION_SAINT        = "😇";
    const REACTION_SCARE = "😨";
    const REACTION_HANDSHAKE = "🤝";
    const REACTION_WRITING_HAND = "✍";
    const REACTION_THANK_YOU = "🤗";
    const REACTION_YES_SIR = "🫡";
    const REACTION_SANTA = "🎅";
    const REACTION_CHRISTMAS_TREE = "🎄";
    const REACTION_SNOWMAN = "☃";
    const REACTION_NAILS = "💅";
    const REACTION_TONGUE = "🤪";
    const REACTION_EASTER_ISLAND = "🗿";
    const REACTION_COOL = "🆒";
    const REACTION_HEART_ARROW = "💘";
    const REACTION_MONKEY_DEAF = "🙉";
    const REACTION_UNICORN = "🦄";
    const REACTION_AIR_KISS = "😘";
    const REACTION_TABLET = "💊";
    const REACTION_MONKEY_MUTE = "🙊";
    const REACTION_COOL_GUY = "😎";
    const REACTION_CHUPAKABRA = "👾";
    const REACTION_DOWN_KNOW_WOMAN = "🤷‍♂";
    const REACTION_DONT_KNOW = "🤷";
    const REACTION_DONT_KNOW_MAP = "🤷‍♀";
    const REACTION_ANGRY = "😡";


    protected LoggerInterface $log;

    public function __construct()
    {
        parent::__construct();

        $this->log = Log::channel('telegraph');
    }

    public function send(): TelegraphResponse
    {

        $this->log->info("[BOT => TG][REQUEST]", $this->toArray());

        $response = TelegraphResponse::fromResponse($this->sendRequestToTelegram());

        $this->log->info("[BOT <= TG][RESPONSE]", [
            'headers' => $response->headers(),
            'body' => $response->json()
        ]);

        return $response;
    }



    public function setMessageReaction(int $messageId, string $reaction = self::REACTION_HEART): self
    {

        $this->endpoint = 'setMessageReaction';

        $this->data['message_id'] = $messageId;
        $this->data['chat_id'] = $this->getChatId();
        $this->data['reaction'] = [['type' => 'emoji', 'emoji' => $reaction]];
        $this->data['is_big'] = true;

        return $this;
    }

    public function getFunnyReactions(): array
    {
        return [
            self::REACTION_THUMBS_UP,
            self::REACTION_HEART,
            self::REACTION_FIRE,
            self::REACTION_KISSES,
            self::REACTION_CLAP_HANDS,
            self::REACTION_OK,
            self::REACTION_PEACE,
            self::REACTION_SMILE,
            self::REACTION_WHALE,
            self::REACTION_TOP,
            self::REACTION_PRIZE,
            self::REACTION_STRAWBERRY,
            self::REACTION_KISS,
            self::REACTION_GHOST,
            self::REACTION_WORK,
            self::REACTION_SEE,
            self::REACTION_SAINT,
            self::REACTION_HANDSHAKE,
            self::REACTION_WRITING_HAND,
            self::REACTION_THANK_YOU,
            self::REACTION_YES_SIR,
            self::REACTION_TONGUE,
            self::REACTION_EASTER_ISLAND,
            self::REACTION_COOL,
            self::REACTION_UNICORN,
            self::REACTION_AIR_KISS,
            self::REACTION_COOL_GUY,
            self::REACTION_CHUPAKABRA,
        ];
    }

    public function getConfusedReactions(): array
    {
        return [
            self::REACTION_HMM,
            self::REACTION_CONFUSED,
            self::REACTION_SEE,
            self::REACTION_DOWN_KNOW_WOMAN,
            self::REACTION_DONT_KNOW,
            self::REACTION_DONT_KNOW_MAP,
        ];
    }
}
