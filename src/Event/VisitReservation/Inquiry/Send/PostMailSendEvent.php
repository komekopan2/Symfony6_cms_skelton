<?php
namespace App\Event\VisitReservation\Inquiry\Send;

use App\Entity\VisitReservation\Inquiry;
use Symfony\Component\Form\FormInterface;
use Symfony\Contracts\EventDispatcher\Event;

class PostMailSendEvent extends Event
{
    public const EVENT_NAME = "visit-reservation_inquiry_send.post_mail_send";
    public function __construct(
        private readonly Inquiry $inquiry,
        private readonly FormInterface $form
    ) {}
    
    public function getInquiry(): Inquiry
    {
        return $this->inquiry;
    }
    
    public function getForm(): FormInterface
    {
        return $this->form;
    }
}