<?php


namespace App\Form;

use App\Entity\Location;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('gender', ChoiceType::class, [
//                'mapped' => false,
//                'multiple' => false,
//                'expanded' => true,
//                'choices' => [
//                    'Male' => 1,
//                    'Female' => 2,
//                    'Female & Pregnant' => 3,
//                ],
//                'label' => 'Gender',
//                'label_attr' => ['class' => 'col-sm-6']
//            ])
//            ->add('takeAsteroids', ChoiceType::class, [
//                'mapped' => false,
//                'data' => false,
//                'multiple' => false,
//                'expanded' => true,
//                'choices' => [
//                    'Yes' => true,
//                    'No' => false,
//                ],
//                'label' => 'Did you take asteroids?',
//                'label_attr' => ['class' => 'col-sm-12']
//            ])
//            ->add('takeImmunosuppressants', ChoiceType::class, [
//                'mapped' => false,
//                'data' => false,
//                'multiple' => false,
//                'expanded' => true,
//                'choices' => [
//                    'Yes' => true,
//                    'No' => false,
//                ],
//                'label' => 'Did you take immunosuppressants?',
//                'label_attr' => ['class' => 'col-sm-12']
//            ])
//            ->add('isSmoking', ChoiceType::class, [
//                'mapped' => false,
//                'data' => false,
//                'multiple' => false,
//                'expanded' => true,
//                'choices' => [
//                    'Yes' => true,
//                    'No' => false,
//                ],
//                'label' => 'Do you smoke?',
//                'label_attr' => ['class' => 'col-sm-12']
//            ])
//            ->add('workInMedicalField', ChoiceType::class, [
//                'constraints' =>  [
//                    new Assert\NotBlank(),
//                ],
//                'mapped' => false,
//                'data' => false,
//                'multiple' => false,
//                'expanded' => true,
//                'choices' => [
//                    'Yes' => true,
//                    'No' => false,
//                ],
//                'label' => 'Do you work in medical field?',
//                'label_attr' => ['class' => 'col-sm-12']
//            ])
            ->add('contact-confirmed-case', ChoiceType::class, [
                'data' => false,
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل خالطت أو زرت مكان به حالة موجبة؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('chronic-people', ChoiceType::class, [
                'mapped' => false,
                'data' => false,
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل خالطت شخص مصاب بحالة إلتهاب تنفسي حاد؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('travel-abroad', ChoiceType::class, [
                'data' => false,
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل سافرت مؤخرا خارج أو داخل مصر خصوصا في الأماكن السياحية؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('temperature', ChoiceType::class, [
                'data' => false,
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل تعاني من إرتفاع في درجة الحرارة أكثر من 38 درجة مئوية؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
//            ->add('body-check', ChoiceType::class, [
//                'constraints' =>  [
//                    new Assert\NotBlank(),
//                ],
//                'mapped' => false,
//                'data' => ['none'],
//                'multiple' => true,
//                'expanded' => true,
//                'choices' => [
//                    'Body aches' => 'body-ache',
//                    'Diarrhea' => 'diarrhea',
//                    'Headache' => 'headache',
//                    'Loses of taste' => 'no-taste',
//                    'None' => 'none'
//                ],
//                'label' => 'Choose the condition you felt today. if not, choose none',
//                'label_attr' => ['class' => 'col-sm-12']
//            ])
            ->add('cough', ChoiceType::class, [
                'data' => false,
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل يوجد سعال مستمر ومتزايد؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
//            ->add('runny-nose', ChoiceType::class, [
//                'data' => false,
//                'multiple' => false,
//                'expanded' => true,
//                'choices' => [
//                    'Yes' => true,
//                    'No' => false,
//                ],
//                'label' => 'Runny nose?',
//                'label_attr' => ['class' => 'col-sm-12']
//            ])
            ->add('sore-throat', ChoiceType::class, [
                'data' => false,
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل يوجد إحتقان شديد بالحلق؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('work-medical-field', ChoiceType::class, [
                'mapped' => false,
                'data' => false,
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل تعمل في القطاع الصحي أو العزل الصحي؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('isChronic', ChoiceType::class, [
                'data' => false,
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'نعم' => true,
                    'لا' => false,
                ],
                'label' => 'هل تعاني من مرض مزمن: سكر أو ضغط أو قلب أو كلي ..إلخ؟',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->add('age', ChoiceType::class, [
                'mapped' => false,
                'multiple' => false,
                'expanded' => true,
                'data' => 1,
                'choices' => [
                    '50 سنة أو أقل' => 1,
                    '50-60 سنة' => 2,
                    'أكثر من 60 سنة' => 3,
                ],
                'label' => 'العمر',
                'label_attr' => ['class' => 'col-sm-6']
            ])
            ->add('location', EntityType::class, [
                'mapped' => false,
                'class' => Location::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->where('l.parent is NULL');
                },
                'placeholder' => 'إختر محافظتك',
                'label' => 'إختر المحافظة',
                'label_attr' => ['class' => 'col-sm-12']
            ])
        ;
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
