<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\User;
use App\Entity\Prospect;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProspectAffectType extends AbstractType
{


    public function __construct(private UserRepository $userRepository, private Security $security)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('team')
            ->add('comrcl');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prospect::class,

        ]);
    }
}
