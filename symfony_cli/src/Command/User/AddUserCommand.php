<?php

namespace App\Command\User;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'AddUserCommand',
    description: 'Creates a new user.',
)]
class AddUserCommand extends Command
{
    protected static $defaultName = 'api:add-user';
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure():void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the user.')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)

    {
        $response = $this->client->request('POST', 'http://api_server/api/user/new', [
            'json' => [
                'name' => $input->getArgument('name'),
                'email' => $input->getArgument('email'),
            ],
        ]);

        $user = $response->toArray();
        $output->writeln(' User created with ID - '.$user['id'].', User name - '.$user['name'].', '.'User email - '.$user['email']);

        return Command::SUCCESS;
    }
}