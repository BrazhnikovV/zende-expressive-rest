<?php
namespace Auth\Service;

use User\Entity\User;
use Psr\Http\Message\ResponseInterface;
use Mezzio\Authentication\UserInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Mezzio\Authentication\AuthenticationInterface;

/**
 * Class AuthAdapter - Adapter used for authenticating user. It takes login and password on input
 * and checks the database if there is a user with such login (email) and password.
 * If such user exists, the service returns its identity (email). The identity
 * is saved to session and can be retrieved later with Identity view helper provided
 * by ZF3.
 * @package User\Service
 */
class AuthAdapter implements AuthenticationInterface
{
    /**
     * @access - private
     * @var string $email - User email.
     */
    private $email;

    /**
     * @access - private
     * @var string $password - Password
     */
    private $password;

    /**
     * @access - private
     * @var Doctrine\ORM\EntityManager $em - Entity manager.
     */
    private $em;

    /**
     * @access private
     * @var Auth\Service\JwtService $jwtService - JWT service.
     */
    private $jwtService;

    /**
     * Constructor.
     * @param $entityManager
     * @param $jwtService
     */
    public function __construct( $entityManager, $jwtService )
    {
        $this->em = $entityManager;
        $this->jwtService = $jwtService;
    }

    /**
     * Sets user email.
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Sets password.
     */
    public function setPassword($password)
    {
        $this->password = (string)$password;
    }

    /**
     * authenticate
     * @param ServerRequestInterface $request
     * @return UserInterface|null
     * @throws \Exception
     */
    public function authenticate( ServerRequestInterface $request ): ?UserInterface
    {
        $auth = $request->getHeaderLine('Authorization');
        $token = explode('Bearer ', $auth );
        if ( count($token) == 2 ) {
            $verifyJwt = $this->jwtService->verifyJwt( $token[1] );
            if ( $verifyJwt != false ) {
                $user = $this->em->getRepository( User::class )->findOneByEmail( $verifyJwt->email );

                if ( $user == null ) {
                    throw new \Exception('There is no user with such identity');
                }
                // !Fixme когда передается неизвестная роль - вылетает exeption - No role with name "guests" could be found
                return new AuthDefaultUser( $user->getEmail(), $user->getRoles(), [] );
            } else {
                return null;
            }
        } else {
            throw new \Exception('There is no bearer Authorization');
        }
    }

    /**
     * unauthorizedResponse
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function unauthorizedResponse( ServerRequestInterface $request ): ResponseInterface
    {
        return new JsonResponse( ['status' => 401] );
    }
}


