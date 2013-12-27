<?php

namespace Enstb\Bundle\DataManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Enstb\Bundle\DataManagementBundle\Utils\DataTransform;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $path = "/Applications/XAMPP/xamppfiles/htdocs/S5/src/Enstb/Bundle/DataManagementBundle/Resources/data";
        $fileName = "Kasteren_HouseA_activities_T0.txt";
        DataTransform::transform($path,$fileName);
        return $this->render('EnstbDataManagementBundle:Default:index.html.twig');
    }
}
