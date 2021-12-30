<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ProjectTest extends WebTestCase
{
    public function testProjectList(): void
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/projects');

        $this->assertResponseIsSuccessful();
        $this->assertCount(25, $crawler->filter('.project'));
    }

    public function testProjectFilter(): void
    {
        $client  = static::createClient();
        $client->request('GET', '/project');
        $client->submitForm('Create', [
            'project[name]'             => 'xxxxx',
            'project[amount][value]'    => '111',
            'project[amount][currency]' => '$',
            'project[startDate][year]'  => '2021',
            'project[startDate][month]' => '12',
            'project[startDate][day]'   => '30',
        ]);

        $crawler = $client->request('GET', '/projects?project_filter_type%5Bname%5D=xxxxx');
        $this->assertCount(1, $crawler->filter('.project'));
    }

    public function testNewProject(): void
    {
        $crawler = $this->createClient();
        $crawler->request('GET', '/project');
        $this->assertResponseIsSuccessful();

        $crawler->submitForm('Create', [
            'project[name]'             => 'testProject',
            'project[amount][value]'    => '11',
            'project[amount][currency]' => '$',
            'project[startDate][year]'  => '2021',
            'project[startDate][month]' => '12',
            'project[startDate][day]'   => '30',
        ]);
        $crawler = $crawler->request('GET', '/projects?project_filter_type%5Bname%5D=testProject');
        $this->assertCount(1, $crawler->filter('.project'));
    }

    public function testProjectInfoCommand()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('projects:info');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Total projects found: 50.', $output);
    }
}
