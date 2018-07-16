<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use AppBundle\Entity\Produit;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CommandeType extends AbstractType
{
    private $translator;
    private $container;
    public function __construct(TranslatorInterface $translator,ContainerInterface $container) {
        $this->translator = $translator;
        $this->container = $container;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();
        $formValidator = function (FormEvent $event) use ($entity,$options){
            $form = $event->getForm();
            $produits = $form->get('produit')->getData();
            (empty($produits->toArray()))?$form['produit']->addError(new FormError($this->translator->trans('form.errors.empty', array(), 'FOSUserBundle'))):null;
            
            $overStock = $this->verifyStock($produits->toArray(),$options['data']);
            if($overStock != ''){
                $form['produit']->addError(new FormError($overStock));
            }
            
            $entity->setSomme($this->calculateSomme($produits->toArray()));
            $entity->setUser($this->container->get('security.token_storage')->getToken()->getUser());
        };
        $builder->add('produit',EntityType::class,array(
                    'class'=>Produit::class,
                    'choice_label'=>'titre',
                    'expanded' => true,
                    'multiple' => true))
                ->addEventListener(FormEvents::SUBMIT, $formValidator);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Commande'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_commande';
    }
    
    public function calculateSomme($produits){
        $somme = 0;
        foreach($produits as $produit){
            $somme+= $produit->getPrixTtc();
        }
        return $somme;
    }
    public function verifyStock($produits,$inBddproduits){
        $idsProduit = [];
        foreach($inBddproduits as $inBddCommandeProduit){
            $idsProduit[] = $inBddCommandeProduit->getId();
        }
        $error = '';
        foreach ($produits as $product){
            if(!in_array($product->getId(),$idsProduit) && $product->getStock() < 1){
                $error = 'plus de stock pour '.$product->getTitre();
            }
        }
        return $error;
    }

}
