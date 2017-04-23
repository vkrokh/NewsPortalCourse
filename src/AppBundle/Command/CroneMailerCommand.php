<?php
/**
 * Created by PhpStorm.
 * User: pralolik
 * Date: 22/04/17
 * Time: 15:53
 */

namespace AppBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CroneMailerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:dispatch')
            ->setDescription('Daily mailer')
            ->setHelp('This command send mails to user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine = $this->getContainer()->get('doctrine');
        $mailer = $this->getContainer()->get('mailer');
        $userRepository = $doctrine->getRepository('AppBundle:User');
        $newsRepository = $doctrine->getRepository('AppBundle:News');
        $latestNews = $newsRepository->getLatestFiveNews();
        $users = $userRepository->getAllDispatchUsers();
        foreach ($users as $user) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Latest News')
                ->setFrom($this->getContainer()->getParameter('mailer_user'))
                ->setTo($user->getEmail())
                ->setContentType('text/html')
                ->setBody(
                    $this->getContainer()->get('templating')->render(
                        ':mails:latestNewsMail.html.twig',
                        ['news' => $latestNews]
                    )
                );
            $mailer->send($message);
        }
    }

}