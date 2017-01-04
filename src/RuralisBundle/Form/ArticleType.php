<?php

namespace RuralisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

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
                    'Une' => '1',
                    'Carré' => '2',
                    'Rectangle + lien abonnement' => '3',
                    'Rectangle + contenu' => '4',
                    'Rectangle + lien abonnemnet complet' => '5',
                ),
                'choices_as_values' => true,
            ))
            ->add('nom')
            ->add('descriptif')
            ->add('contenu', CKEditorType::class, array(
                'config' => array(
                    'config_name' => 'my_config',
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
