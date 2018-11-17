<?php
declare(strict_types=1);

namespace App\Bot\Bands;

use App\Models\Band;
use App\Models\OutboundMessageContext;
use App\Models\TelegramUser;

/**
 * Class More
 *
 * @package App\Bot\Bands
 */
class More
{
    /**
     * @var Band
     */
    private $context;

    /**
     * @var TelegramUser
     */
    private $user;

    /**
     * More constructor.
     *
     * @param OutboundMessageContext $context
     * @param TelegramUser $user
     */
    public function __construct(OutboundMessageContext $context, TelegramUser $user)
    {
        $this->context = $context;
        $this->user = $user;
    }

    public function handle()
    {

    }
}