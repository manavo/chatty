<?php namespace Manavo\Chatty\MessageHandlers;

use Manavo\Chatty\Interfaces\MessageHandlerInterface;

class Hipchat implements MessageHandlerInterface
{

    protected $url = '';
    protected $token = '';
    protected $room_id = '';
    protected $from = 'Chatty';
    protected $notify = '1';
    protected $color = '';

    public function __construct($options)
    {
        if (!empty($options['token'])) {
            $this->token = $options['token'];
        } else {
            throw new \manavo\Chatty\ChattyException('HipChat Auth Token is required');
        }

        if (!empty($options['room_id'])) {
            $this->room_id = $options['room_id'];
        } else {
            throw new \manavo\Chatty\ChattyException('HipChat Room ID is required');
        }

        if (!empty($options['from'])) {
            if ($this->strlen($options['from']) > 15) {
                throw new \manavo\Chatty\ChattyException('HipChat "From" name can only be 15 characters long');
            }
            $this->from = $options['from'];
        }

        if (array_key_exists('notify', $options)) {
            $this->notify = $options['notify'];
        }
        if (!empty($options['color'])) {
            $this->color = $options['color'];
        }
    }

    public function handle($message)
    {
        $client = new \GuzzleHttp\Client();

        try {
            $url = sprintf(
                'https://api.hipchat.com/v1/rooms/message?auth_token=%s',
                $this->token
            );

            $client->post(
                $url, [
                    'body' => [
                        'room_id'        => $this->room_id,
                        'message'        => $message,
                        'message_format' => 'text',
                        'notify'         => $this->notify,
                        'color'          => $this->color,
                        'from'           => $this->from,
                    ]
                ]);
        } catch (\Exception $e) {
            throw new \manavo\Chatty\ChattyException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Get the length of a string. Used for validating the length of the "from" name.
     *
     * If `mb_strlen()` function is available, or fall back to `strlen()`.
     *
     * @param $str
     *
     * @return int
     */
    private function strlen($str)
    {
        if (function_exists('mb_strlen')) {
            return (mb_strlen($str));
        }

        return (strlen($str));
    }

}
