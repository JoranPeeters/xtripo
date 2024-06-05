<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\Database\RoadtripTypeService;

#[AsCommand(
    name: 'xtripo:import-roadtrip-types',
    description: 'This command will import Roadtrip Types to database',
)]
class XtripoImportRoadtripTypesCommand extends Command
{
    public function __construct(
        private readonly RoadtripTypeService $typeService,
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add types of road trips to the database.')
            ->setHelp('This command allows you to add types of road trips to the database...');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $types = [
            "Adventurous",
            "Nature and Wildlife",
            "Luxurious",
            "Romantic",
            "Historical",
            "Cultural",
            "Family-friendly",
            "Beach",
            "Mountain",
            "City Exploration",
            "Food and Wine",
            "Photography",
            "Music and Festival",
            "Camping and Outdoors",
            "Spiritual and Wellness",
            "Winter Sports",
            "Scenic Byways",
            "National Parks",
            "Off-road and 4x4",
            "Motorcycle Roadtrip",
            "Budget",
            "Solo Travel",
            "Route of Castles",
            "Golfing",
            "Fishing",
            "Roadtrip Along the Coastline",
            "Desert Adventures",
            "Eco-friendly",
            "Volunteering",
            "Pilgrimage",
            "Literary",
            "Art and Museums",
            "Amusement Parks",
            "Shopping"
        ];

        $this->typeService->addTypeOfRoadtrips($types);

        $output->writeln('Types added successfully!');

        return Command::SUCCESS;
    }
}