<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;

class EvenementFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('titre',TextType::class,array('attr'=>array('class'=>'form-control')))
            ->add('emplacement',TextType::class,array('attr'=>array('class'=>'form-control')))
            ->add('prix',TextType::class,array('attr'=>array('class'=>'form-control')))
            ->add('dateEvent',TextType::class,array('attr'=>array('class'=>'form-control')))
            ->add('imageFile',FileType::class,[
                'required'=>false
            ])
            ->add('fondation',TextType::class,array('attr'=>array('class'=>'form-control')))
            ->add('nbmaxparticipants',TextType::class,array('attr'=>array('class'=>'form-control')))
            ->add('duree',TextType::class,array('attr'=>array('class'=>'form-control')))
            ->add('Ajouter',SubmitType::class,array(

                'attr' => array('class' => 'btn btn-success my-3')))
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptcha'
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
