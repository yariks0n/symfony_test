<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $name_array = array("Vova", "Sasha");

        foreach ($name_array as $user_name)
        {
            $user = new User();
            $user->setName($user_name);
            $manager->persist($user);
            $manager->flush();

            $account = new Account();
            $account->setUser($user);
            $account->setValue(1000);
            $manager->persist($account);
            $manager->flush();
        }
    }
}
