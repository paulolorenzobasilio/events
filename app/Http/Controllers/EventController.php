<?php

namespace App\Http\Controllers;

use App\Model\Event;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function index()
    {
        return $this->event->all();
    }

    public function store()
    {
        DB::transaction(function () {
            DB::table('events')->delete();
            $date = request()->date;
            foreach ($date as $value) {
                $this->event->create(['date' => $value]);
            }
        });

        return response()->json([], 201);
    }
}
