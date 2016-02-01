<?php namespace Manavo\Chatty\MessageHandlers;

use Manavo\Chatty\Interfaces\MessageHandlerInterface;

class Slack implements MessageHandlerInterface
{

    protected $url = null;
    protected $username = 'Chatty';
    protected $icon = '';
    protected $attachments = [];

    public function __construct($options)
    {
        if (!empty($options['url'])) {
            $this->url = $options['url'];
        } else {
            throw new \Manavo\Chatty\ChattyException('Slack inbound webhook URL is required');
        }

        if (!empty($options['username'])) {
            $this->username = $options['username'];
        }
        if (!empty($options['icon'])) {
            $this->icon = $options['icon'];
        }
        if (!empty($options['attachments'])) {
            $this->attachments = $options['attachments'];
        }
    }

    public function handle($message)
    {
        $client = new \GuzzleHttp\Client();

        try {
            $client->post($this->url, [
                'body' => json_encode([
                    'text'     => $message,
                    'username' => $this->username,
                    'icon_url' => $this->icon,
                    'attachments' => $this->attachments,
                ])
            ]);
        } catch (\Exception $e) {
            throw new \Manavo\Chatty\ChattyException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

}
