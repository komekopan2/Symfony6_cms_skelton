<?php
namespace App\Form\VisitReservation;

use App\Entity\VisitReservation\Inquiry;
use App\Form\Traits\InquiryTypeTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InquiryType extends AbstractType
{
    use InquiryTypeTrait;
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addRequiredTypes($builder);
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inquiry::class,
        ]);
    }
}