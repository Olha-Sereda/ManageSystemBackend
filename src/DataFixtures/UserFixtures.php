<?php
/**
 * User fixtures.
 */

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Tests;
use App\Entity\Server;
use App\Entity\Service;
use App\Entity\Enum\UserRole;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends AbstractBaseFixtures
{
     /**
     * Password hasher.
     */
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * @param UserPasswordHasherInterface $passwordHasher Password hasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    protected function loadData(): void
    {

        $this->createMany(10, 'users', function (int $i) {
            $user = new User();
            $user->setEmail(sprintf('user%d@example.com', $i));
            $user->setRoles([UserRole::ROLE_USER->value]);
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    'user1234'
                )
            );
            $user->setUserName('Oleksii');
            $user->setUserSurname('Sereda');

            return $user;
        });

        $this->createMany(3, 'admins', function (int $i) {
            $user = new User();
            $user->setEmail(sprintf('admin%d@example.com', $i));
            $user->setRoles([UserRole::ROLE_USER->value, UserRole::ROLE_ADMIN->value]);
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    'admin1234'
                )
            );
            $user->setUserName('Ola');
            $user->setUserSurname('Sereda');
            return $user;
        });

        $this->manager->flush();

        $user1 = $this->manager->getRepository(User::class)->findOneBy(['email' => 'user0@example.com']);
//        $userId = $user ? $user->getId() : null;
        
        $test1 = new Tests();
        $test1->setTestName('Service available');
        $test1->setTestCode("if [ -z `ps afx| grep \"/home/epi/21_sereda/G_projekt/app.py\" | grep -v grep | awk ' { print $1 } '` ]; then echo -n \"false\"; else echo -n \"true\"; fi");
        $test1->setDatetimeUpdate(null);
        $test1->setEnabled(true);
        $test1->setExpectedAnswer('true');
        $test1->setUserId($user1);
        $this->manager->persist($test1);

        $test2 = new Tests();
        $test2->setTestName('Port Listening');
        $test2->setTestCode('ss -nltp | grep 12140 | awk \' { print $4 } \' | cut -f2 --delimiter=":" ');
        $test2->setDatetimeUpdate(null);
        $test2->setEnabled(true);
        $test2->setExpectedAnswer('12140');
        $test2->setUserId($user1);
        $this->manager->persist($test2);

        // $test3 = new Tests();
        // $test3->setTestName('Algebra');
        // $test3->setTestCode('Code code code code code code code code code code code code code code code code code code ');
        // $test3->setDatetimeUpdate(null);
        // $test3->setEnabled(true);
        // $test3->setUserId($user1);
        // $this->manager->persist($test3);

        $this->manager->flush();
    }
}
