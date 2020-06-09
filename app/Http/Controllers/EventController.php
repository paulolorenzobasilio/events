<?php

namespace App\Http\Controllers;

use App\Model\Event;

class EventController extends Controller
{
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function index(){
        return $this->event->all();
    }

    public function store(){
        $this->event->date = request()->date;
        $this->event->save();
    }
}
