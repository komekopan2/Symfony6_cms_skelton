<?php
namespace App\MailConfigure\VisitReservation;

use App\Entity\Interfaces\InquiryInterface;
use App\Service\MailService;
use App\MailConfigure\MailConfigureInterface;

class InquiryConfigure implements MailConfigureInterface
{
    public function __construct(
        private MailService $mailService
    ) {}
    
    public function getMailService(): MailService
    {
        return $this->mailService;
    }
    
    public function getOption(string $type, ?InquiryInterface $inquiry = null, array $twigAssign = []): ?array
    {
        if(!$inquiry) {
            throw new \InvalidArgumentException(get_class($this). "::getOption() InquiryInterface required");
        }
        $twigAssign = array_merge($twigAssign, [
            "inquiry" => $inquiry
        ]);
        $resolver = $this->mailService->configureOptions();
        return match ($type) {
            "client" => $resolver->resolve([
                "twigTextTemplate" => "mail/visit-reservation/client.txt.twig",
                "twigAssign" => $twigAssign,
                "subject" => "見学予約がありました"
            ]),
            "reply" => $resolver->resolve([
                "twigTextTemplate" => "mail/visit-reservation/reply.txt.twig",
                "twigAssign" => $twigAssign,
                "subject" => "【自動返信】見学予約を承りました",
                "to" => [$inquiry->getEmail()]
            ]),
            "pardotFailure" => $resolver->resolve([
                "twigTextTemplate" => "mail/visit-reservation/pardot_error.txt.twig",
                "twigAssign" => $twigAssign,
                "subject" => "【見学予約】パードット送信が失敗しました"
            ]),
            default => null,
        };
    }
}