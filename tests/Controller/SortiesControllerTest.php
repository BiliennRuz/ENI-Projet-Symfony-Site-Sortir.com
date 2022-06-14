<?php

namespace App\Test\Controller;

use App\Entity\Sorties;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SortiesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/sortie/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = (static::getContainer()->get('doctrine'))->getManager();
        $this->repository = $this->manager->getRepository(Sorties::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Sorty index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'sorty[nom]' => 'Testing',
            'sorty[datedebut]' => 'Testing',
            'sorty[duree]' => 'Testing',
            'sorty[datecloture]' => 'Testing',
            'sorty[nbinscriptionsmax]' => 'Testing',
            'sorty[descriptioninfos]' => 'Testing',
           
            'sorty[urlphoto]' => 'Testing',
            'sorty[etatsNoEtat]' => 'Testing',
            'sorty[organisateur]' => 'Testing',
            'sorty[lieuxNoLieu]' => 'Testing',
            'sorty[participantsNoParticipant]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Sorties();
        $fixture->setNom('My Title');
        $fixture->setDatedebut('My Title');
        $fixture->setDuree('My Title');
        $fixture->setDatecloture('My Title');
        $fixture->setNbinscriptionsmax('My Title');
        $fixture->setDescriptioninfos('My Title');
       
        $fixture->setUrlphoto('My Title');
        $fixture->setEtatsNoEtat('My Title');
        $fixture->setOrganisateur('My Title');
        $fixture->setLieuxNoLieu('My Title');
        $fixture->setParticipantsNoParticipant('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Sorty');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Sorties();
        $fixture->setNom('Value');
        $fixture->setDatedebut('Value');
        $fixture->setDuree('Value');
        $fixture->setDatecloture('Value');
        $fixture->setNbinscriptionsmax('Value');
        $fixture->setDescriptioninfos('Value');
       
        $fixture->setUrlphoto('Value');
        $fixture->setEtatsNoEtat('Value');
        $fixture->setOrganisateur('Value');
        $fixture->setLieuxNoLieu('Value');
        $fixture->setParticipantsNoParticipant('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'sorty[nom]' => 'Something New',
            'sorty[datedebut]' => 'Something New',
            'sorty[duree]' => 'Something New',
            'sorty[datecloture]' => 'Something New',
            'sorty[nbinscriptionsmax]' => 'Something New',
            'sorty[descriptioninfos]' => 'Something New',
           
            'sorty[urlphoto]' => 'Something New',
            'sorty[etatsNoEtat]' => 'Something New',
            'sorty[organisateur]' => 'Something New',
            'sorty[lieuxNoLieu]' => 'Something New',
            'sorty[participantsNoParticipant]' => 'Something New',
        ]);

        self::assertResponseRedirects('/sortie/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getDatedebut());
        self::assertSame('Something New', $fixture[0]->getDuree());
        self::assertSame('Something New', $fixture[0]->getDatecloture());
        self::assertSame('Something New', $fixture[0]->getNbinscriptionsmax());
        self::assertSame('Something New', $fixture[0]->getDescriptioninfos());
      
        self::assertSame('Something New', $fixture[0]->getUrlphoto());
        self::assertSame('Something New', $fixture[0]->getEtatsNoEtat());
        self::assertSame('Something New', $fixture[0]->getOrganisateur());
        self::assertSame('Something New', $fixture[0]->getLieuxNoLieu());
        self::assertSame('Something New', $fixture[0]->getParticipantsNoParticipant());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Sorties();
        $fixture->setNom('Value');
        $fixture->setDatedebut('Value');
        $fixture->setDuree('Value');
        $fixture->setDatecloture('Value');
        $fixture->setNbinscriptionsmax('Value');
        $fixture->setDescriptioninfos('Value');
     
        $fixture->setUrlphoto('Value');
        $fixture->setEtatsNoEtat('Value');
        $fixture->setOrganisateur('Value');
        $fixture->setLieuxNoLieu('Value');
        $fixture->setParticipantsNoParticipant('Value');

        $$this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/sortie/');
        self::assertSame(0, $this->repository->count([]));
    }
}
