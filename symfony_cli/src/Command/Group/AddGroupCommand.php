<?php

namespace App\Command\Group;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'AddGroupCommand',
    description: 'Creates a new group.',
)]
class AddGroupCommand extends Command
{
    protected static $defaultName = 'api:add-group';
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure():void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the group.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)

    {
        $response = $this->client->request('POST', 'http://api_server/api/group/new', [
            'json' => [
                'name' => $input->getArgument('name'),
            ],
        ]);

        $group = $response->toArray();
        $output->writeln(' Group created with ID - '.$group['id'].', Group name - '.$group['name']);

        return Command::SUCCESS;
    }
}