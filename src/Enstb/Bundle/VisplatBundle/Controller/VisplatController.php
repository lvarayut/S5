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
        // ADLs
        $em = $this->getDoctrine()->getManager();
        // Get current user
        $doctor = $this->get('security.context')->getToken()->getUser();
        // Create a doctrine manager
        $em = $this->getDoctrine()->getManager();
        $patients = $em->getRepository('EnstbVisplatBundle:User')->findPatientsOfDoctor($doctor->getId());
        // Create Status Graph, passing the first patient'id order by name
        $graphs = $this->createStatusGraph($patients[0]['id']);
        $jsonDataPieChart = $graphs[0];
        $jsonDataGanttChart = $graphs[1];
        return $this->render('EnstbVisplatBundle:Graph:status.html.twig', array(
            'jsonDataPieChart' => $jsonDataPieChart,
            'jsonDataGanttChart' => $jsonDataGanttChart
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
        }
        $form = $this->createFormBuilder()
            ->add('patient', 'choice', array(
                'choices' => $patientArray,
                'required' => true,
                'label' => false
            ))
            ->getForm();
        return $this->render('EnstbVisplatBundle:Visplat:patientForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Handle the Ajax request for updating the graph data.
     * @param Request $request
     * @return Response
     */
    public function handleAjaxUpdateAction(Request $request)
    {
        // Get the JSON object from Ajax
        $patient = json_decode($request->getContent());
        $response = $this->createStatusGraph($patient->id);
        return new Response(json_encode($response));

    }

    /**
     * Create all the status graphs
     *
     * @param $patientId
     * @return array of JSON data
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function createStatusGraph($patientId)
    {
        // Create a doctrine manager
        $em = $this->getDoctrine()->getManager();
        $pieEvents = $em->getRepository('EnstbVisplatBundle:User')->findAllGroupByEvent($patientId);
        $ganttEvents = $em->getRepository('EnstbVisplatBundle:User')->findAllEvents($patientId);
        if (!$pieEvents) {
            throw $this->createNotFoundException('Unable to find events.');
        }

        if (!$ganttEvents) {
            throw $this->createNotFoundException('Unable to find events.');
        }
        $jsonDataPieChart = GraphChart::createPieChart($pieEvents);
        $jsonDataGanttChart = GraphChart::createGanttChart($ganttEvents);
        return array($jsonDataPieChart, $jsonDataGanttChart);
    }

}
