<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddUser extends Component
{
    public $name = "Kushna Lumos";
    public $email = "kushna@lumos.com";
    public $department = 'information_technology';
    public $title = "Developer";
    public $photo;
    public $status = 1;
    public $role = 'admin';

    public function submit()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'department' => 'required|string',
            'title' => 'required|string',
            'status' => 'required|boolean',
            'role' => 'required|string',
        ]);

    }

    public function render()
    {
        return view('livewire.add-user');
    }
}