<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Genre;
use AppBundle\Entity\Types;
use AppBundle\Entity\Fournisseur;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Persistence\ObjectManager;

class ProduitType extends AbstractType
{
    private $manager;
    private $translator;
    public function __construct(ObjectManager $manager,TranslatorInterface $translator) {
        $this->manager = $manager;
        $this->translator = $translator;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();
        $formValidator = function (FormEvent $event) use ($entity){
            $form = $event->getForm();
            $titre = $form->get('titre')->getData();
            $exist = $this->manager->getRepository('AppBundle:Produit')->findOneByTitre($titre);
            if($exist){
                ($entity->getId() != $exist->getId())?$form['titre']->addError(new FormError($this->translator->trans('form.errors.unique', array(), 'FOSUserBundle'))):null;
            }
        };
        
        $builder->add('titre',null,array(
                    'attr' => array('class' => 'form-control')))
                ->add('description',null,array(
                    'attr' => array('class' => 'form-control')))
                ->add('stock',null,array(
                    'attr' => array('class' => 'form-control')))
                ->add('prixTtc',null,array(
                    'attr' => array('class' => 'form-control')))
                ->add('genre',EntityType::class,array(
                    'class'=>Genre::class,
                    'choice_label'=>'libelle',
                    'attr' => array('class' => 'form-control')))
                ->add('types',EntityType::class,array(
                    'class'=>Types::class,
                    'choice_label'=>'libelle',
                    'attr' => array('class' => 'form-control')))
                ->add('fournisseur',EntityType::class,array(
                    'class'=>Fournisseur::class,
                    'choice_label'=>'marque',
                    'attr' => array('class' => 'form-control')))
                ->addEventListener(FormEvents::SUBMIT, $formValidator);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_produit';
    }


}
