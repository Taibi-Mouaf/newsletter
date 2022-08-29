<?php

namespace App\Controller;

use App\Entity\NewsletterSubscribers;
use App\Form\NewsletterSubscribersType;
use App\Message\NewsletterMessage;
use App\Repository\NewsletterSubscribersRepository;
use App\Services\MailSender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterSubscribersController extends AbstractController
{
    /**
     * @Route("/newsletter/subscribers/add", name="app_newsletter_subscribers_add")
     */
    public function index(Request $request, EntityManagerInterface $em, MessageBusInterface $messageBus): Response
    {
        $subscriber = new NewsletterSubscribers();
        $form = $this->createForm(NewsletterSubscribersType::class, $subscriber);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $token = hash('sha256', uniqid());
            $subscriber->setToken($token);
            $em->persist($subscriber);
            $em->flush();
            $this->addFlash('success', 'Subscriber Created');
            foreach($subscriber->getNewsletterNames() as $newsletter) $messageBus->dispatch(new NewsletterMessage($subscriber->getId(),$newsletter->getId(),'email/confirmation.html.twig'));
            return $this->redirectToRoute('app_newsletter_subscribers_add');
        }

        return $this->render('newsletter_subscribers/index.html.twig', [
            'controller_name' => 'Newsletter',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/newsletter/subscribers", name="app_newsletter_subscribers")
     */
    public function getSubscribers(NewsletterSubscribersRepository $subsciberRepository)
    {
        $subscribers = $subsciberRepository->findAll();
        dd($subscribers);
        return "test";
    }

    /**
     * @Route("/newsletter/{token}/{id}", name="app_newsletter_subscribers_update")
     */
    public function updateNewsletter(Request $request, EntityManagerInterface $em, NewsletterSubscribers $subscriber, $token)
    {
        if ($subscriber->getToken() != $token)  $subscriber = new NewsletterSubscribers();
        $form = $this->createForm(NewsletterSubscribersType::class, $subscriber);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $token = hash('sha256', uniqid());
            $subscriber->setToken($token);
            $em->persist($subscriber);
            $em->flush();
            $this->addFlash('success', 'Subscriber Updated');
            return $this->redirectToRoute('app_newsletter_subscribers_add');
        }

        return $this->render('newsletter_subscribers/edit.html.twig', [
            'controller_name' => 'Newsletter',
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/newsletter/{token}/{id}/{newslettre_id}", name="app_newsletter_subscribers_remove")
     */
    public function removeNewsletter(NewsletterSubscribers $subscriber, $token, $newslettre_id, EntityManagerInterface $em): Response
    {
        if ($subscriber->getToken() === $token) {
            foreach($subscriber->getNewsletterNames() as $newsletter) if($newsletter->getId() == $newslettre_id){ 
                $subscriber->removeNewsletterName($newsletter);
                $em->persist($subscriber);
                $em->flush();
            }
        }

        return $this->redirectToRoute('app_newsletter_subscribers_add');
        
    }
    /**
     * @Route("/newsletter", name="app_newsletter_send")
     */
    public function send(NewsletterSubscribersRepository $subsciberRepository, MessageBusInterface $messageBus): Response
    {
        $subscribers = $subsciberRepository->findAll();
        foreach($subscribers as $subscriber){
            foreach($subscriber->getNewsletterNames() as $newsletter) $messageBus->dispatch(new NewsletterMessage($subscriber->getId(),$newsletter->getId(),'email/newsletter.html.twig'));
        }
        return $this->redirectToRoute('app_newsletter_subscribers_add');
    }
}
