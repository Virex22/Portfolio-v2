<?php

namespace App\Form;

use App\Entity\ContactMessage;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',
                TextType::class,
                [
                    'label' => 'First Name or Company Name',
                    'attr' => [
                        'placeholder' => 'Enter your first name',
                    ],
                ]
            )
            ->add('surname',
                TextType::class,
                [
                    'label' => 'Last Name',
                    'attr' => [
                        'placeholder' => 'Enter your last name',
                    ],
                    'required' => false,
                ]
            )
            ->add('email',
                TextType::class,
                [
                    'label' => 'Email',
                    'attr' => [
                        'placeholder' => 'Enter your email',
                    ],
                ]
            )
            ->add('subject',
                TextType::class,
                [
                    'label' => 'Subject',
                    'attr' => [
                        'placeholder' => 'Enter the subject',
                    ],
                ]
            )
            ->add('message',
                TextType::class,
                [
                    'label' => 'Message',
                    'attr' => [
                        'placeholder' => 'Enter your message',
                    ],
                ]
            )
            ->add('captcha', Recaptcha3Type::class, [
                'mapped' => false,
                'constraints' => new Recaptcha3([
                    'message' => 'reCaptcha validation failed',
                    'action_name' => 'contact',
                ]),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactMessage::class,
        ]);
    }
}
