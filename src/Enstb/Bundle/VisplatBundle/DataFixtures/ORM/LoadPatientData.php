<?php

namespace Enstb\Bundle\VisplatBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPatientData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // Load default data for patient
        $connection = $manager->getConnection();
        $patientId = $this->getReference('patientId')->getId();

        $createTableSQL = "
        CREATE TABLE DATA_" . $patientId . "
            (
            id int NOT NULL AUTO_INCREMENT,
            event varchar(100) NOT NULL,
            begin datetime,
            end datetime,
            place varchar(100),
            PRIMARY KEY (ID)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ";
        $data = array(
            array(
                "event" => "brush-teeth",
                "begin" => "2008-02-25 00:19:32",
                "end" => "2008-02-25 00:21:23"
            ),
            array(
                "event" => "go-to-bed",
                "begin" => "2008-02-25 00:22:46",
                "end" => "2008-02-25 09:34:12"
            ),
            array(
                "event" => "use-toilet",
                "begin" => "2008-02-25 09:37:16",
                "end" => "2008-02-25 09:38:02"
            ),
            array(
                "event" => "prepare-Breakfast",
                "begin" => "2008-02-26 09:26:42",
                "end" => "2008-02-26 09:29:08"
            ),
            array(
                "event" => "take-shower",
                "begin" => "2008-02-26 09:48:07",
                "end" => "2008-02-26 09:58:56"
            )
        );
        $connection->exec($createTableSQL);
        foreach ($data as $datum) {
            $connection->exec(
                "INSERT INTO Data_" . $patientId . " (event,begin,end)
                VALUES ('" . $datum['event'] . "','" . $datum['begin'] . "','" . $datum['end'] . "');");
        }

    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }


}