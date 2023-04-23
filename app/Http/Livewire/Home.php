<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;

class Home extends Component
{
    public $password = null;

    public $message = null;

    public $drafts = false;

    public function login()
    {
        if ($this->password == 'maggiebattmarch7') {
            auth()->login(User::find(2));
        } elseif ($this->password == 'mitchjam1928always') {
            auth()->login(User::find(1));
        } else {
            $this->addError('login', 'Wrong password');
        }
    }

    public function logout()
    {
        auth()->logout();
    }

    public function getDraftMessagesProperty()
    {
        return auth()->user()->messages()->latest()->whereNull('published_at')->get();
    }

    public function getMessagesProperty()
    {
        return Message::oldest()->whereNotNull('published_at')->get();
    }

    public function render()
    {
        return view('livewire.home');
    }

    public function saveDraftMessage()
    {
        $this->validate([
            'message' => 'required',
        ]);

        $message = auth()->user()->messages()->create([
            'message' => $this->message,
        ]);

        $this->message = '';

        $this->drafts = true;

        return $message;
    }

    public function savePublishedMessage()
    {
        $this->publish($this->saveDraftMessage()->id);
    }

    public function publish($id)
    {
        auth()->user()->messages()->find($id)->update(['published_at' => now()]);

        $this->drafts = false;
    }

    public function delete($id)
    {
        auth()->user()->messages()->find($id)->delete();
    }
}
