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
                'label' => 'form.starting_point.label',
                'required' => true,
                'placeholder' => 'form.roadtrip.starting_point.placeholder',
                'constraints' => [
                    new NotBlank(['message' => 'form.starting_point.error']),
                ],
            ])

            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
                'label' => 'form.croadtrip.country.label',
                'required' => true,
                'placeholder' => 'form.roadtrip.country.placeholder',
                'constraints' => [
                    new NotBlank(['message' => 'form.croadtrip.country.error']),
                ],
            ])

            ->add('travelers', IntegerType::class, [
                'label' => 'form.roadtrip.travelers.label',
                'attr' => ['placeholder' => 'form.roadtrip.travelers.placeholder'],
                'constraints' => [
                    new NotBlank(['message' => 'form.roadtrip.travelers.error_1']),
                    new GreaterThanOrEqual(['value' => 1, 'message' => 'form.roadtrip.travelers.error_2']),
                ],
            ])

            ->add('start_date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'form.roadtrip.start_date.label',
                'attr' => ['placeholder' => 'form.roadtrip.start_date.placeholder'],
                'constraints' => [
                    new NotBlank(['message' => 'form.roadtrip.start_date.error']),
                ],
            ])

            ->add('end_date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'form.roadtrip.end_date.label',
                'attr' => ['placeholder' => 'form.roadtrip.end_date.placeholder'],
                'constraints' => [
                    new NotBlank(['message' => 'form.roadtrip.end_date.error_1']),
                    new Callback([$this, 'validateDates']),
                ],
            ])

            ->add('start_from_home', ChoiceType::class, [
                'choices' => [
                    'form.roadtrip.start_from_home.yes' => true,
                    'form.roadtrip.start_from_home.no' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'form.roadtrip.start_from_home.label',
            ])

            ->add('rent_car', ChoiceType::class, [
                'choices' => [
                    'form.roadtrip.rent_car.yes' => true,
                    'form.roadtrip.rent_car.no' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'form.roadtrip.rent_car.label',
            ])

            ->add('vehicle', EntityType::class, [
                'class' => Vehicle::class,
                'choice_label' => 'vehicle_type',
                'label' => 'form.roadtrip.vehicle.label',
                'placeholder' => 'form.roadtrip.vehicle.placeholder',
            ])

            ->add('cost_preferences', ChoiceType::class, [
                'choices' => [
                    'form.roadtrip.cost_preferences.low' => Roadtrip::COST_LOW,
                    'form.roadtrip.cost_preferences.medium' => Roadtrip::COST_MODERATE,
                    'form.roadtrip.cost_preferences.high' => Roadtrip::COST_HIGH,
                ],
                'label' => 'form.roadtrip.cost_preferences.label',
                'placeholder' => 'form.roadtrip.cost_preferences.placeholder',
            ])

            ->add('distance', ChoiceType::class, [
                'choices' => [
                    'form.roadtrip.distance.short' => Roadtrip::DISTANCE_SHORT,
                    'form.roadtrip.distance.medium' => Roadtrip::DISTANCE_MEDIUM,
                    'form.roadtrip.distance.long' => Roadtrip::DISTANCE_LONG,
                ],
                'label' => 'form.roadtrip.distance.label',
                'placeholder' => 'form.roadtrip.distance.placeholder',
            ])

            ->add('roadtrip_types', EntityType::class, [
                'class' => RoadtripType::class,
                'choice_label' => 'name',
                'label' => 'form.roadtrip.roadtrip_types.label',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'constraints' => [
                    new Callback([$this, 'validateRoadtripTypes']),
                ],
            ])

            ->add('save', SubmitType::class, [
                'label' => 'form.roadtrip.save.label',
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
                $context->buildViolation('form.roadtrip.end_date.error_2')
                    ->atPath('start_date')
                    ->addViolation();
            }

            $diff = $endDate->diff($startDate)->days;
            if ($diff > 7) {
                $context->buildViolation('form.roadtrip.end_date.error_3')
                    ->atPath('end_date')
                    ->addViolation();
            }
        }
    }

    public function validateRoadtripTypes($object, ExecutionContextInterface $context): void
    {
        if (count($object) > 3) {
            $context->buildViolation('form.roadtrip.roadtrip_types.error')
                ->atPath('roadtrip_types')
                ->addViolation();
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Roadtrip::class,
        ]);
    }
}

