<?php
namespace App\Repository\VisitReservation;

use App\Entity\VisitReservation\Inquiry;
use App\Repository\Interfaces\AdminIndexInterface;
use App\Repository\Interfaces\InquiryRepositoryInterface;
use App\Repository\Traits\InquiryRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class InquiryRepository extends ServiceEntityRepository implements InquiryRepositoryInterface, AdminIndexInterface
{
    use InquiryRepositoryTrait;
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inquiry::class);
    }
    
    public function add(Inquiry $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    
    public function remove(Inquiry $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    
    public function getAdminIndexQuery(array $criteria): QueryBuilder
    {
        $qb = $this->createQueryBuilder("c");
        $this->addInquiryAdminIndexQuery($qb, $criteria);
        return $qb;
    }
}