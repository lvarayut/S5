<?php

namespace Enstb\Bundle\VisplatBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Enstb\Bundle\VisplatBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // Generate default admin account.
        $userAdmin = new User();
        $userAdmin->setName('AdminName');
        $userAdmin->setLastName('AdminLastName');
        $userAdmin->setEmail('admin@fake.com');
        $userAdmin->setUsername('admin');
        $userAdmin->setPassword('admin');
        $userAdmin->addRole($this->getReference('role-admin'));
        $manager->persist($userAdmin);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}