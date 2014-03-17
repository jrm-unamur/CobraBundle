<?php
/**
 * Created by PhpStorm.
 * User: jmeuriss
 * Date: 14/03/14
 * Time: 10:36
 */

namespace Unamur\CobraBundle\Form;

use Unamur\CobraBundle\Entity\CobraViewer;
use Claroline\CoreBundle\Entity\Resource\AbstractResource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CobraConfigDisplayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('show_media_player', 'checkbox', array(
                'required' => false,
            ))
            ->add('display_inflected_forms', 'checkbox', array(
                'required' => false,
            ))
            ->add('translations_display_mode', 'choice', array(
                'choices'       => array("always" => "always", "never" => "never", "conditional" => "conditional"),
                'required'      => true,
                'theme_options' => array('control_width' => 'col-md-2'),
            ))
            ->add('descriptions_display_mode', 'choice', array(
                'choices'       => array("always" => "always", "never" => "never", "conditional" => "conditional"),
                'required'      => true,
                'theme_options' => array('control_width' => 'col-md-2'),
            ))
            ->add('examples_display_mode', 'choice', array(
                'choices'       => array("bi-text" => "bilingual", "mono" => "monolingual"),
                'required'      => true,
                'theme_options' => array('control_width' => 'col-md-2'),
            ))
            ->add('display_illustrations', 'checkbox', array(
                'required' => false,
            ))
            ->add('display_occurrences', 'checkbox', array(
                'required' => false,
            ))
        ;
    }

    public function getName()
    {
        return 'unamur_cobra_config_display_form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'unamur_cobra',
            'data_class' => 'Unamur\CobraBundle\Entity\CobraViewer',
            'csrf_protection' => true,
            'intention' => 'configure_cobra_display'
        ));
    }
} 