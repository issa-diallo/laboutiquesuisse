<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Quel nom souhaitez-vous donnez à votre adresse ?',
                'attr' => ['placeholder' => 'Nommez votre adresse']
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Votre Prenom',
                'attr' => ['placeholder' => 'Entrez votre prenom']
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'attr' => ['placeholder' => 'Entrez votre nom']
            ])
            ->add('company', TextType::class, [
                'label' => 'Votre société',
                'required' => false,
                'attr' => ['placeholder' => '(Facultatif) votre société']
            ])
            ->add('address', TextType::class, [
                'label' => 'Votre adresse',
                'attr' => ['placeholder' => '8 rue de liesses ...']
            ])
            ->add('postal', TextType::class, [
                'label' => 'Votre code postale',
                'attr' => ['placeholder' => '01210']
            ])
            ->add('city', TextType::class, [
                'label' => 'Votre ville',
                'attr' => ['placeholder' => 'Paris']
            ])
            ->add('country', CountryType::class, [
                'label' => 'Votre pays'
            ])
            ->add('phone', TelType::class, [
                'label' => 'Votre téléphone',
                'attr' => ['placeholder' => 'Entrez votre téléphone']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => ['class' => 'btn btn-block btn-info']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
