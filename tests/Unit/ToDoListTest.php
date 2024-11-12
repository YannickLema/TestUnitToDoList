<?php
namespace Tests\Unit;

use App\Models\User;
use App\Models\ToDoList;
use App\Models\Item;
use App\Services\EmailSenderService;
use PHPUnit\Framework\TestCase;

class ToDoListTest extends TestCase
{
    public function testNoEmailSentForFirstSevenItems()
    {
        $user = new User([
            'email' => 'test@example.com',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'password' => 'Password123',
            'birthdate' => '2000-01-01'
        ]);

        // Mock d'EmailSenderService avec une attente de 0 appel pour 'send'
        $emailServiceMock = $this->createMock(EmailSenderService::class);
        $emailServiceMock->expects($this->never()) // Vérifie que send() n'est pas appelé
                        ->method('send');

        $list = new ToDoList($user, $emailServiceMock);

        // Ajoute 7 items avec un décalage de 30 minutes chacun
        for ($i = 0; $i < 7; $i++) {
            $item = new Item("Task $i", "Content $i");
            $item->created_at = now()->subMinutes(30 * (7 - $i));
            $list->addItem($item);
        }
    }

    public function testEmailSentOnEighthItem()
    {
        $user = new User([
            'email' => 'test@example.com',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'password' => 'Password123',
            'birthdate' => '2000-01-01'
        ]);

        // Mock d'EmailSenderService avec une attente d'appel une fois pour 'send'
        $emailServiceMock = $this->createMock(EmailSenderService::class);
        $emailServiceMock->expects($this->once()) // Vérifie que send() est appelé une fois
                        ->method('send')
                        ->with($user);

        $list = new ToDoList($user, $emailServiceMock);

        // Ajoute 8 items avec un décalage de 30 minutes chacun
        for ($i = 0; $i < 8; $i++) {
            $item = new Item("Task $i", "Content $i");
            $item->created_at = now()->subMinutes(30 * (8 - $i));
            $list->addItem($item);
        }
    }

    public function testSaveMethodThrowsException()
    {
        $user = new User([
            'email' => 'test@example.com',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'password' => 'Password123',
            'birthdate' => '2000-01-01'
        ]);
    
        $emailServiceMock = $this->createMock(EmailSenderService::class);
    
        // Passe les arguments requis au constructeur
        $list = $this->getMockBuilder(ToDoList::class)
                     ->setConstructorArgs([$user, $emailServiceMock])
                     ->onlyMethods(['storeItem'])
                     ->getMock();
    
        $list->expects($this->once())
             ->method('storeItem')
             ->will($this->throwException(new \Exception("Cannot save")));
    
        $this->expectException(\Exception::class);
        $list->storeItem();
    }
}
