<?php

namespace Manavo\Chatty;

use Manavo\Chatty\Interfaces\MessageHandlerInterface;

class Sender
{

    protected $messageHandler = null;

    /**
     * @param MessageHandlerInterface $messageHandler
     */
    public function __construct(MessageHandlerInterface $messageHandler)
    {
        $this->messageHandler = $messageHandler;
    }

    /**
     * @param string $message
     *
     * @throws ChattyException
     */
    public function send($message)
    {
        try {
            $this->messageHandler->handle($message);
        } catch (\Exception $e) {
            throw new ChattyException($e->getMessage(), $e->getCode(), $e);
        }
    }

}
