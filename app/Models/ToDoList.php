<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\EmailSenderService;
use Exception;

class ToDoList extends Model
{
    public $user;
    public $items = [];
    public $emailService;

    public function __construct(User $user, EmailSenderService $emailService)
    {
        $this->user = $user;
        $this->emailService = $emailService;
    }

    public function addItem(Item $item)
    {
        if (!$this->user->isValid()) {
            throw new Exception("User is not valid.");
        }

        if (count($this->items) >= 10) {
            throw new Exception("ToDoList cannot contain more than 10 items.");
        }

        // if (count($this->items) > 0 && $item->created_at->diffInMinutes(end($this->items)->created_at) < 30) {
        //     throw new Exception("Must wait 30 minutes before adding another item.");
        // }

        $this->items[] = $item;

        if (count($this->items) == 8) {
            $this->emailService->send($this->user);
        }
    }

    public function storeItem()
    {
        throw new SaveException("Save operation is not supported.");
    }
}