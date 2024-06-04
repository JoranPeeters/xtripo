<?php

// src/Form/RoadtripType.php

namespace App\Form;

use App\Entity\Roadtrip;
use App\Entity\Country;
use App\Entity\Vehicle;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;

class RoadtripType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $fuelChoices = $this->getFuelChoices();
        $vehicleChoices = $this->getVehicleChoices();
        
        $builder
            ->add('destination', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
                'label' => 'Destination',
            ])
            ->add('travelers', IntegerType::class, [
                'label' => 'Number of Travelers',
            ])
            ->add('start_date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Start Date',
            ])
            ->add('end_date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'End Date',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('rent_car', ChoiceType::class, [
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Do you want to rent a car?',
            ])
            ->add('car_type', ChoiceType::class, [
                'choices' => $vehicleChoices,
                'label' => 'Car Type',
                'required' => false,
            ])
            ->add('car_fuel', ChoiceType::class, [
                'choices' => $fuelChoices,
                'label' => 'Car Fuel',
                'required' => false,
            ])
            ->add('budget', ChoiceType::class, [
                'choices' => [
                    'Budget (Economy)' => 'economy',
                    'Mid-range (Comfort)' => 'comfort',
                    'Luxury (Premium)' => 'premium',
                ],
                'label' => 'Budget',
            ])
            ->add('distance', ChoiceType::class, [
                'choices' => [
                    'Short (0-100 km/day)' => 'short',
                    'Medium (100-300 km/day)' => 'medium',
                    'Long (300+ km/day)' => 'long',
                ],
                'label' => 'Distance',
            ])
            ->add('trip_preferences', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'name',
                'label' => 'Trip Preferences',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Generate Roadtrip',
            ]);
    }

    private function getFuelChoices(): array
    {
        $vehicles = $this->entityManager->getRepository(Vehicle::class)->findAll();
        $fuelTypes = [];

        foreach ($vehicles as $vehicle) {
            foreach ($vehicle->getFuelTypes() as $fuelType) {
                $fuelTypes[$fuelType] = $fuelType;
            }
        }

        return array_unique($fuelTypes);
    }

    private function getVehicleChoices(): array
    {
        $vehicles = $this->entityManager->getRepository(Vehicle::class)->findAll();
        $vehicleChoices = [];

        foreach ($vehicles as $vehicle) {
            $vehicleLabel = $vehicle->getType() . ' (' . implode(', ', $vehicle->getFuelTypes()) . ')';
            $vehicleChoices[$vehicleLabel] = $vehicle->getId();
        }

        return $vehicleChoices;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Roadtrip::class,
        ]);
    }
}

