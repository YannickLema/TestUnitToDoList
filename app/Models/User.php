<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class User
{
    public $email;
    public $firstname;
    public $lastname;
    public $password;
    public $birthdate;

    public function __construct($attributes = [])
    {
        $this->email = $attributes['email'] ?? '';
        $this->firstname = $attributes['firstname'] ?? '';
        $this->lastname = $attributes['lastname'] ?? '';
        $this->password = $attributes['password'] ?? '';
        $this->birthdate = $attributes['birthdate'] ?? '';
    }

    public function isValid()
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL)
            && !empty($this->firstname)
            && !empty($this->lastname)
            && preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,40}$/', $this->password)
            && $this->getAge() >= 13;
    }

    private function getAge()
    {
        return Carbon::parse($this->birthdate)->age;
    }
}

