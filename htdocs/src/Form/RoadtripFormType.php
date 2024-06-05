<?php

namespace App\Form;

use App\Entity\Roadtrip;
use App\Entity\Country;
use App\Entity\Vehicle;
use App\Entity\RoadtripType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
                'label' => 'Country',
                'required' => true,
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
            ->add('vehicle', EntityType::class, [
                'class' => Vehicle::class,
                'choice_label' => 'vehicle_type',
                'label' => 'Vehicle',
                'required' => false,
            ])
            ->add('cost_preferences', ChoiceType::class, [
                'choices' => [
                    'Budget (Economy)' => Roadtrip::COST_LOW,
                    'Mid-range (Comfort)' => Roadtrip::COST_MODERATE,
                    'Luxury (Premium)' => Roadtrip::COST_HIGH,
                ],
                'label' => 'Budget',
            ])
            ->add('distance', ChoiceType::class, [
                'choices' => [
                    'Short (0-100 km/day)' => Roadtrip::DISTANCE_SHORT,
                    'Medium (100-300 km/day)' => Roadtrip::DISTANCE_MEDIUM,
                    'Long (300+ km/day)' => Roadtrip::DISTANCE_LONG,
                ],
                'label' => 'Distance',
            ])
            ->add('roadtrip_types', EntityType::class, [
                'class' => RoadtripType::class,
                'choice_label' => 'name',
                'label' => 'Trip Preferences',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Generate Roadtrip',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Roadtrip::class,
        ]);
    }

    private function getFuelChoices(): array
    {
        $vehicles = $this->entityManager->getRepository(Vehicle::class)->findAll();
        $fuelChoices = [];

        foreach ($vehicles as $vehicle) {
            foreach ($vehicle->getFuelTypes() as $fuelType) {
                $fuelChoices[$fuelType] = $fuelType;
            }
        }

        return $fuelChoices;
    }

    private function getModelChoices(): array
    {
        $vehicles = $this->entityManager->getRepository(Vehicle::class)->findAll();
        $modelChoices = [];

        foreach ($vehicles as $vehicle) {
            foreach ($vehicle->getModels() as $model) {
                $modelChoices[$model] = $model;
            }
        }

        return $modelChoices;
    }
}
