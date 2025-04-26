<?php

declare(strict_types=1);

namespace App\Modules\Products\Cli;

use App\Modules\Products\Application\Messenger\Commands\CreateProductCommand;
use App\Shared\Domain\Messenger\CommandBus\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:products:create',
    description: 'create random products'
)]
class CreateProducts extends Command
{
    private SymfonyStyle $io;

    public function __construct(private readonly CommandBus $commandBus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);

        $products = $this->getRandomProducts();

        foreach ($products as $product) {
            try {
                $this->commandBus->dispatch($product);
            } catch (\Exception $exception) {
                $this->io->info($exception->getMessage());
            }
        }

        return Command::SUCCESS;
    }

    /** @return CreateProductCommand[] */
    private function getRandomProducts(): array
    {
        return [
            new CreateProductCommand(
                name: "Product A",
                price: 50,
            ),
            new CreateProductCommand(
                name: "Product B",
                price: 50,
            ),
        ];
    }
}