<x-filament::page>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <h1 class="text-2xl font-bold mb-6 text-center"> {{ now()->toDateString() }}</h1>

    <!-- Search Box -->
    <div class="mb-4">
        <input type="text" id="search-input" placeholder="Search by name..." 
            class="w-full px-4 py-2 rounded border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    </div>
       <!-- Success Message -->
   

    <!-- Validation Errors -->
    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('mark-attendance.store') }}">
        @csrf
        <table id="attendance-table" class="table-auto w-full border-collapse">
            <thead>
                <tr>
                    <th class="border px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-200">Name</th>
                    <th class="border px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-200">Date</th>
                    <th class="border px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-200">Hours Worked</th>
                    <th class="border px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-200">Overtime Hours</th>
                    <th class="border px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-200">Weekend</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $employees = \App\Models\Employees::all();
                    $savedAttendance = \App\Models\Pointage::whereIn('employee_id', $employees->pluck('id'))->get();
                @endphp
                @foreach($employees as $employee)
                @php
                    $attendance = $savedAttendance->firstWhere('employee_id', $employee->id);
                @endphp
                <tr>
                    <td class="border px-4 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 employee-name">
                        {{ $employee->full_name }}
                    </td>
                    <td class="border px-4 py-2 bg-white dark:bg-gray-900">
                        <input type="date" class="date-input w-full bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border dark:border-gray-700 rounded" 
                            name="attendance[{{ $employee->id }}][date]" 
                            value="{{ $attendance->date ?? now()->toDateString() }}">
                    </td>
                    <td class="border px-4 py-2 bg-white dark:bg-gray-900">
                        <input type="number" class="w-full bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border dark:border-gray-700 rounded" 
                            name="attendance[{{ $employee->id }}][hours_worked]" 
                            step="0.01" 
                            value="{{ $attendance->hours_worked ?? 0 }}">
                    </td>
                    <td class="border px-4 py-2 bg-white dark:bg-gray-900">
                        <input type="number" class="w-full bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border dark:border-gray-700 rounded" 
                            name="attendance[{{ $employee->id }}][overtime_hours]" 
                            step="0.01" 
                            value="{{ $attendance->overtime_hours ?? 0 }}">
                    </td>
                    <td class="border px-4 py-2 bg-white dark:bg-gray-900 text-center">
                        <input type="checkbox" class="weekend-checkbox w-5 h-5" 
                            name="attendance[{{ $employee->id }}][is_weekend]" 
                            {{ isset($attendance->is_weekend) && $attendance->is_weekend ? 'checked' : '' }}>
                    </td>
                </tr>
            @endforeach
            
            </tbody>
        </table>
        <button type="submit" 
            class="btn mt-6 px-4 py-4 rounded bg-gray-400 text-gray-100 ">
            Submit Attendance
        </button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Search functionality
            const searchInput = document.getElementById('search-input');
            const tableRows = document.querySelectorAll('#attendance-table tbody tr');

            searchInput.addEventListener('input', (event) => {
                const searchTerm = event.target.value.toLowerCase();
                tableRows.forEach(row => {
                    const nameCell = row.querySelector('.employee-name').textContent.toLowerCase();
                    row.style.display = nameCell.includes(searchTerm) ? '' : 'none';
                });
            });

            // Attach change event listener to all date inputs
            const dateInputs = document.querySelectorAll(".date-input");
            dateInputs.forEach((dateInput) => {
                dateInput.addEventListener("change", (event) => {
                    const dateValue = new Date(event.target.value);
                    const isSunday = dateValue.getDay() === 0; // Sunday = 0

                    // Find the corresponding checkbox
                    const row = event.target.closest("tr");
                    const weekendCheckbox = row.querySelector(".weekend-checkbox");

                    // Check the checkbox if it's Sunday, uncheck otherwise
                    weekendCheckbox.checked = isSunday;
                });
            });
        });
    </script>
</x-filament::page>