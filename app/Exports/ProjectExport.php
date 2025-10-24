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

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function array(): array
    {
        $sessions = $this->project->tasks()
            ->with('workedSession')
            ->get()
            ->flatMap(function ($task) {
                return $task->workedSession->map(function ($session) use ($task) {
                    $session->task_name = $task->name;
                    return $session;
                });
            });

        $groupedByDay = $sessions->groupBy(function ($session) {
            return Carbon::parse($session->created_at)->locale('nl')->dayName;
        });

        // Use lowercase days to match
        $dutchDays = ['maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag'];

        $rows = [];

        $rows[] = ['Naam: ', auth()->user()->name];
        $rows[] = ['Periode: ', 'Week '. date("W", time())];
        $rows[] = ['Module: ', $this->project->name];
        $rows[] = [''];
        $rows[] = [''];

        $rows[] = ['', 'Gewerkt van', 'Gewerkt tot', 'Werkzaamheden', 'Uren'];

        foreach ($dutchDays as $day) {
            // Capitalize for display in Excel
            $rows[] = [ucfirst($day), '', '', ''];

            // Check lowercase
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
        $rows[] = ['', '', '', 'Totaal gewerkte uren*:', $this->project->total_worked_time];


        $rows[] = ['Conclusie week:'];
        $rows[] = [''];
        $rows[] = ['Planning volgende week:'];

        return $rows;
    }

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
            'A7' => $bold,  // Maandag
            'A11' => $bold, // Disdag
            'A16' => $bold, // Woensdag
            'A21' => $bold, // Donderdag
            'A29' => $bold, // Vrijdag
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
