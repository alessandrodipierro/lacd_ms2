<?php

namespace App\Consumer;

use App\Entity\Message;
use App\Repository\MessageRepository;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class MessageConsumer implements ConsumerInterface
{
    private readonly MessageRepository $messageRepository;

    /**
     * @param MessageRepository $messageRepository
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }


    public function execute(AMQPMessage $msg)
    {
        $message = new Message();
        $message->setValue($msg->getBody());
        $this->messageRepository->save($message, true);
    }
}