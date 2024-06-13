<?php
/**
 * Data fixtures.
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

class DataFixtures extends AbstractBaseFixtures
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
        // add test users: user0-user9
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

        // add test admins: admin0-admin9
        $this->createMany(3, 'admins', function (int $i) {
            $user = new User();
            $user->setEmail(sprintf('admin%d@example.com', $i));
            $user->setRoles([UserRole::ROLE_ADMIN->value]);
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

        //add servers
        $server1 = new Server();
        $server1->setServerName('Wierzba');
        $server1->setFqdn('wierzba.wzks.uj.edu.pl');
        $server1->setPort('22');
        $server1->setLogin('21_sereda');
        $server1->setPasswordKey('U8x3g2r8a2');
        $this->manager->persist($server1);
        $this->manager->flush();

        //add services
        $service1 = new Service();
        $service1->setServiceName('Service Saboteur');
        $service1->setServerId($server1);
        $service1->setStartCmd('/home/epi/21_sereda/G_projekt/start_saboteur.sh start');
        $service1->setStopCmd('/home/epi/21_sereda/G_projekt/start_saboteur.sh stop');
        $service1->setRun(false);
        $this->manager->persist($service1);

        //get user for tests
        $user1 = $this->manager->getRepository(User::class)->findOneBy(['email' => 'admin0@example.com']);
        
        //add tests
        $test1 = new Tests();
        $test1->setTestName('Service available');
        $test1->setTestCode("if [ -z `ps afx| grep \"/home/epi/21_sereda/G_projekt/app.py\" | grep -v grep | awk ' { print $1 } '` ]; then echo -n \"false\"; else echo -n \"true\"; fi");
        $test1->setDatetimeUpdate(null);
        $test1->setEnabled(true);
        $test1->setExpectedAnswer('true');
        $test1->setUserId($user1);
        $this->manager->persist($test1);
        $service1->addRelationServiceTest($test1);  //add relation between service and test
    
        $test2 = new Tests();
        $test2->setTestName('Port Listening');
        $test2->setTestCode('ss -nltp | grep 12140 | awk \' { print $4 } \' | cut -f2 --delimiter=":" ');
        $test2->setDatetimeUpdate(null);
        $test2->setEnabled(true);
        $test2->setExpectedAnswer('12140');
        $test2->setUserId($user1);
        $this->manager->persist($test2);
        $service1->addRelationServiceTest($test2);   //add relation between service and test

        $this->manager->flush();
    }
}
