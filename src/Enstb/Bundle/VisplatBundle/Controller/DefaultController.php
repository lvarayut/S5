<?php

namespace Enstb\Bundle\VisplatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EnstbVisplatBundle:Graph:status.html.twig');
    }
}
