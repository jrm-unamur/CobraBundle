<?php
/**
 * Created by PhpStorm.
 * User: jmeuriss
 * Date: 27/02/14
 * Time: 9:32
 */

namespace JrmUnamur\CobraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CobraViewerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name', 'text', array(
                    'label' => 'name'
                )
            )
            ->add(
                'language', 'choice', array(
                    'label' => 'language',
                    'choices' => array(
                        'EN' => 'English',
                        'NL' => 'Dutch'
                    )
                )
            );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'unamur_cobra',
            'data_class' => 'JrmUnamur\CobraBundle\Entity\CobraViewer',
            'csrf_protection' => true
        ));
    }

    public function getName()
    {
        return 'unamur_cobra_cobraviewertype';
    }
} 