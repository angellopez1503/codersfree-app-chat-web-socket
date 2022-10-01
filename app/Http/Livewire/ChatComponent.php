<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;

class ChatComponent extends Component
{

    public $search;

    public $contactChat,$chat;

    //Propiedad computada
    public function getContactsProperty(){

        return Contact::where('user_id',auth()->id())
                ->when($this->search,function($query){

                    $query->where(function($query){
                        $query->where("name",'like','%'.$this->search.'%')
                        ->orWhereHas('user',function($query){
                            $query->where('email','like','%'.$this->search.'%');
                        });
                    });
                })
                ->get() ?? [];
    }

    public function open_chat_contact(Contact $contact){

        $chat = auth()->user()->chats()
        ->whereHas('users',function($query) use ($contact){
            $query->where('user_id',$contact->contact_id);
        })
        ->has('users',2)
        ->first();

        if($chat){
            $this->chat = $chat;
        }else{
            $this->contactChat=$contact;
        }

    }

    public function render()
    {
        return view('livewire.chat-component')->layout('layouts.chat');
    }
}
