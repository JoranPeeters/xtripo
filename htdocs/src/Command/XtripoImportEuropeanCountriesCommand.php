<?php

namespace App\Command;

use App\Service\OpenAI\OpenAIService;
use App\Service\Database\CountryService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'xtripo:import-european-countries',
    description: 'Import data using open.ai API and persisiting data inside country table',
)]
class XtripoImportEuropeanCountriesCommand extends Command
{
    public function __construct(
        private readonly OpenAIService $openAIService,
        private readonly CountryService $countryService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('This command will import country data from open.ai API');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Fetch all countries from open.ai api
        $countries = $this->openAIService->getEuropeanCountries();

        if (empty($countries)) {
            return $this->outputFailed($output);
        }

        // Create new country entities
        $this->countryService->addEuropeanCountries($countries);
        return $this->outputSuccess($output);
    }

    private function outputFailed($output): int
    {
        $output->writeln([
            '<fg=red>No Countries Found!</>',
            '<fg=red>=======================================================================</>',
            '<fg=red> /$$$$$$$$       /$$ /$$                 /$$</>',
            '<fg=red>| $$_____/      |__/| $$                | $$</>',
            '<fg=red>| $$    /$$$$$$  /$$| $$  /$$$$$$   /$$$$$$$</>',
            '<fg=red>| $$$$$|____  $$| $$| $$ /$$__  $$ /$$__  $$</>',
            '<fg=red>| $$__/ /$$$$$$$| $$| $$| $$$$$$$$| $$  | $$</>',
            '<fg=red>| $$   /$$__  $$| $$| $$| $$_____/| $$  | $$</>',
            '<fg=red>| $$  |  $$$$$$$| $$| $$|  $$$$$$$|  $$$$$$$</>',
            '<fg=red>|__/   \_______/|__/|__/ \_______/ \_______/</>',
        ]);

        return Command::FAILURE;
    }

    private function outputSuccess($output): int
    {
        $output->writeln([
            '<fg=green>Countries successfully imported!</>',
            '<fg=green>=======================================================================</>',
            '<fg=green> /$$$$$$</>',
            '<fg=green>/$$__  $$</>',                                                          
            '<fg=green>| $$  \__/ /$$   /$$  /$$$$$$$  /$$$$$$$  /$$$$$$   /$$$$$$$ /$$$$$$$</>',
            '<fg=green>|  $$$$$$ | $$  | $$ /$$_____/ /$$_____/ /$$__  $$ /$$_____//$$_____</>',
            '<fg=green>\____  $$| $$  | $$| $$      | $$      | $$$$$$$$|  $$$$$$|  $$$$$$</>', 
            '<fg=green>/$$  \ $$| $$  | $$| $$      | $$      | $$_____/ \____  $$\____  $$</>',
            '<fg=green>|  $$$$$$/|  $$$$$$/|  $$$$$$$|  $$$$$$$|  $$$$$$$ /$$$$$$$//$$$$$$$/</>',
            '<fg=green>\______/  \______/  \_______/ \_______/ \_______/|_______/|_______/</>',
        ]);

        return Command::SUCCESS;
    }
}
