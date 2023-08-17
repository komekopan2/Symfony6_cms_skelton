<?php

namespace App\Entity\VisitReservation;

use App\Entity\Interfaces\InquiryInterface;
use App\Entity\Traits\InquiryTrait;
use App\Entity\Traits\ModifiedTimeTrait;
use App\Repository\VisitReservation\InquiryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use TripleE\Utilities\Entity\Interfaces\CsvExportInterface;

#[ORM\Entity(repositoryClass: InquiryRepository::class)]
#[ORM\Table(name: "inquiry_visit_reservation_inquiry")]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false, hardDelete: false)]
class Inquiry implements InquiryInterface, CsvExportInterface
{
    use SoftDeleteableEntity;
    use ModifiedTimeTrait;
    use InquiryTrait;

    #[ORM\Column(length: 48, nullable: true)]
    private ?string $nameSei = null;

    #[ORM\Column(length: 48, nullable: true)]
    private ?string $nameMei = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(nullable: true)]
    private ?int $hopeHour1 = null;

    #[ORM\Column(nullable: true)]
    private ?int $hopeMinute1 = null;

    #[ORM\Column(nullable: true)]
    private ?int $hopeHour2 = null;

    #[ORM\Column(nullable: true)]
    private ?int $hopeMinute2 = null;

    #[ORM\Column(nullable: true)]
    private ?int $hopeHour3 = null;

    #[ORM\Column(nullable: true)]
    private ?int $hopeMinute3 = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $hopeDate1 = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $hopeDate2 = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $hopeDate3 = null;

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
                "header" => "お名前",
                "value" => $this->nameSei . " " . $this->nameMei
            ],
            [
                "header" => "電話番号",
                "value" => $this->phone
            ],
            [
                "header" => "メールアドレス",
                "value" => $this->getEmail()
            ],
            [
                "header" => "第1ご希望日",
                "value" => sprintf("%s %s:%s", $this->hopeDate1?->format("Y/m/d"), $this->hopeHour1, $this->hopeMinute1)
            ],
            [
                "header" => "第2ご希望日",
                "value" => sprintf("%s %s:%s", $this->hopeDate2?->format("Y/m/d"), $this->hopeHour2, $this->hopeMinute2)
            ],
            [
                "header" => "第3ご希望日",
                "value" => sprintf("%s %s:%s", $this->hopeDate3?->format("Y/m/d"), $this->hopeHour3, $this->hopeMinute3)
            ],
            [
                "header" => "IPアドレス",
                "value" => $this->getIp()
            ],
        ];
    }

    public function getNameSei(): ?string
    {
        return $this->nameSei;
    }

    public function setNameSei(?string $nameSei): self
    {
        $this->nameSei = $nameSei;

        return $this;
    }

    public function getNameMei(): ?string
    {
        return $this->nameMei;
    }

    public function setNameMei(?string $nameMei): self
    {
        $this->nameMei = $nameMei;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getHopeHour1(): ?int
    {
        return $this->hopeHour1;
    }

    public function setHopeHour1(?int $hopeHour1): self
    {
        $this->hopeHour1 = $hopeHour1;

        return $this;
    }

    public function getHopeMinute1(): ?int
    {
        return $this->hopeMinute1;
    }

    public function setHopeMinute1(?int $hopeMinute1): self
    {
        $this->hopeMinute1 = $hopeMinute1;

        return $this;
    }

    public function getHopeHour2(): ?int
    {
        return $this->hopeHour2;
    }

    public function setHopeHour2(?int $hopeHour2): self
    {
        $this->hopeHour2 = $hopeHour2;

        return $this;
    }

    public function getHopeMinute2(): ?int
    {
        return $this->hopeMinute2;
    }

    public function setHopeMinute2(?int $hopeMinute2): self
    {
        $this->hopeMinute2 = $hopeMinute2;

        return $this;
    }

    public function getHopeHour3(): ?int
    {
        return $this->hopeHour3;
    }

    public function setHopeHour3(?int $hopeHour3): self
    {
        $this->hopeHour3 = $hopeHour3;

        return $this;
    }

    public function getHopeMinute3(): ?int
    {
        return $this->hopeMinute3;
    }

    public function setHopeMinute3(?int $hopeMinute3): self
    {
        $this->hopeMinute3 = $hopeMinute3;

        return $this;
    }

    public function getHopeDate1(): ?\DateTimeInterface
    {
        return $this->hopeDate1;
    }

    public function setHopeDate1(?\DateTimeInterface $hopeDate1): self
    {
        $this->hopeDate1 = $hopeDate1;

        return $this;
    }

    public function getHopeDate2(): ?\DateTimeInterface
    {
        return $this->hopeDate2;
    }

    public function setHopeDate2(?\DateTimeInterface $hopeDate2): self
    {
        $this->hopeDate2 = $hopeDate2;

        return $this;
    }

    public function getHopeDate3(): ?\DateTimeInterface
    {
        return $this->hopeDate3;
    }

    public function setHopeDate3(?\DateTimeInterface $hopeDate3): self
    {
        $this->hopeDate3 = $hopeDate3;

        return $this;
    }
}
