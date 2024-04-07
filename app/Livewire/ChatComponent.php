<?php

namespace App\Livewire;

use App\Events\SendMessageEvent;
use App\Models\Message;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatComponent extends Component
{
    public $messages;

    public $message;

    public function mount()
    {
        $this->messages = Message::with('user')->get()->toArray();
    }

    public function render()
    {
        return view('livewire.chat-component');
    }

    public function sendMessage()
    {
        SendMessageEvent::dispatch($this->message, auth()->user());
        $this->message = '';
    }

    #[On('echo:chat-channel,SendMessageEvent')]
    public function listenForMessage($data)
    {
        $this->messages[] = $data['sent_message'];
        $this->dispatch('send_message');
    }
}
