<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SuperAdminAndRolesFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        // roles
        $roleAdmin = new Role();
        $rolePartner = new Role();
        $roleSuper = new Role();

        $roleSuper->setName('Super Admin');
        $roleAdmin->setName('Admin');
        $rolePartner->setName('Partner');

        $manager->persist($roleAdmin);
        $manager->persist($rolePartner);
        $manager->persist($roleSuper);

        $super = new User();
        $super->setEmail('super@test.mail');
        $super->setPassword($this->encoder->encodePassword($super, 'super'));
        $super->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($super);

        $manager->flush();
    }
}
