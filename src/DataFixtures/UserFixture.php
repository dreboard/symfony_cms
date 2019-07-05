<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /** @var Factory  */
    protected $faker;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = $faker = Factory::create();
    }


    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 7; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email);
            $encoded = $this->encoder->encodePassword($user, 'password');
            $user->setPassword($encoded);
            $manager->persist($user);
        }

        $user = new User();
        $user->setEmail('admin1@gmail.com');
        $encoded = $this->encoder->encodePassword($user, 'password');
        $user->setPassword($encoded);
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $manager->flush();
    }
}
