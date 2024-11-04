<?php

namespace App\Command\Group;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'AddUserToGroupCommand',
    description: 'Add user to group on IDs',
)]
class AddUserToGroupCommand extends Command
{
    protected static $defaultName = 'api:add-user-to-group';
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure():void
    {
        $this
            ->addArgument('user_id', InputArgument::REQUIRED, 'The ID of the user.')
            ->addArgument('group_id', InputArgument::REQUIRED, 'The ID of the group.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)

    {
        $response = $this->client->request('POST', 'http://api_server/api/group/addUser', [
            'json' => [
                'user_id' => $input->getArgument('user_id'),
                'group_id' => $input->getArgument('group_id'),
            ],
        ]);

        $output->writeln($response->getContent());

        return Command::SUCCESS;
    }
}
