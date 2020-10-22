<?php

namespace HomeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HomeBundle\Entity\User;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $adminLuuug = new User();
        $adminLuuug->setUsername('admin@studioluuug.com');
        $adminLuuug->setUsernameCanonical('admin@studioluuug.com');
        $adminLuuug->setEmail('h.siracuse@studioluuug.com');
        $adminLuuug->setEmailCanonical('h.siracuse@studioluuug.com');
        $adminLuuug->setEnabled(1);
        $adminLuuug->setPassword('$2y$10$B/.iBt95G91KaMWwidTPduTsj3GMdhvxdDrHFttuI5Ll/tEjFq5j.');
        $adminLuuug->setRoles(['ROLE_ADMIN', 'ROLE_GOD']);
        $adminLuuug->setName('Admin');
        $adminLuuug->setFirstname('Luuug');

        $adminClient = new User();
        $adminClient->setUsername('admin');
        $adminClient->setUsernameCanonical('admin');
        $adminClient->setEmail('a.milan@studioluuug.com');
        $adminClient->setEmailCanonical('a.milan@studioluuug.com');
        $adminClient->setEnabled(1);
        $adminClient->setPassword('$2y$10$c0Lqi9CgmnwgsuxYdxaH9eIwDEvbXHDqsIPNaDZGF6pUVgWho4/sq');
        $adminClient->setRoles(['ROLE_ADMIN']);
        $adminClient->setName('Admin');
        $adminClient->setFirstname('Client');

        $manager->persist($adminLuuug);
        $manager->persist($adminClient);

        $manager->flush();
    }
}