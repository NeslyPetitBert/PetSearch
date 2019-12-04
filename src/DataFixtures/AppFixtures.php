<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Main\AdminUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');
        $roles =['ROLE_ADMIN'];


        for ($i=1; $i <=20 ; $i++) {
            $adminUser = new AdminUser();
            $password = $this->encoder->encodePassword($adminUser, 'password');
            $adminUser->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setEmail($faker->email)
                ->setHash($password)
                ->setRoles($roles);

            $manager->persist($adminUser);
        }
        $manager->flush();
    }
}