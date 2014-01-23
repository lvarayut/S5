<?php

namespace Enstb\Bundle\DataManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Exception\RuntimeException;

class DefaultController extends Controller
{
    // Transform data by connecting event into one word (Deliminator is "-")
    public function transformAction()
    {
        $path = "/Applications/XAMPP/xamppfiles/htdocs/S5/src/Enstb/Bundle/DataManagementBundle/Resources/data";
        $fileName = "Kasteren_HouseA_activities_T0.txt";
        $this->transform($path,$fileName);
        return $this->render('EnstbDataManagementBundle:Default:transform.html.twig');
    }

    // Import sensors' data from file
    public function importAction(Request $request)
    {
        // Get all patients in DB
        $patientArr = $this->getAllPatients();
        $patientNames = array();
        foreach($patientArr as $patient){
            $patientNames[$patient->getID()] = $patient->getName()." ".$patient->getLastName();
        }
        $form = $this->createFormBuilder()
            ->add('patient', 'choice', array(
                'choices'   => $patientNames,
                'required'  => true
            ))
            ->add('importFile', 'file', array(
                'label' => 'File to import',
                'required' => true
            ))
            ->add('submit','submit')
            ->getForm();

        // Verify whether the request came from the submit button or not
        if ($request->getMethod('post') == 'POST') {
            // Bind request to the form
            $form->submit($request);
            // If form is valid
            if ($form->isValid()) {
                // Get file
                $file = $form->get('importFile');
                // Get patient name
                $patientName = $form->get('patient')->getData();
                //Create a table by using the patient_name
                $this->createDatasetTable($patientName);
                // Get data inside the file
              //  $this->importDataset($file->getData());
            }

        }

        return $this->render('EnstbDataManagementBundle:Default:import.html.twig',
            array('form' => $form->createView(),)
        );
    }

    // Transform data by connecting event into one word (Deliminator is "-")
    public function transform($file)
    {
        $handle = fopen($file, "r") or die("Couldn't open $file");
        // Read data line by line
        while (($line = fgets($handle)) !== false) {
            $dataTransformed = "";
            // Split each line by space
            $dataArray = explode(" ", $line);
            // Concatenate first and second words
            $dataTransformed .= $dataArray[0]." ";
            $dataTransformed .= $dataArray[1]." ";
            // Add hyphen between words for combining an activity into one word
            for($i=2;$i<count($dataArray)-1;$i++){
                // Don't append hyphen for the last word of activity
                if($i==count($dataArray)-2){
                    $dataTransformed .= $dataArray[$i]." ";
                }
                else{
                    $dataTransformed .= $dataArray[$i]."-";
                }
            }
            // Concatenate the last word
            $dataTransformed .= $dataArray[count($dataArray)-1];
            // Write the data
           // file_put_contents($fileWrite, $dataTransformed, FILE_APPEND | LOCK_EX);
        }
        fclose($handle);
    }

    // Import file into Database
    public function importDataset($file){
        $dataTransformed = $this->transform($file);
        $handle = fopen($file, "r") or die("Couldn't open $file");
        // Read data line by line
        while (($line = fgets($handle)) !== false) {
            echo $line.'<br>';
        }

    }

    // Create a new table of Dataset
    public function createDatasetTable($patientName){
        $sql = "
            CREATE TABLE DATA_".$patientName."
            (
            id int NOT NULL AUTO_INCREMENT,
            event varchar(100) NOT NULL,
            begin datetime,
            end datetime,
            place varchar(100),
            PRIMARY KEY (ID)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ";
        $stmt = $this->getDoctrine()->getManager()->getConnection()->prepare($sql);
        $stmt->execute();
    }

    // Insert dataset into a given table name
    public function insertDataset($tableName){
        $sql = "
            INSERT;
        ";
        $stmt = $this->getDoctrine()->getManager()->getConnection()->prepare($sql);
        $stmt->execute();
    }

    // Get all patient objects
    public function getAllPatients(){
        $em = $this->getDoctrine()->getManager();
        // In the many-to-many case, you must
        // join your own attribute, roles, in the class
        // NOTE: "roles" is an attribute of the User class
        // NOT a column is the database.
        $query = $em->createQuery(
           'SELECT u
            FROM EnstbVisplatBundle:User u
            INNER JOIN u.roles r
            WHERE r.name = :roleName
            ORDER BY u.name ASC'
        )->setParameter('roleName', 'Patient');

        $patientArr = $query->getResult();


        if (!$patientArr) {
            throw new RuntimeException(
                'There is no patient in the database'
            );
        }
        return $patientArr;
    }
}
