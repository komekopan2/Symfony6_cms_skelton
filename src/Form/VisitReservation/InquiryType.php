<?php

namespace App\Form\VisitReservation;

use App\Entity\VisitReservation\Inquiry;
use App\Form\Traits\InquiryTypeTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class InquiryType extends AbstractType
{
    use InquiryTypeTrait;
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addRequiredTypes($builder);
        $builder
            ->add('nameSei', TextType::class, [
                "label" => "お名前",
                "constraints" => [
                    new NotBlank([
                        "message" => "姓が未入力です"
                    ]),
                    new Length([
                        "max" => 48,
                        "maxMessage" => "姓が文字数オーバーです"
                    ])
                ]
            ])
            ->add('nameMei', TextType::class, [
                "label" => "お名前",
                "constraints" => [
                    new NotBlank([
                        "message" => "名が未入力です"
                    ]),
                    new Length([
                        "max" => 48,
                        "maxMessage" => "名が文字数オーバーです"
                    ])
                ]
            ])
            ->add('phone', TelType::class, [
                "label" => "電話番号",
                "constraints" => [
                    new NotBlank([
                        "message" => "電話番号が未入力です"
                    ]),
                    new Length([
                        "max" => 32,
                        "maxMessage" => "文字数オーバーです"
                    ])
                ]
            ]);
        $this
            ->addHope($builder, 1)
            ->addHope($builder, 2)
            ->addHope($builder, 3);
    }

    private function addHope(FormBuilderInterface $builder, int $number): self
    {
        $hours = range(10, 21);
        $minute = ["00", "30"];
        $builder
            ->add("hopeDate{$number}", DateType::class, [
                "label" => "第{$number}ご希望日程",
                "constraints" => [
                    new NotBlank([
                        "message" => "日付が選択されていません"
                    ])
                ],
                "widget" => "single_text"
            ])
            ->add("hopeHour{$number}", ChoiceType::class, [
                "label" => "時間",
                "choices" => array_combine($hours, $hours),
                "placeholder" => "時間",
                "constraints" => [
                    new NotBlank([
                        "message" => "時間が選択されていません"
                    ])
                ]
            ])
            ->add("hopeMinute{$number}", ChoiceType::class, [
                "label" => "分",
                "choices" => array_combine($minute, $minute),
                "placeholder" => "選択",
                "constraints" => [
                    new NotBlank([
                        "message" => "分が選択されていません"
                    ])
                ]
            ]);
        return $this;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inquiry::class,
        ]);
    }
}
