<?php
/**
 * Created by PhpStorm.
 * User: jmeuriss
 * Date: 4/03/14
 * Time: 11:05
 */

namespace Unamur\CobraBundle\Form;

use Unamur\CobraBundle\Entity\CobraViewer;
use Claroline\CoreBundle\Entity\Resource\AbstractResource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CobraConfigMainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
            'name', 'text', array(
                'label' => 'name'
            ))
            ->add(
            'language', 'text', array(
                'label' => 'langue',
                'read_only' => true
            ))
        ;
    }

    public function getName()
    {
        return 'unamur_cobra_config_main_form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'unamur_cobra',
            'data_class' => 'Unamur\CobraBundle\Entity\CobraViewer',
            'csrf_protection' => true,
            'intention' => 'configure_cobra_main'
        ));
    }
} 