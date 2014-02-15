<?php

namespace Enstb\Bundle\VisplatBundle\Repository;

use Doctrine\ORM\EntityRepository;


class UserRepository extends EntityRepository
{
    /**
     * Fetch all events
     *
     * @return mixed, Array of events
     */
    public function findAllGroupByEvent(){
        $sql = "
            SELECT `Event`, `Begin`, `End`, COUNT(`Event`) AS Frequency,
            TIMESTAMPDIFF( SECOND, `Begin`, `End`) AS Time
            FROM `Data_3` GROUP BY `Event`;
        ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
<<<<<<< HEAD
	/**
     * Fetch all events
     *
     * @return mixed, Array of events
     */
    public function findAllEvents(){
        $sql = "
            SELECT `Event` AS `taskName`, 
			`Begin` AS `startDate`, 
			`End` AS `endDate` 
			FROM `Data_3`;
        ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

=======

    /**
     * Fetch all patients of the current doctor
     *
     * @return mixed, Array of events
     */
    public function findPatientsOfDoctor($doctorId)
    {

        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT u
            FROM EnstbVisplatBundle:USER u
            WHERE u.doctorId = :doctorId
            ORDER BY u.name '
        )->setParameter('doctorId', $doctorId);
        $patientArr = $query->getResult();
        if (!$patientArr) {
            return null;
        }
        return $patientArr;
        return $query->getResult();
    }
>>>>>>> 30a5de5f6c90181ec8d06379ec1694b6fdcdb393
}
