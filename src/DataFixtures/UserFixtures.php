<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;


    /**
     * Encoder de mot de passe
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        
        for($k = 0; $k < 10; $k++){
            $user = new User;
            
            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setUsername($faker->unique()->firstName)
                 ->setEmail($faker->email)
                 ->setPassword($hash)
                 ->setRoles([$faker->randomElement(['ROLE_USER', 'ROLE_ADMIN', 'ROLE_PROF'])])
                 ;
            $manager->persist($user);
            $manager->flush();
        }
    }
}