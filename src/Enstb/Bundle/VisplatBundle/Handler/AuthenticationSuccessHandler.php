<?php

namespace Enstb\Bundle\VisplatBundle\Handler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\HttpUtils;


class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler {
    private $router;
    public function __construct( HttpUtils $httpUtils, array $options, $router ) {
        $this->router = $router;
        parent::__construct( $httpUtils, $options );
    }

    public function onAuthenticationSuccess( Request $request, TokenInterface $token ) {
        if( $request->isXmlHttpRequest() ) {
            $response = new JsonResponse( array( 'success' => true, 'username' => $token->getUsername() ) );
            return $response;
        } else {
            if ($targetPath = $request->getSession()->get('_security.target_path')) {
                $url = $targetPath;
            } else {
                // Otherwise, redirect him to wherever you want
                $url = $this->router->generate('enstb_visplat_homepage', array(
                    'username' => $token->getUser()->getUsername()
                ));
            }

            return new RedirectResponse($url);
        }
    }
}