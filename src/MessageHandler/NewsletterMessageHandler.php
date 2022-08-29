<?php

namespace App\MessageHandler;

use App\Entity\NewsletterNames;
use App\Entity\NewsletterSubscribers;
use App\Message\NewsletterMessage;
use App\Services\MailSender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class NewsletterMessageHandler implements MessageHandlerInterface
{
    private $em;
    private $mailSender;

    public function __construct(EntityManagerInterface $em, MailSender $mailSender)
    {
        $this->em = $em;
        $this->mailSender = $mailSender;
    }
    
    public function __invoke(NewsletterMessage $message)
    {
        $subsciber = $this->em->find(NewsletterSubscribers::class, $message->getSubsciberId());
        $newsletter = $this->em->find(NewsletterNames::class, $message->getNewsletterId()); 

        if ($subsciber && $newsletter ) {
            $this->mailSender->send($subsciber,$newsletter,$message->getTempale(),$newsletter->getName());
        }
    }
}
