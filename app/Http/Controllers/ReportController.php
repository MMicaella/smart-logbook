<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Booking;
use App\Models\RequestItem;
use Carbon\Carbon;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\BorrowExport;
use App\Exports\BookingExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function borrowReport(Request $request)
    {
        $borrows = Borrow::with(['user', 'item'])
            ->whereMonth('created_at', $request->month ?? now()->month)
            ->whereYear('created_at', $request->year ?? now()->year)
            ->get();

        return view('reports.borrow', compact('borrows'));
    }

    public function bookingReport(Request $request)
    {
        $bookings = Booking::with('user')
            ->whereMonth('created_at', $request->month ?? now()->month)
            ->whereYear('created_at', $request->year ?? now()->year)
            ->get();

        return view('reports.booking', compact('bookings'));
    }

    public function requestReport()
    {
        $requests = RequestItem::with(['user', 'item'])->get();

        return view('reports.requests', compact('requests'));
    }

    /*
    |--------------------------------------------------------------------------
    | PDF EXPORTS
    |--------------------------------------------------------------------------
    */

    public function exportBorrowPdf()
    {
        $borrows = Borrow::with(['user', 'item'])->latest()->get();

        $pdf = Pdf::loadView(
            'reports.pdf.borrow',
            compact('borrows')
        );

        return $pdf->download('borrow-report.pdf');
    }

    public function exportBookingPdf()
    {
        $bookings = Booking::with(['user', 'vehicle'])->latest()->get();

        $pdf = Pdf::loadView(
            'reports.pdf.booking',
            compact('bookings')
        );

        return $pdf->download('booking-report.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | EXCEL EXPORTS
    |--------------------------------------------------------------------------
    */

    public function exportBorrowExcel()
    {
        return Excel::download(
            new BorrowExport,
            'borrow-report.xlsx'
        );
    }

    public function exportBookingExcel()
    {
        return Excel::download(
            new BookingExport,
            'booking-report.xlsx'
        );
    }
}