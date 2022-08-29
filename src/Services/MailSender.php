<?php 

namespace App\Services;

use App\Entity\NewsletterNames;
use App\Entity\NewsletterSubscribers;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\BodyRendererInterface;

class MailSender 
{
    protected $mailer;
    protected $bodyRenderer;

    public function __construct(
        MailerInterface $mailer,
        BodyRendererInterface $bodyRenderer
    )
    {
        $this->mailer = $mailer;
        $this->bodyRenderer = $bodyRenderer;
    }


    public function send(NewsletterSubscribers $subscriber,NewsletterNames $newsletter, String $template, String $subject)
    {
        $email = (new TemplatedEmail())
            ->from('newsletter@numericway.net')
            ->to($subscriber->getEmail())
            ->subject($subject)
            ->htmlTemplate($template)
            ->context(['newsletter' => $newsletter, 'subscriber' => $subscriber])
        ;
        // $this->bodyRenderer->render($email);
        $this->mailer->send($email);
    }
}