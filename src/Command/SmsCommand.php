<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twilio\Rest\Client;

class SmsCommand extends Command
{
    private $twilio;
    private $container;

    public function __construct(Client $twilio, ContainerInterface $container)
    {
        $this->twilio = $twilio;
        $this->container = $container;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:sms')
            ->setDescription('Send reminder text message');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->container->get('doctrine');
        $userRepository = $em->getRepository('App:User');

        // get users scheduled for today
        $users = $userRepository->createQueryBuilder('a')
            ->select('a')
            ->where('a.status = :status')
            ->setParameters(array(
                'status' => 0,
            ))
            ->getQuery()
            ->getResult();

        if (count($users) > 0) {
            $output->writeln('SMSes to send: #' . count($users));
            $sender = $this->container->getParameter('twilio_number');

            foreach ($users as $user) {
                $user = $user->getStudent();
                $message = $this->twilio->messages->create(
                    $user->getPhoneNumber(), // Send text to this number
                    array(
                        'from' => $sender, // My Twilio phone number
                        'body' => 'Hello from Awesome Messages. A reminder that your massage user is for today at. Call ' . $sender . ' for any questions.',
                    )
                );

                $output->writeln('SMS #' . $message->sid . ' sent to: ' . $user->getPhoneNumber());
            }

        } else {
            $output->writeln('No users for today.');
        }
    }
}
