<?php

namespace App\Command\Group;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'EditGroupCommand',
    description: 'Edit group',
)]
class EditGroupCommand extends Command
{
    protected static $defaultName = 'api:edit-group';
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'Group ID')
            ->addArgument('name', InputArgument::OPTIONAL, 'Group name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');
        $response = $this->client->request('PATCH', "http://api_server/api/group/{$id}/edit",
            [
                'json' => ['name' => $input->getArgument('name')]
            ]);

        $group = $response->toArray();
        $output->writeln(' Edited group ID - '.$group['id'].', Group name - '.$group['name']);

        return Command::SUCCESS;
    }
}
