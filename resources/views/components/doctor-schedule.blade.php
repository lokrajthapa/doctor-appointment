@if ($getState())
    <ul class="list-disc pl-5">
        @foreach ($getState() as $schedule)
            <li>Date:{{ $schedule->date }} Start Time- {{ $schedule->start_time }} And End Time- {{ $schedule->end_time }}</li>
        @endforeach
    </ul>
@else

    <p class="bg-green-400">First Select Department and Doctor to view Schedule  available for  doctor.</p>

@endif
