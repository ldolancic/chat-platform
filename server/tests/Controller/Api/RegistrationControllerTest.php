<?php

namespace App\Tests\Controller\Api;

use App\Entity\User;
use App\ValueObject\Email;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationControllerTest extends WebTestCase
{
    private EntityManager $entityManager;

    private KernelBrowser $client;

    private UserPasswordEncoderInterface $passwordEncoder;

    public function testRegisterActionWithNonExistingUser(): void
    {
        $requestData = array(
            'email'     => 'my@test.email',
            'firstName' => 'First',
            'lastName'  => 'Last',
            'password'  => 'test123'
        );

        $requestBody = json_encode($requestData);

        $this->client->request('POST', '/api/register/', [], [], [], $requestBody);

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $this->assertArrayHasKey('id', $responseContent);

        $this->assertArrayHasKey('email', $responseContent);
        $this->assertIsArray($responseContent['email']);

        $this->assertArrayHasKey('firstName', $responseContent);
        $this->assertIsString($responseContent['firstName']);

        $this->assertArrayHasKey('lastName', $responseContent);
        $this->assertIsString($responseContent['lastName']);

        $this->assertArrayHasKey('password', $responseContent);
        $this->assertIsString($responseContent['password']);

    }

    public function testRegisterActionWithExistingUser(): void
    {
        $requestData = array(
            'email'     => 'my@test.email',
            'firstName' => 'First',
            'lastName'  => 'Last',
            'password'  => 'test123'
        );

        $user = new User(new Email($requestData['email']), $requestData['firstName'], $requestData['lastName']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $requestData['password']));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $requestBody = json_encode($requestData);

        $this->client->request('POST', '/api/register/', [], [], [], $requestBody);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    protected function setUp()
    {
        $this->client = static::createClient();

        $this->entityManager = self::$container->get('doctrine')->getManager();
        $this->passwordEncoder = self::$container->get('security.password_encoder');
    }


}