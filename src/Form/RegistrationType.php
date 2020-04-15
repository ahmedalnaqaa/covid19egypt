<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'الإسم بالكامل'
            ])
            ->add('birthDate', BirthdayType::class, [
                'label' => 'تاريخ الميلاد'
            ])
            ->add('isChronic', ChoiceType::class, [
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل تعاني من مرض مزمن: سكر أو ضغط أو قلب أو كلي ..إلخ؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('isFamilyChronic', ChoiceType::class, [
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل يوجد أحد في عائلتك يعاني من مرض مزمن أو تعيش مع كبار سن أو حوامل؟',
                'label_attr' => ['class' => 'col-sm-11']
            ])
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'user_registration';
    }
}
