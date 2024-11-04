<?php

namespace App\Command\Group;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'ShowAllUsersOfGroup',
    description: 'Show all users of a group',
)]
class ShowAllUsersOfGroupCommand extends Command
{
    protected static $defaultName = 'app:show-all-users-of-group';
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure(): void
    {
        $this->addArgument('id', InputArgument::OPTIONAL, 'Group ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = $input->getArgument('id');
        $response = $this->client->request('GET', "http://api_server/api/group/{$id}/show_users_of_group");
        $users = $response->toArray();

        foreach ($users as $user) {
            $output->writeln( ' User ID - '.$user['id'].', Group name - '.$user['name']);
        }

        return Command::SUCCESS;
    }
}
