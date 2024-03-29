<?php

namespace App\Form;

use App\Entity\ContactMessage;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',
                TextType::class,
                [
                    'label' => new TranslatableMessage('type.name.label', [], 'contact'),
                    'attr' => [
                        'placeholder' => new TranslatableMessage('type.name.placeholder', [], 'contact'),
                    ],
                ]
            )
            ->add('surname',
                TextType::class,
                [
                    'label' => new TranslatableMessage('type.surname.label', [], 'contact'),
                    'attr' => [
                        'placeholder' => new TranslatableMessage('type.surname.placeholder', [], 'contact'),
                    ],
                    'required' => false,
                ]
            )
            ->add('email',
                TextType::class,
                [
                    'label' => new TranslatableMessage('type.email.label', [], 'contact'),
                    'attr' => [
                        'placeholder' => new TranslatableMessage('type.email.placeholder', [], 'contact'),
                    ],
                ]
            )
            ->add('subject',
                TextType::class,
                [
                    'label' => new TranslatableMessage('type.subject.label', [], 'contact'),
                    'attr' => [
                        'placeholder' => new TranslatableMessage('type.subject.placeholder', [], 'contact'),
                    ],
                ]
            )
            ->add('message',
                TextareaType::class,
                [
                    'label' => new TranslatableMessage('type.message.label', [], 'contact'),
                    'attr' => [
                        'placeholder' => new TranslatableMessage('type.message.placeholder', [], 'contact'),
                    ],
                ]
            )
            ->add('captcha', Recaptcha3Type::class, [
                'mapped' => false,
                'constraints' => new Recaptcha3([]),
            ])
            ->add('submit',
                SubmitType::class,
                [
                    'label' => new TranslatableMessage('type.submit.label', [], 'contact'),
                    'attr' => [
                        'class' => 'btn btn-primary',
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactMessage::class,
        ]);
    }
}
