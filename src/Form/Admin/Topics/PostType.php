<?php

namespace App\Form\Admin\Topics;

use App\Entity\Topics\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('postAt', DateType::class, [
                "label" => "投稿日",
                "widget" => "single_text",
                "constraints" => [
                    new NotBlank([
                        "message" => "未入力です"
                    ])
                ]
            ])
            ->add('title', TextType::class, [
                "label" => "タイトル",
                "constraints" => [
                    new NotBlank([
                        "message" => "未入力です"
                    ])
                ]
            ])
            ->add('url', UrlType::class, [
                "label" => "リンクURL",
                "constraints" => [
                    new NotBlank([
                        "message" => "未入力です"
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
