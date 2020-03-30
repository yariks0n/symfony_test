<?php

namespace App\MessageHandler;

use App\Builders\TransactionBuilder;
use App\Message\TransactionNotification;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TransactionNotificationHandler implements MessageHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(ManagerRegistry $manager)
    {
        $this->manager = $manager;
    }

    public function __invoke(TransactionNotification $notification)
    {
        $data_builder = json_decode($notification->getContent(),true);
        $transactionBuilder = new TransactionBuilder($this->manager, $data_builder);
        $transactionBuilder->start();
    }
}