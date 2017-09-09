<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type as FormTypes;

class BlogPostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('title', FormTypes\TextType::class)
            ->add('description', FormTypes\TextareaType::class, [
                'required' => true,
            ])
            ->add('text', FormTypes\TextareaType::class, [
                'label' => 'Body',
                'required' => true,
            ])
            ->add('sendForm', FormTypes\SubmitType::class, [
                'label' => 'Publish',
                'attr' => [
                    'class' => 'btn-success'
                ]
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\BlogPost'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_blogpost';
    }


}
