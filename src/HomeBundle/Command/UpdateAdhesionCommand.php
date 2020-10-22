<?php

namespace HomeBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateAdhesionCommand extends ContainerAwareCommand
{

    protected static $defaultName = 'app:update-adhesion';

    protected function configure()
    {
        $this
            ->setDescription('Update the adhesion status')
            ->setHelp('Update the adhesion status everyday');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $output->writeln('Début');
//
        $em = $this->getContainer()->get('doctrine')->getManager();
//        $um = $this->getContainer()->get('fos_user.user_manager');
//
//        $myUsers = $em->getRepository("HomeBundle:User")->getAdherentWithExpirationDate();
//
//        foreach ($myUsers as $myUser) {
//            $user = $um->findUserBy(['id' => $myUser->getId()]);
//            $user->removeRole('ROLE_ADHERENT');
//            $um->updateUser($user);
//
//            $myUser->setAdherent(0);
//            $em->flush();
//        }
//        $output->writeln('ok');
    }
}