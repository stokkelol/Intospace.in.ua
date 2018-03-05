<?php
declare(strict_types=1);

namespace App\Notifications;

use App\Support\Logger\Logger;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class IncomingTelegramBotMessage
 *
 * @package App\Notifications
 */
class IncomingTelegramBotMessage extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var string
     */
    private $message;

    /**
     * Create a new notification instance.
     *
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['slack'];
    }

    /**
     * @return SlackMessage
     */
    public function toSlack($notifiable): SlackMessage
    {
        Logger::log($this->message);

        return (new SlackMessage)
            ->content(
                'User ' .
                $notifiable->first_name . ' ' .
                $notifiable->last_name . ' sent a message "' .
                $this->message . '"'
            );
    }
}
