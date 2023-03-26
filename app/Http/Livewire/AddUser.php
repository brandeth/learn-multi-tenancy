<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddUser extends Component
{
    use WithFileUploads;

    public $name = "Kushna Depulso";
    public $email = "kushna@depulso";
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
            'photo' => 'image|max:1024', // 1MB Max
        ]);

        $filename = $this->photo->store('public');
        $filename = substr($filename, strpos($filename, "/") + 1);
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'department' => $this->department,
            'title' => $this->title,
            'status' => $this->status,
            'role' => $this->role,
            'photo' => $filename,
            'password' => bcrypt(Str::random(16)),
        ]);

        session()->flash('success', 'We Did It');
    }

    public function render()
    {
        return view('livewire.add-user');
    }
}
