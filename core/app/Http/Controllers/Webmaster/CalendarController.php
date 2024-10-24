<?php

namespace App\Http\Controllers\Webmaster;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LoanRepaymentSchedule;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use PhpParser\Node\Stmt\TryCatch;

class CalendarController extends Controller
{
    //
    /**
     * Return calendar and its events
     *
     * @return void
     */
    public function index()
    {
        $page_title = 'Common Calendar';
        // $events = Event::all();
        // $calendar = Calendar::addEvents($events);
        return view('Webmaster.calendar.common_calendar', compact('page_title'));
    }

    public function index2()
    {
        $events = Event::all();
        $calendar = Calendar::addEvents($events);
        return view('webmaster.calendar.calendar', compact('calendar'));
    }
    /**
     * Fetch Calendar Events
     *
     * @return void
     */
    public function fetchEvents()
    {
        $repayments = LoanRepaymentSchedule::all();
          $events = $repayments->map(function ($schedule) {
            return [
                'title' => '(Member: ' . $schedule->member->fname.' '. $schedule->member->lname.')'.'Payment Due: ' .number_format($schedule->amount_due, 2, '.', ','),
                'start' => $schedule->due_date,
                'total_amount'=>number_format($schedule->loan->disbursment_amount, 2, '.', ','),
                'payment_amount'=>number_format($schedule->amount_due, 2, '.', ','),
                'member'=>$schedule->member->fname.' '. $schedule->member->lname
            ];
        });
        return response()->json($events);
    }
    /**
     * Store calendar events
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        try {
            $events = new Event();
            $events->title = $request->title;
            $events->start = $request->start;
            $events->end = $request->end;

            $events->save();
            return response()->json([
                'message' => true
            ], 201);
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'message' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update resource
     *
     * @param string $id
     * @return void
     */
    public function update(string $id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->title = request()->title;
            $event->start = request()->start;
            $event->end = request()->end;
            $event->save();
            return response()->json([
                'message' => true
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'message' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Destroy event
     *
     * @param string $id
     * @return void
     */
    public function destroy(string $id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->delete();
            return response()->json(['message' => true], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
