<?php
namespace App\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\JWTAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationFailureHandler;

class AuthenticationFailureListener extends AuthenticationFailureHandler
{
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return new JsonResponse([
            'message' => "Login failed."
        ], 401);
    }
}