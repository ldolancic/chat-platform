<?php


namespace App\Controller\Api;

use App\Factory\Contract\UserFactoryInterface;
use App\Form\RegisterUserType;
use App\Repository\Contract\UserRepositoryInterface;
use App\Request\RegisterUserRequest;
use App\ValueObject\Exception\InvalidEmailException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/register", name="api:register_")
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"POST"})
     *
     * @param Request $request
     * @param UserRepositoryInterface $userRepository
     * @param UserFactoryInterface $userFactory
     * @return JsonResponse
     * @throws InvalidEmailException
     */
    public function index(Request $request, UserRepositoryInterface $userRepository, UserFactoryInterface $userFactory)
    {
        $registerUserRequest = new RegisterUserRequest();

        $form = $this->createForm(RegisterUserType::class, $registerUserRequest,
            array('csrf_protection' => false)
        );

        $data = json_decode($request->getContent(), true);

        $form->submit($data, true);

        if (!$form->isValid()) {
            throw new HttpException('Validation failed');
        }

        $user = $userFactory->createFromRegisterUserRequest($registerUserRequest);

        $userRepository->save($user);

        return $this->json($user);
    }
}
