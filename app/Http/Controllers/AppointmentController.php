<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->role === 'expert') {
            return redirect()->route('expert.appointments');
        }

        $appointments = Appointment::where('user_id', auth()->id())->with('expert')->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        if (auth()->user()->role === 'expert') {
            return redirect()->route('expert.appointments')
                ->with('error', 'Experts cannot create appointments.');
        }

        $experts = User::where('role', 'expert')->get();
        return view('appointments.create', compact('experts'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role === 'expert') {
            return redirect()->route('expert.appointments')
                ->with('error', 'Experts cannot create appointments.');
        }

        $request->validate([
            'expert_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:now',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Verify the selected user is an expert
        $expert = User::where('id', $request->expert_id)
            ->where('role', 'expert')
            ->firstOrFail();

        $appointment = Appointment::create([
            'user_id' => auth()->id(),
            'expert_id' => $expert->id,
            'appointment_date' => Carbon::parse($request->appointment_date),
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment booked successfully. The expert will review your request.');
    }

    public function show(Appointment $appointment)
    {
        // Check if the user has permission to view this appointment
        if (auth()->id() !== $appointment->user_id && 
            (auth()->user()->role !== 'expert' || auth()->id() !== $appointment->expert_id)) {
            abort(403, 'Unauthorized action.');
        }

        return view('appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        // Only experts can update appointment status
        if (auth()->user()->role !== 'expert' || auth()->id() !== $appointment->expert_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $appointment->update([
            'status' => $request->status
        ]);

        return redirect()->route('expert.appointments')
            ->with('success', 'Appointment status updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        // Only the user who created the appointment can cancel it
        if (auth()->id() !== $appointment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Only pending appointments can be cancelled
        if ($appointment->status !== 'pending') {
            return redirect()->route('appointments.index')
                ->with('error', 'Only pending appointments can be cancelled.');
        }

        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }

    public function expertAppointments()
    {
        if (auth()->user()->role !== 'expert') {
            return redirect()->route('appointments.index')
                ->with('error', 'Only experts can access this page.');
        }

        $appointments = Appointment::where('expert_id', auth()->id())
            ->with('user')
            ->latest()
            ->get();

        return view('appointments.expert-index', compact('appointments'));
    }
} 