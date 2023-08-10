<?php
namespace App\Entity\VisitReservation;

use App\Entity\Interfaces\InquiryInterface;
use App\Entity\Traits\InquiryTrait;
use App\Entity\Traits\ModifiedTimeTrait;
use App\Repository\VisitReservation\InquiryRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use TripleE\Utilities\Entity\Interfaces\CsvExportInterface;

#[ORM\Entity(repositoryClass: InquiryRepository::class)]
#[ORM\Table(name: "inquiry_visit-reservation_inquiry")]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false, hardDelete: false)]
class Inquiry implements InquiryInterface, CsvExportInterface
{
    use SoftDeleteableEntity;
    use ModifiedTimeTrait;
    use InquiryTrait;
    
    public function getCsvRow(): array
    {
        return [
            [
                "header" => "ID",
                "value" => $this->getId()
            ],
            [
                "header" => "日時",
                "value" => $this->created_at->format("Y/m/d H:i:s")
            ],
            [
                "header" => "Email",
                "value" => $this->getEmail()
            ],
            [
                "header" => "IPアドレス",
                "value" => $this->getIp()
            ],
        ];
    }
}