<?php

namespace App\Message;

final class NewsletterMessage
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

    private $subsciberId;
    private $newsletterId;
    private $tempale;

    public function __construct($subsciberId,$newsletterId,$tempale)
    {
        $this->subsciberId = $subsciberId;
        $this->newsletterId = $newsletterId;
        $this->tempale = $tempale;
    }

   public function getSubsciberId(): int
   {
       return $this->subsciberId;
   }
   public function getNewsletterId(): int
   {
       return $this->newsletterId;
   }
   public function getTempale(): string
   {
       return $this->tempale;
   }
}
