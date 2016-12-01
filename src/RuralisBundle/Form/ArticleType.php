<?php

namespace RuralisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeAffichage', EntityType::class, array(
                'class' => 'RuralisBundle:TypeAffichage',
                'choice_label' => 'nom',
                'placeholder' => 'Selectionnez un type',
                'required' => true
            ))

            ->add('nom')
            ->add('descriptif')
            ->add('contenu')
            ->add('auteur')
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
                'input' => 'datetime',
                // do not render as type="date", to avoid HTML5 date pickers
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                // add a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
            ))
            ->add('image', FileType::class, array(
        'label' => 'image à télécharger : ',
        'data_class' => null
    ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RuralisBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ruralisbundle_article';
    }


}
