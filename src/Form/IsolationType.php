<?php

namespace App\Form;

use App\Entity\Isolation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IsolationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('temperature', NumberType::class, [
                'label' => 'درجة الحرارة',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('bloodPressure', TextType::class, [
                'label' => 'ضغط الدم (إذا كنت تعاني من مرض الضغط)',
                'label_attr' => ['class' => 'col-sm-12'],
                'required' => false
            ])
            ->add('bodyAche', ChoiceType::class, [
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل تشعر بألم في الجسم؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('diarrhea', ChoiceType::class, [
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل تعاني من إسهال؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('headache', ChoiceType::class, [
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل تعاني من صداع مستمر؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('loseOfTaste', ChoiceType::class, [
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل تشعر بفقدان في حاسة التذوق؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('dyspnea', ChoiceType::class, [
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل يوجد ضيق في التنفس؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('cough', ChoiceType::class, [
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل يوجد سعال حاد؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('soreThroat', ChoiceType::class, [
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل يوجد إحتقان في الحلق؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('runnyNose', ChoiceType::class, [
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل يوجد رشح في الأنف؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('describeYourCase', TextareaType::class, [
                'label' => 'اوصف لنا حالتك اليوم',
                'label_attr' => ['class' => 'col-sm-12'],
                'attr' => array('cols' => '10', 'rows' => '10','class' => 'col-sm-12', 'maxlength' => 400)
            ])
            ->add('createdAt', null, [
                    'attr' => ['style'=>'display:none;'],
                    'label_attr' => ['style'=>'display:none;'],
                ]
            )
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Isolation::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'isolation';
    }
}
