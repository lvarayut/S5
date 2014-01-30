<?php

namespace Enstb\Bundle\VisplatBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Enstb\Bundle\VisplatBundle\Entity\Role;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // Generate default roles
        $roleAdmin = new Role();
        $roleAdmin->setName('Administrator');
        $roleAdmin->setDescription('Administrator is responsible for managing and controlling the web application.');

        $roleDoctor = new Role();
        $roleDoctor->setName('Doctor');
        $roleDoctor->setDescription('Doctor can access precise information of his patients.');

        $rolePatient = new Role();
        $rolePatient->setName('Patient');
        $rolePatient->setDescription('Patient can access his/her global information - Living ADLs, Notification system, and etc.');

        $roleFamily = new Role();
        $roleFamily->setName('Family');
        $roleFamily->setDescription('Patient family');

        $manager->persist($roleAdmin);
        $manager->persist($roleDoctor);
        $manager->persist($rolePatient);
        $manager->persist($roleFamily);
        $manager->flush();

        $this->addReference('role-admin', $roleAdmin);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }


}