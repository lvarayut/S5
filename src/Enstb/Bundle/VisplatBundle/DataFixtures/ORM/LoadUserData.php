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

        $userDoctor = new User();
        $userDoctor->setName('DoctorName');
        $userDoctor->setLastName('DoctorLastName');
        $userDoctor->setEmail('doctor@fake.com');
        $userDoctor->setUsername('doctor');
        $userDoctor->setPassword('doctor');
        $userDoctor->addRole($this->getReference('role-doctor'));

        $userPatient = new User();
        $userPatient->setName('PatientName');
        $userPatient->setLastName('PatientLastName');
        $userPatient->setEmail('patient@fake.com');
        $userPatient->setUsername('patient');
        $userPatient->setPassword('patient');
        $userPatient->addRole($this->getReference('role-patient'));
        $userPatient->setDoctorId($userDoctor);
        $this->addReference('patientId', $userPatient);


        $userFamily = new User();
        $userFamily->setName('FamilyName');
        $userFamily->setLastName('FamilyLastName');
        $userFamily->setEmail('family@fake.com');
        $userFamily->setUsername('family');
        $userFamily->setPassword('family');
        $userFamily->addRole($this->getReference('role-family'));
        $userFamily->setDoctorId($userDoctor);


        $manager->persist($userAdmin);
        $manager->persist($userDoctor);
        $manager->persist($userPatient);
        $manager->persist($userFamily);
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