<?php

namespace Enstb\Bundle\VisplatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Enstb\Bundle\VisplatBundle\Graph\GraphChart;

class VisplatController extends Controller
{
    /**
     * Generate ADLs, Pie chart and table
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function statusAction(Request $request)
    {
        // Redirect admin to Admin page
        if ($this->get('security.context')->isGranted('ROLE_SUPERADMIN') && $this->get('security.context')->isGranted('ROLE_ADMIN') == false) {
            return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
        }
        $patientId = $this->getDefaultPatient();
        $startDate = $this->getDefaultDate($patientId);
        // Create Status Graph, passing the first patient'id order by name
        $graphJSON = $this->createStatusGraph($patientId, $startDate, $startDate);
        return $this->render('EnstbVisplatBundle:Graph:status.html.twig', array(
            'jsonDataPieChart' => $graphJSON['pieChart'],
            'jsonDataGanttChart' => $graphJSON['ganttChart']
        ));
    }

    /**
     * Verify Authentication
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('EnstbVisplatBundle:Login:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
        ));
    }


    /**
     * Create a patient form to be embedded into a layout.html.twig
     *
     * @return \Symfony\Component\Form\Form
     */
    public function patientFormAction(Request $request)
    {
        $patientArray = array();
        // Get current user
        $doctor = $this->get('security.context')->getToken()->getUser();
        // Create a doctrine manager
        $em = $this->getDoctrine()->getManager();
        $patients = $em->getRepository('EnstbVisplatBundle:User')->findPatientsOfDoctor($doctor->getId());
        if ($patients) {
            // Make an associative array
            foreach ($patients as $patient) {
                $patientArray[$patient['id']] = $patient['name'];
            }
        } else {
            throw new RuntimeException(
                'There is no patient in the database'
            );
        }
        $form = $this->createFormBuilder()
            ->add('patient', 'choice', array(
                'choices' => $patientArray,
                'required' => true,
                'label' => false,
            ))
            ->getForm();
        return $this->render('EnstbVisplatBundle:Visplat:patientForm.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * Create a date form to be embedded into a layout.html.twig
     *
     * @return \Symfony\Component\Form\Form
     */
    public function dateFormAction(Request $request)
    {
        $dateArray = array();
        // Get current user
        $user = $this->get('security.context')->getToken()->getUser();
        // Create a doctrine manager
        $em = $this->getDoctrine()->getManager();
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            // Get first patient
            $patient = $em->getRepository('EnstbVisplatBundle:User')->findFirstPatientsOfDoctor($user->getId());
            $patientId = $patient['id'];
        } elseif ($this->get('security.context')->isGranted('ROLE_USER')) {
            $patientId = $user->getId();
        }
        $dates = $em->getRepository('EnstbVisplatBundle:User')->findAllEventDate($patientId);
        if ($dates) {
            // Make an associative array
            foreach ($dates as $date) {
                $dateArray[$date['date']] = $date['date'];
            }
        } else {
            throw new RuntimeException(
                'There is no patient in the database'
            );
        }
//        $form = $this->createFormBuilder()
//            ->add('date', 'date', array(
//                'input' => 'string',
//                'widget' => 'single_text'
//            ))
//            ->getForm();
        $form = $this->createFormBuilder()
            ->add('startDate', 'choice', array(
                'choices' => $dateArray,
                'required' => true,
                'label' => false
            ))
            ->add('endDate', 'choice', array(
                'choices' => $dateArray,
                'required' => true,
                'label' => false,
//                'attr' => array('disabled' => 'disabled')
            ))
            ->getForm();
        return $this->render('EnstbVisplatBundle:Visplat:dateForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Handle the Ajax request for updating the graph data.
     * @param Request $request
     * @return Response
     */
    public function handleAjaxUpdatePatientAction(Request $request)
    {
        // Get router object
        $router = $this->get('router');
        $currentUrl = $request->getUri();
        // Get current route
        // Get the JSON object from Ajax
        $patient = json_decode($request->getContent());
        // Verify whether the current user is Doctor or Patient
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            if ($patient->route == 'enstb_visplat_homepage') {
                $graphJSON = $this->createStatusGraph($patient->id, $patient->startDate, $patient->endDate);
            } elseif ($patient->route == 'enstb_visplat_dependency') {
                $graphJSON = $this->createDependencyGraph($patient->id, $patient->startDate, $patient->endDate);
            }
        } elseif ($this->get('security.context')->isGranted('ROLE_USER')) {
            // Get current user
            $user = $this->get('security.context')->getToken()->getUser();
            if ($patient->route == 'enstb_visplat_homepage') {
                $graphJSON = $this->createStatusGraph($user->getId(), $patient->startDate, $patient->endDate);
            } elseif ($patient->route == 'enstb_visplat_dependency') {
                $graphJSON = $this->createDependencyGraph($user->getId(), $patient->startDate, $patient->endDate);
            }
        }
        // Create the status graph
        return new Response(json_encode($graphJSON));

    }


    /**
     * Handle the Ajax request for updating the date field.
     * @param Request $request
     * @return Response
     */
    public function handleAjaxUpdateDateAction(Request $request)
    {
        // Get the JSON object from Ajax
        $patient = json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $dates = $em->getRepository('EnstbVisplatBundle:User')->findAllEventDate($patient->id);
        } elseif ($this->get('security.context')->isGranted('ROLE_USER')) {
            // Get current user
            $user = $this->get('security.context')->getToken()->getUser();
            $dates = $em->getRepository('EnstbVisplatBundle:User')->findAllEventDate($user->getId());
        }
        if ($dates) {
            // Make an associative array
            foreach ($dates as $date) {
                $dateArray[] = $date['date'];
            }
        } else {
            throw new RuntimeException(
                'There is no patient in the database'
            );
        }
        // Create the status graph
        return new Response(json_encode($dateArray));

    }

    /**
     * Create all the status graphs
     *
     * @param $patientId
     * @return array of JSON data
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function createStatusGraph($patientId, $startDate, $endDate)
    {
        // Create a doctrine manager
        $em = $this->getDoctrine()->getManager();
        $pieEvents = $em->getRepository('EnstbVisplatBundle:User')->findAllGroupByEvent($patientId, $startDate, $endDate);
        $ganttEvents = $em->getRepository('EnstbVisplatBundle:User')->findAllEvents($patientId, $startDate, $endDate);
        if (!$pieEvents) {
            throw $this->createNotFoundException('Unable to find events for the given date, Are you sure that your dataset is correct?');
        }
        if (!$ganttEvents) {
            throw $this->createNotFoundException('Unable to find events for the given date, Are you sure that your dataset is correct?');
        }
        $jsonDataPieChart = GraphChart::createPieChart($pieEvents);
        $jsonDataGanttChart = GraphChart::createGanttChart($ganttEvents);
        return array('pieChart' => $jsonDataPieChart, 'ganttChart' => $jsonDataGanttChart);
    }

    /**
     * Generate Chord Diagram
     * @param Request $request
     * @return Response
     */
    public function dependencyAction(Request $request)
    {
        // Redirect admin to Admin page
        if ($this->get('security.context')->isGranted('ROLE_SUPERADMIN') && $this->get('security.context')->isGranted('ROLE_ADMIN') == false) {
            return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
        }
        $patientId = $this->getDefaultPatient();
        $startDate = $this->getDefaultDate($patientId);
        $eventMatrix = $this->createDependencyGraph($patientId, $startDate, $startDate);
        return $this->render('EnstbVisplatBundle:Graph:dependency.html.twig', array(
            'events' => $eventMatrix['events'],
            'matrix' => $eventMatrix['matrix']
        ));
    }

    public function createDependencyGraph($patientId, $startDate, $endDate)
    {
        // Create a doctrine manager
        $em = $this->getDoctrine()->getManager();
        $allEvents = $em->getRepository('EnstbVisplatBundle:User')->findAllEvents($patientId, $startDate, $endDate);
        $distinctEvents = $em->getRepository('EnstbVisplatBundle:User')->findDistinctEvents($patientId, $startDate, $endDate);
        $eventsMatrix = GraphChart::createChordDiagram($allEvents, $distinctEvents);
        return array('events' => $eventsMatrix['events'], 'matrix' => $eventsMatrix['matrix']);

    }

    public function getDefaultPatient()
    {
        $em = $this->getDoctrine()->getManager();
        // Get current user
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        // Verify whether the current is a doctor or a patient
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            // Get first patient
            $patient = $em->getRepository('EnstbVisplatBundle:User')->findFirstPatientsOfDoctor($user->getId());
            $patientId = $patient['id'];
        } elseif ($this->get('security.context')->isGranted('ROLE_USER')) {
            $patientId = $user->getId();
        }
        return $patientId;
    }

    public function getDefaultDate($patientId)
    {
        $em = $this->getDoctrine()->getManager();
        // Get first date of the patient
        $startDate = $em->getRepository('EnstbVisplatBundle:User')->findFirstEventDate($patientId);
        return $startDate;
    }
}
