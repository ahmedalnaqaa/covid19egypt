<?php

namespace App\Form;

use App\Entity\Location;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ->add('phoneNumber', TextType::class, [
                'label' => 'رقم الهاتف'
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
            ->add('symptomsStartSince', ChoiceType::class, [
                'mapped' =>false,
                'required' => true,
                'choices' => [
                    'يوم' => 1,
                    'يومين' => 2,
                    '3 أيام' => 3,
                    '4 أيام' => 4,
                    '5 أيام' => 5,
                    '6 أيام' => 6,
                    '7 أيام' => 7,
                    '8 أيام' => 8,
                    '9 أيام' => 9,
                    '10 أيام' => 10,
                    '11 يوم' => 11,
                    '12 يوم' => 12,
                    '13 يوم' => 13,
                    '14 يوم' => 14,
                ],
                'label' => 'بداية ظهور الأعراض',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('test', HiddenType::class, [
                'mapped' => false
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
