<div class="card card-heroes flex flex-col h-full">
    <div class="card-header-heroes flex justify-between items-center flex-wrap gap-4">
        <div>
            <h3 class="card-title-heroes">Attendance</h3>
            <p class="card-subtitle-heroes">Track and manage the attendance</p>
        </div>
        
        <div class="flex items-center gap-2">
            {{-- EXPORT BUTTON --}}
            <a href="#" class="btn-export mr-2">
                <i class="bi bi-upload"></i> Export
            </a>

            {{-- DYNAMIC FILTERS: YEAR AND MONTH --}}
            <select id="yearFilter" onchange="updateChart()" class="border border-gray-300 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 outline-none focus:border-[#67b69e] bg-white cursor-pointer">
                </select>

            <select id="monthFilter" onchange="updateChart()" class="border border-gray-300 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 outline-none focus:border-[#67b69e] bg-white cursor-pointer min-w-[120px]">
                <option value="all">Entire Year</option>
                <option value="0">January</option>
                <option value="1">February</option>
                <option value="2">March</option>
                <option value="3">April</option>
                <option value="4">May</option>
                <option value="5">June</option>
                <option value="6">July</option>
                <option value="7">August</option>
                <option value="8">September</option>
                <option value="9">October</option>
                <option value="10">November</option>
                <option value="11">December</option>
            </select>
        </div>
    </div>

    <div class="p-6 flex-grow relative">
        <div class="w-full h-[250px] mt-4">
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>
</div>

{{-- SCRIPT PARA SA DUAL-LINE CHART --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const rawData = {!! json_encode($rawAttendances) !!};
    let attendanceChart;
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    const yearSelect = document.getElementById('yearFilter');
    const currentYear = new Date().getFullYear();
    for (let y = 2020; y <= currentYear; y++) {
        yearSelect.add(new Option(y, y, false, y === currentYear));
    }
    document.getElementById('monthFilter').value = new Date().getMonth();

    function updateChart() {
        const selectedYear = parseInt(yearSelect.value);
        const selectedMonth = document.getElementById('monthFilter').value;
        
        let labels = [];
        let memberData = [];
        let guestData = [];

        if (selectedMonth === 'all') {
            labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            memberData = Array(12).fill(0);
            guestData = Array(12).fill(0);

            rawData.forEach(record => {
                const date = new Date(record.date);
                if (date.getFullYear() === selectedYear) {
                    const mIndex = date.getMonth();
                    record.is_guest ? guestData[mIndex]++ : memberData[mIndex]++;
                }
            });
        } else {
            // FILTER BY SUNDAYS ONLY
            const monthInt = parseInt(selectedMonth);
            const daysInMonth = new Date(selectedYear, monthInt + 1, 0).getDate();
            
            let sundayIndices = {};
            let counter = 0;

            for(let i=1; i<=daysInMonth; i++) {
                let currentDate = new Date(selectedYear, monthInt, i);
                if (currentDate.getDay() === 0) { // Sunday
                    labels.push(`${monthNames[monthInt]} ${i}`);
                    memberData.push(0);
                    guestData.push(0);
                    sundayIndices[i] = counter;
                    counter++;
                }
            }

            rawData.forEach(record => {
                const date = new Date(record.date);
                if (date.getFullYear() === selectedYear && date.getMonth() === monthInt) {
                    const day = date.getDate();
                    if (sundayIndices[day] !== undefined) {
                        const targetIndex = sundayIndices[day];
                        record.is_guest ? guestData[targetIndex]++ : memberData[targetIndex]++;
                    }
                }
            });
        }

        renderChart(labels, memberData, guestData);
    }

    function renderChart(labels, memberData, guestData) {
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        
        if (attendanceChart) { attendanceChart.destroy(); }

        attendanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Total guest attendees',
                        data: guestData,
                        borderColor: '#b46221', 
                        backgroundColor: 'rgba(180, 98, 33, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#b46221',
                        pointRadius: 4,
                    },
                    {
                        label: 'Total member attendees',
                        data: memberData,
                        borderColor: '#205142',
                        backgroundColor: 'rgba(32, 81, 66, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#205142',
                        pointRadius: 4,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#333',
                        bodyColor: '#666',
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        padding: 12,
                        usePointStyle: true
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { borderDash: [5, 5] },
                        ticks: { stepSize: 10 } // <-- ITO ANG MAGBIBIGAY NG 10 INTERVALS
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    document.addEventListener("DOMContentLoaded", updateChart);
</script>