<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\User;
use Type\IntegerType;
use App\Entity\Prospect;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class ProspectType extends AbstractType
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', Type\TextType::class, [
                'label' => 'Nom *',
                'attr' => [

                    'placeholder' => 'Tapez le Nom du Client'
                ],
                'required' => false,
                // 'constraints' => new NotBlank(['message' => 'ne peut pas etre vide'])
            ])
            ->add('lastname', Type\TextType::class, [
                'label' => 'Prenom *',
                'attr' => [

                    'placeholder' => 'Tapez le Prénom du Client'
                ],
                'required' => false,

            ])
            ->add('phone', Type\TelType::class, [
                'label' => 'Téléphone 1 *',
                'required' => true,
                'constraints' => new Length([
                    'min' => 10,  'minMessage' => '  
                    le numéro de téléphone doit composer des 10 chiffres y a compris le 0 ',
                    'max' => 10, 'maxMessage' => '  
                    le numéro de téléphone doit composer des 10 chiffres y a compris le 0 '
                ]),

                'attr' => [
                    'placeholder' => 'Merci de saisir le numéro de téléphone'
                ]
            ])
            ->add('email', Type\EmailType::class, [
                'label' => 'Email *',
                'required' => true,
                'attr' => [
                    'placeholder' => "Merci de saisir l'adresse email"
                ]
            ])
            ->add('gender', Type\ChoiceType::class, [
                'label' => 'Genre',
                'required' => false,
                'placeholder' => '--Merci de Choisir le genre--',
                'choices' => [
                    'Male' => 1,
                    'Female' => 0
                ],
                'expanded' => false,
                'multiple' => false
            ])
            ->add('city', Type\TextType::class, [
                'label' => 'Ville ',
                'attr' => [
                    'placeholder' => 'Ville du client',
                ]
            ])
            ->add('adress', Type\TextareaType::class, [
                'label' => 'Address complét *',

                'attr' => [
                    'placeholder' => 'Address compltét du client',
                ]
            ])
            ->add('brithAt', BirthdayType::class, [
                'label' => 'Date de Naissance *',
                'widget' => 'single_text'
            ])
            ->add('source', Type\ChoiceType::class, [
                'label' => 'Source *',
                'required' => false,
                'placeholder' => '--Merci de selectie-- ',
                'choices' => [
                    'Propre site' => 'Propre site',
                    'Saisie manuelle' => 'Saisie manuelle',
                    'Revendeur' => 'Revendeur',
                ],
                'expanded' => false,
                'multiple' => false
            ])
            ->add('motifSaise', Type\ChoiceType::class, [
                'label' => 'Motive de saisier ',
                'required' => false,
                'placeholder' => '--Merci de selectie-- ',
                'choices' => [
                    'Parrainage' => '1',
                    'Appel Entrant' => '2',
                    'Avenant' => '3',
                    'Ancienne contrat' => '4',
                ],
                'expanded' => false,
                'multiple' => false
            ])
            ->add('typeProspect', Type\ChoiceType::class, [
                'label' => 'Type Pospect *',
                'required' => false,
                'placeholder' => '--Merci de selectie-- ',
                'choices' => [
                    'Particuliers' =>  'Particuliers',
                    'Professionnels' => 'Professionnels',
                ],
                'expanded' => false,
                'multiple' => false
            ])
            ->add('raisonSociale', TextType::class, [
                'label' => 'Raison sociale ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Raison sociale',
                ]
            ])
            ->add('codePost', Type\IntegerType::class, [
                'label' => 'Code Postal *',
                'constraints' => new Length(['min' => 4,  'minMessage' => 'le code postale doit etre quatre caactaire mini', 'max' => 5, 'maxMessage' => 'le code postale doite etre 5 caractaire max']),
                'attr' => [
                    'placeholder' => 'Merci de saisir le Code Postal',
                ]
            ])
            ->add('gsm', Type\TelType::class, [
                'label' => 'Téléphone ',
                'required' => false,
                'constraints' => new Length([
                    'min' => 10,  'minMessage' => '  
                    le numéro de téléphone doit composer des 10 chiffres y a compris le 0 ',
                    'max' => 10, 'maxMessage' => '  
                    le numéro de téléphone doit composer des 10 chiffres y a compris le 0 '
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir si la deuxieme numéro de téléphone'
                ]
            ])
            ->add('assure', Type\ChoiceType::class, [
                'label' => 'Assuré actuellement *',
                'required' => false,
                'placeholder' => '--Merci de selectie-- ',
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ],
                'expanded' => false,
                'multiple' => false
            ])
            ->add('lastAssure', Type\ChoiceType::class, [
                'label' => 'Ancienne assurance résilié *',
                'required' => false,
                'placeholder' => '--Merci de selectie-- ',
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ],
                'expanded' => false,
                'multiple' => false
            ])
            ->add(
                'motifResil',
                Type\ChoiceType::class,
                [
                    'label' => 'Motif résiliation ',
                    'required' => false,
                    'placeholder' => '--Merci de selectie-- ',
                    'choices' => [
                        'Aggravation de risque' =>  1,
                        'Amiable' =>  2,
                        'Échéance' => 3,
                        'Non-paiement' => 4,
                        'Sinistre' =>  5
                    ],
                    'expanded' => false,
                    'multiple' => false
                ]
            )

            ->add('team', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => '--Choose a Team--',
                'query_builder' => fn (TeamRepository $teamRepository) =>
                $teamRepository->findAllTeamByAscNameQueryBuilder()
            ]);
        // ->add('relanceds');


        $formModifier = function (FormInterface $form, Team $team = null) {

            $comrcl = $team === null ? [] : $this->userRepository->findComrclByteamOrderedByAscName($team);
            //dd(team); //null
            //dd( $comrcl); //[]
            $form->add('comrcl', EntityType::class, [
                'class' => User::class,
                'required' => false,
                'choice_label' => 'username',
                // 'disabled' => $team === null,
                'placeholder' => '--Choose a Comercial--',
                'choices' => $comrcl
            ]);
        };


        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier, $options) {
                $data = $event->getData();
                //dd($data);
                $formModifier($event->getForm(), $data->getTeam());
                if ($options['editing'] === false) {

                    $formModifier($event->getForm(), $data->getTeam());
                }
            }
        );



        $builder->get('team')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $team = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $team);
            }
        );

        //pour reformater le numero nationnal
        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) {
                $prospect = $event->getData();
                $phone = $prospect->getPhone(); // Récupération du numéro de téléphone
                $gsm = $prospect->getGsm(); // Récupération du numéro de GSM

                // Convertir le numéro de téléphone si nécessaire
                if ($phone !== null && $phone !== '') {
                    $formattedPhone = $this->convertPhoneNumberToInternational($phone);
                    if ($formattedPhone !== null && $formattedPhone !== '') {
                        $prospect->setPhone($formattedPhone);
                    }
                }

                // Convertir le numéro de GSM si nécessaire
                if ($gsm !== null && $gsm !== '') {
                    $formattedGsm = $this->convertPhoneNumberToInternational($gsm);
                    if ($formattedGsm !== null && $formattedGsm !== '') {
                        $prospect->setGsm($formattedGsm);
                    }
                }
            }
        );



        if ($options['editing']) {
            $builder->remove('motifResil')
                ->remove('assure')
                ->remove('lastAssure')
                ->remove('gsm')
                ->remove('raisonSociale')
                ->remove('typeProspect')
                ->remove('source')
                ->remove('brithAt')
                ->remove('adress')
                ->remove('city')
                ->remove('gender')
                ->remove('email')
                ->remove('gender')
                ->remove('phone')
                ->remove('lastname')
                ->remove('motifSaise')
                ->remove('codePost')
                // ->remove('comrcl')
                ->remove('name');
        }
    }

    //     public function buildView(FormView $view, FormInterface $form, array $options)
    // {
    //     parent::buildView($view, $form, $options);

    //     $view->vars['comrcl'] = $form->get('comrcl')->createView();
    // }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prospect::class,
            'editing' => false,

        ]);
    }

    private function convertPhoneNumberToInternational($phoneNumber)
    {
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        // Vérifier la longueur du numéro pour s'assurer qu'il est valide
        if (strlen($phoneNumber) === 10) {
            // Vérifier s'il commence par '0' (format local)
            if (substr($phoneNumber, 0, 1) === '0') {
                // Remplacer le '0' par '33' pour obtenir le format international
                return '33' . substr($phoneNumber, 1);
            }
        }
    }
}
