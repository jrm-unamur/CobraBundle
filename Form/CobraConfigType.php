<?php
/**
 * Created by PhpStorm.
 * User: jmeuriss
 * Date: 4/03/14
 * Time: 11:05
 */

namespace JrmUnamur\CobraBundle\Form;

use JrmUnamur\CobraBundle\Entity\CobraViewer;
use Claroline\CoreBundle\Entity\Resource\AbstractResource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CobraConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name', 'text', array(
                'label' => 'name'
            ))
            ->add(
            'language', 'text', array(
                'label' => 'langue',
                'read_only' => true
            ))
            ->add('display_gender', 'checkbox', array(
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
           /* ))

            ->add('corpus_display_order', 'checkbox', array(
                'required' => false,
            ))
            ->add('show_media_player', 'checkbox', array(
                'required' => false,*/
            ))
        ;
    }

    public function getName()
    {
        return 'unamur_cobra_config_form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'unamur_cobra',
            'data_class' => 'JrmUnamur\CobraBundle\Entity\CobraViewer',
            'csrf_protection' => true,
            'intention' => 'configure_cobra'
        ));
    }
} 