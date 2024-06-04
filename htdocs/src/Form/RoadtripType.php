<?php

// src/Form/RoadtripType.php

namespace App\Form;

use App\Entity\Roadtrip;
use App\Entity\Country;
use App\Entity\Vehicle;
use App\Entity\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RoadtripType extends AbstractType
{
    //private $entityManager;

    public function __construct(/*EntityManagerInterface $entityManager*/)
    {
        // $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $fuelChoices = $this->getFuelChoices();
        // $vehicleChoices = $this->getVehicleChoices();
        // $vehicleModelChoices = $this->getVehicleModelChoices();
        // $destinationChoices = $this->getDestinationNames();
        // $typeChoices = $this->getTypeNames();

        // $builder
        //     ->add('destination', ChoiceType::class, [
        //         'choices' => $destinationChoices,
        //         'label' => 'Destination',
        //         'required' => true,
        //     ])
        //     ->add('travelers', IntegerType::class, [
        //         'label' => 'Number of Travelers',
        //     ])
        //     ->add('start_date', DateType::class, [
        //         'widget' => 'single_text',
        //         'label' => 'Start Date',
        //     ])
        //     ->add('end_date', DateType::class, [
        //         'widget' => 'single_text',
        //         'label' => 'End Date',
        //     ])
        //     ->add('rent_car', ChoiceType::class, [
        //         'choices' => [
        //             'Yes' => true,
        //             'No' => false,
        //         ],
        //         'expanded' => true,
        //         'multiple' => false,
        //         'label' => 'Do you want to rent a car?',
        //     ])
        //     ->add('vehicle_type', ChoiceType::class, [
        //         'choices' => $vehicleChoices,
        //         'label' => 'Vehicle Type',
        //         'required' => false,
        //         'attr' => ['class' => 'vehicle-type-select'],
        //     ])
        //     ->add('vehicle_fuel', ChoiceType::class, [
        //         'choices' => $fuelChoices,
        //         'label' => 'Vehicle Fuel',
        //         'required' => false,
        //     ])
        //     ->add('vehicle_model', ChoiceType::class, [
        //         'choices' => $vehicleModelChoices,
        //         'label' => 'Vehicle Model',
        //         'required' => false,
        //     ])
        //     ->add('budget', ChoiceType::class, [
        //         'choices' => [
        //             'Budget (Economy)' => 'economy',
        //             'Mid-range (Comfort)' => 'comfort',
        //             'Luxury (Premium)' => 'premium',
        //         ],
        //         'label' => 'Budget',
        //     ])
        //     ->add('distance', ChoiceType::class, [
        //         'choices' => [
        //             'Short (0-100 km/day)' => 100,
        //             'Medium (100-300 km/day)' => 300,
        //             'Long (300+ km/day)' => 500,
        //         ],
        //         'label' => 'Distance',
        //     ])
        //     ->add('type', EntityType::class, [
        //         'class' => Type::class,
        //         'choice_label' => 'name',
        //         'label' => 'Trip Preferences',
        //     ])
        //     ->add('save', SubmitType::class, [
        //         'label' => 'Generate Roadtrip',
        //     ]);
    }

    // private function getFuelChoices(): array
    // {
    //     $vehicles = $this->entityManager->getRepository(Vehicle::class)->findAll();
    //     $fuelTypes = [];

    //     foreach ($vehicles as $vehicle) {
    //         foreach ($vehicle->getFuelTypes() as $fuelType) {
    //             $fuelTypes[$fuelType] = $fuelType;
    //         }
    //     }

    //     return array_unique($fuelTypes);
    // }

    // private function getVehicleChoices(): array
    // {
    //     $vehicles = $this->entityManager->getRepository(Vehicle::class)->findAll();
    //     $vehicleChoices = [];

    //     foreach ($vehicles as $vehicle) {
    //         $vehicleLabel = $vehicle->getType();
    //         $vehicleChoices[$vehicleLabel] = $vehicle->getType();
    //     }

    //     return $vehicleChoices;
    // }

    // private function getVehicleModelChoices(): array
    // {
    //     $vehicles = $this->entityManager->getRepository(Vehicle::class)->findAll();
    //     $vehicleChoices = [];

    //     foreach ($vehicles as $vehicle) {
    //         foreach ($vehicle->getModels() as $model) {
    //             $vehicleModelChoices[$model] = $model;
    //         }
    //     }

    //     return $vehicleModelChoices;
    // }

    // private function getDestinationNames(): array
    // {
    //     $countries = $this->entityManager->getRepository(Country::class)->findAll();
    //     $countryChoices = [];

    //     foreach ($countries as $country) {
    //         $countryChoices[$country->getName()] = $country->getName();
    //     }

    //     return array_unique($countryChoices);
    // }

    // private function getTypeNames(): array
    // {
    //     $types = $this->entityManager->getRepository(Type::class)->findAll();
    //     $typeChoices = [];

    //     foreach ($types as $type) {
    //         $typeChoices[$type->getName()] = $type->getName();
    //     }

    //     return array_unique($typeChoices);
    // }

    // public function configureOptions(OptionsResolver $resolver): void
    // {
    //     $resolver->setDefaults([
    //         'data_class' => Roadtrip::class,
    //     ]);
    // }
}
