<?php

namespace App\Form;

use App\Entity\Roadtrip;
use App\Entity\Country;
use App\Entity\Vehicle;
use App\Entity\City;
use App\Entity\RoadtripType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\EntityManagerInterface;

class RoadtripFormType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('starting_point', EntityType::class, [
                'class' => City::class,
                'choice_label' => function (City $city) {
                    return $city->getCountry()->getName() . ' - ' . $city->getName();
                },
                'group_by' => function (City $city) {
                    return $city->getCountry()->getName();
                },
                'label' => 'Starting Point',
                'required' => true,
                'placeholder' => 'Choose your starting area',
                'constraints' => [
                    new NotBlank(['message' => 'Starting point is required']),
                ],
            ])

            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
                'label' => 'Destination Country',
                'required' => true,
                'placeholder' => 'Which country will you explore?',
                'constraints' => [
                    new NotBlank(['message' => 'Destination country is required']),
                ],
            ])

            ->add('travelers', IntegerType::class, [
                'label' => 'Travel Crew',
                'attr' => ['placeholder' => 'How many are joining?'],
                'constraints' => [
                    new NotBlank(['message' => 'Number of travelers is required']),
                    new GreaterThanOrEqual(['value' => 1, 'message' => 'The number of travelers must be at least 1']),
                ],
            ])

            ->add('start_date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Start Date',
                'attr' => ['placeholder' => 'When does the fun start?'],
                'constraints' => [
                    new NotBlank(['message' => 'Start date is required']),
                ],
            ])

            ->add('end_date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'End Date',
                'attr' => ['placeholder' => 'When does the fun end?'],
                'constraints' => [
                    new NotBlank(['message' => 'End date is required']),
                    new Callback([$this, 'validateDates']),
                ],
            ])

            ->add('start_from_home', ChoiceType::class, [
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Do you want to start from home?',
            ])

            ->add('rent_car', ChoiceType::class, [
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Need a Rental Car?',
            ])

            ->add('vehicle', EntityType::class, [
                'class' => Vehicle::class,
                'choice_label' => 'vehicle_type',
                'label' => 'Select Your Ride',
                'placeholder' => 'Choose your vehicle',
                'required' => false,
            ])

            ->add('cost_preferences', ChoiceType::class, [
                'choices' => [
                    'Budget (Economy)' => Roadtrip::COST_LOW,
                    'Mid-range (Comfort)' => Roadtrip::COST_MODERATE,
                    'Luxury (Premium)' => Roadtrip::COST_HIGH,
                ],
                'label' => 'Trip Budget',
                'placeholder' => 'What\'s your spending style?',
            ])

            ->add('distance', ChoiceType::class, [
                'choices' => [
                    'Short (0-100 km/day)' => Roadtrip::DISTANCE_SHORT,
                    'Medium (100-300 km/day)' => Roadtrip::DISTANCE_MEDIUM,
                    'Long (300+ km/day)' => Roadtrip::DISTANCE_LONG,
                ],
                'label' => 'Distance',
                'placeholder' => 'How far will you travel each day?',
            ])

            ->add('roadtrip_types', EntityType::class, [
                'class' => RoadtripType::class,
                'choice_label' => 'name',
                'label' => 'Trip Preferences',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('save', SubmitType::class, [
                'label' => 'Start the Adventure!',
            ]);
    }

    public function validateDates($object, ExecutionContextInterface $context): void
    {
        $formData = $context->getRoot()->getData();
        $startDate = $formData->getStartDate();
        $endDate = $formData->getEndDate();
        
        if ($startDate && $endDate) {
            $now = new \DateTime();
            $now->setTime(0, 0, 0);
            if ($startDate < $now || $endDate < $now) {
                $context->buildViolation('The date cannot be in the past.')
                    ->atPath('start_date')
                    ->addViolation();
            }

            $diff = $endDate->diff($startDate)->days;
            if ($diff > 7) {
                $context->buildViolation('The road trip cannot be longer than 7 days.')
                    ->atPath('end_date')
                    ->addViolation();
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Roadtrip::class,
        ]);
    }
}

