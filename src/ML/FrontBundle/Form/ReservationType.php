<?php

namespace ML\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ML\FrontBundle\Form\TicketsType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Session\Session;
use ML\FrontBundle\Entity\Reservation;
use ML\FrontBundle\Entity\Countries;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ReservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstname',  TextType::class, array(
          'label'    => 'Prenom',
          'required' => true,
        ))
        ->add('lastname',    TextType::class, array(
          'label'    => 'Nom',
          'required' => true,
        ))
        ->add('reservationtype', ChoiceType::class, array(
          'choices' => array(
            'Journée Pleine' => 'journee_pleine',
            'Demi Journée' => 'demi_journee',
          ),
        ))
        ->add('dateform', DateType::class, array(
          'label'  => 'Date de reservation',
          'widget' => 'single_text',
          'input'  => 'datetime',
          'format' => 'dd/MM/yyyy',
          'attr'   => array(
            'readonly' => true,
          ),
          'required' => true,
        ))
        ->add('mail', TextType::class, array(
          'label'    => 'Adresse Mail',
          'required' => true,
        ))
        ->add('country', EntityType::class, array(
          'class'        => 'MLFrontBundle:Countries',
          'choice_label' => 'nomFrFr',
          'multiple'     => false,
          'label'        => 'Pays d\'origine',
        ))
        ->add('tickets', CollectionType::class, array(
          'entry_type'    => TicketsType::class,
          'allow_add'     => true,
          'allow_delete'  => true,
          'required'      => true,
        ))
        ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ML\FrontBundle\Entity\Reservation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ml_frontbundle_reservation';
    }


}
