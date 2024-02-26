<?php

namespace App\Tests\Unit;

use App\Controller\MeController;
use App\Entity\User;
use App\Repository\TimeDayRepository;
use App\Repository\UserRepository;
use App\Repository\WeekDayRepository;
use App\Service\TokenDecode;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProfilTest extends KernelTestCase
{
    private $UserRepository;
    private $TimeDayRepository;
    private $WeekDayRepository;
    private $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->UserRepository = $this->createMock(UserRepository::class);
        $this->TimeDayRepository = $this->createMock(TimeDayRepository::class);
        $this->WeekDayRepository = $this->createMock(WeekDayRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->clear();
    }

    public function testCreateProfil(): void
    {

        $testUser = new User();
        $testUser->setEmail('xxxxxx@xxxxxxx.com');
        $testUser->setUsername('xxxxxxxx');
        $testUser->setPassword('toto');
        $testUser->setRoles(['ROLE_USER']);

        $this->entityManager->expects($this->once())->method('persist')->with($testUser);
        $this->entityManager->expects($this->once())->method('flush');

        $this->UserRepository->method('findOneBy')->willReturn($testUser);

        $this->entityManager->persist($testUser);
        $this->entityManager->flush();

        $persistedUser = $this->UserRepository->findOneBy(['email' => 'xxxxxx@xxxxxxx.com']);
        $this->assertInstanceOf(User::class, $persistedUser);
        $this->assertEquals('xxxxxx@xxxxxxx.com', $persistedUser->getEmail());
        $this->assertEquals('xxxxxxxx', $persistedUser->getUsername());
        $this->assertEquals('toto', $persistedUser->getPassword());
        $this->assertEquals(['ROLE_USER'], $persistedUser->getRoles());
        echo "Le profil a été créé avec succès.\n";
    }

}
