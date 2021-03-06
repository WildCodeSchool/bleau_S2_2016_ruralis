<?php

//Theme Name: Ruralis
//Authors: Marielle Lautrou and Aurore David


namespace RuralisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeAffichage', ChoiceType::class, array (
                'placeholder' => "",
                'choices' => array (
                    'Une' => 'Une',
                    'Carré' => 'Carré',
                    'Rectangle + lien abonnement' => 'Rectangle + lien abonnement',
                    'Rectangle + descriptif' => 'Rectangle + descriptif',
                    'Rectangle + article complet' => 'Rectangle + article complet',
                ),
                'choices_as_values' => true,
            ))
            ->add('nom')
            ->add('descriptif')
            ->add('contenu', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff')))
            ->add('auteur')
            ->add('image', ImageType::class)
           ;
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
