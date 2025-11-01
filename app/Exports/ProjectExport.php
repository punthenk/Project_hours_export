<?php

namespace App\Exports;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectExport implements FromArray, WithStyles, WithColumnWidths
{

    protected $project;
    protected $weekNumber;
    protected $year;
    protected $includeWeekend;


    public function __construct(Project $project, $weekNumber = null, $year = null, $includeWeekend = false)
    {
        $this->project = $project;
        $this->weekNumber = $weekNumber ?? date('W');
        $this->year = $year ?? date('Y');
        $this->includeWeekend = $includeWeekend;

        Log::debug($this->weekNumber);
        Log::debug($this->year);
        Log::debug($this->includeWeekend);
        Log::debug($this->project);
    }

    public function array(): array
    {

        $weekDates = $this->getWeekDateRange($this->year, $this->weekNumber, $this->includeWeekend);
        Log::debug($weekDates);

        $sessions = $this->project->tasks()
            ->with('workedSession')
            ->get()
            ->flatMap(function ($task) use ($weekDates) {
                return $task->workedSession
                    ->filter(function ($session) use ($weekDates) {
                        $sessionDate = Carbon::parse($session->created_at);
                        return $sessionDate->between($weekDates['start'], $weekDates['end']);
                    })
                    ->map(function ($session) use ($task) {
                        $session->task_name = $task->name;
                        return $session;
                    });
            });

        Log::debug($sessions);

        $groupedByDay = $sessions->groupBy(function ($session) {
            return Carbon::parse($session->created_at)->locale('nl')->dayName;
        });

        // If the weekend days are included there is a different array used
        $dutchDays = $this->includeWeekend
            ? ['maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag', 'zondag']
            : ['maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag'];

        $rows = [];

        $rows[] = ['Naam: ', auth()->user()->name];
        $rows[] = ['Periode: ', 'Week '. $this->weekNumber . ' - ' . $this->year];
        $rows[] = ['Module: ', $this->project->name];
        $rows[] = [''];
        $rows[] = [''];

        $rows[] = ['', 'Gewerkt van', 'Gewerkt tot', 'Werkzaamheden', 'Uren'];

        foreach ($dutchDays as $day) {
            // Capitalize for display in Excel
            $rows[] = [ucfirst($day), '', '', ''];

            if ($groupedByDay->has($day)) {
                foreach ($groupedByDay[$day] as $session) {
                    $rows[] = [
                        '',
                        $session->started_at,
                        $session->stopped_at,
                        $session->task_name,
                        $this->calculateHours($session->started_at, $session->stopped_at)
                    ];
                }
            } else {
                $rows[] = ['', '', '', ''];
                $rows[] = ['', '', '', ''];
            }

            $rows[] = ['Conclusie ' . $day . ':', '', '', ''];
            $rows[] = ['', '', '', ''];
        }

        $rows[] = [''];
        $rows[] = [''];

        $totalHours = $this->calculateTotalHours($sessions);
        $rows[] = ['', '', '', 'Totaal gewerkte uren*:', $totalHours];


        $rows[] = ['Conclusie week:'];
        $rows[] = [''];
        $rows[] = ['Planning volgende week:'];

        return $rows;
    }

    private function getWeekDateRange($year, $week, $includeWeekend): array
    {
        $start = Carbon::now();
        $start->setISODate($year, $week);
        $start->startOfWeek();

        $end = Carbon::now();
        $end->setISODate($year, $week);
        if ($includeWeekend) {
            $end->endOfWeek();
        } else {
            $end->next(Carbon::FRIDAY)->endOfDay();
        }

        return [
            'start' => $start,
            'end' => $end
        ];
    }

    /**
     * Calculate total hours from sessions
     */
    private function calculateTotalHours($sessions): string
    {
        $totalMinutes = 0;

        foreach ($sessions as $session) {
            $start = Carbon::parse($session->started_at);
            $end = Carbon::parse($session->stopped_at);
            $totalMinutes += $start->diffInMinutes($end);
        }

        $hours = intdiv($totalMinutes, 60);
        $minutes = $totalMinutes % 60;

        return $hours . 'u ' . $minutes . 'm';
    }

    /**
     * Calculate hours between two times
     */
    private function calculateHours($startTime, $endTime): string
    {
        // Parse the times
        $start = Carbon::parse($startTime);
        $end = Carbon::parse($endTime);

        // Calculate difference in hours and minutes
        $hours = $start->diffInHours($end, true);
        $minutes = $start->diffInMinutes($end) % 60;

        // Return formatted as "2u 30m"
        return (int)$hours . 'u ' . $minutes . 'm';
    }

    /**
     * Style the worksheet
     */
    public function styles(Worksheet $sheet)
    {
        $bold = ['font' => ['bold' => true, 'size' => 12]];
        return [
            'A1:A3' => $bold,
            6 => $bold,
            'D37' => $bold,
            /* 'A7' => $bold,  // Maandag */
            /* 'A11' => $bold, // Disdag */
            /* 'A16' => $bold, // Woensdag */
            /* 'A21' => $bold, // Donderdag */
            /* 'A29' => $bold, // Vrijdag */
        ];
    }

    /**
     * Set column widths for readability
     */
    public function columnWidths(): array
    {
        return [
            'B' => 15, // Van
            'C' => 15, // Tot
            'D' => 40, // Werkzaamheden
            'F' => 15, // Uren
        ];
    }
}
