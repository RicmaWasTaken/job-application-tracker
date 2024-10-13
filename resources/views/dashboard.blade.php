<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex-1 min-h-full flex flex-col">
        <div class="w-full mx-auto sm:px-6 lg:px-8 h-full flex flex-1">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg flex-1">
                <div class="p-6 text-gray-900 h-full flex flex-col gap-6 box-border">
                    <div class="flex flex-row justify-between flex-1 gap-6">
                        <div class="relative bg-white sm:rounded-lg p-4 w-4/12">
                            <div class="absolute top-4 right-4 flex flex-row bg-cyan-300 h-max w-max rounded-sm">
                                <div class="p-1 hover:cursor-pointer" onclick="switchChart()"><</div>
                                <div class="p-1 hover:cursor-pointer" onclick="switchChart()">></div>
                            </div>
                            <div id="chart-container" class="h-full">
                                <div id="weekly-container">
                                    <p>Weekly stats ({{$weeklyDates}})</p>
                                    <div class="flex max-h-72 w-full justify-center">
                                        <canvas id="weekly-stats" width="200px" height="200px"></canvas>
                                    </div>
                                </div>
                                <div id="lifetime-container" class="hidden">
                                    <p>Lifetime stats</p>
                                    <div class="flex max-h-72 w-full justify-center">
                                        <canvas id="lifetime-stats" width="200px" height="200px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white sm:rounded-lg p-4 w-4/12">
                            <p>All-time stats A TABLE WITH NUMBERS LIKE MINECRAFT STATS SCREEN NOT A GRAPH</p>
                        </div>
                        <div class="bg-white sm:rounded-lg p-4 w-4/12">
                            <p>To-do <b>(feature not available yet)</b></p>
                        </div>
                    </div>
                    <div class="bg-white sm:rounded-lg p-4 flex-1">
                        <p>Latest applications</p>
                        @if (isset($lastApplications))
                        <div class="flex flex-row h-[calc(100%-1.5rem)] max-w-[calc(100%-1.5rem)] gap-8">
                            @foreach ($lastApplications as $application)
                            <div class="h-full flex-1 flex flex-col p-3 box-border sm:rounded-lg hover:bg-indigo-400 transition-all">
                                <a href="/applications/{{ $application->id }}" class="h-full w-full flex flex-col gap-6 justify-center">
                                    <p class="text-2xl text-center">{{$application->company_name}}</p>
                                    <p class=" text-lg text-center">{{$application->location}}</p>
                                    <p class="text-1xl text-center">{{$application->days_ago}}</p>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        function switchChart() {
            const weekly = document.getElementById('weekly-container');
            const lifetime = document.getElementById('lifetime-container');
            if (weekly.style.display === 'none') {
                weekly.style.display = 'block';
                lifetime.style.display = 'none';
            } else {
                weekly.style.display = 'none';
                lifetime.style.display = 'block';
            }
        }

        const weeklyApplications = {!! json_encode($weeklyApplications) !!}; //[accepted, rejected, waiting] -> follows alphabetical order
        const lifetimeApplications = {!! json_encode($lifetimeApplications) !!}
        const ctxWeekly = document.getElementById('weekly-stats').getContext('2d');
        const ctxLifetime = document.getElementById('lifetime-stats').getContext('2d');
        const colors = {
            accepted: '#5BC269',
            rejected: '#E46773',
            waiting: '#FCBA37',
        }
        const weeklyChart = new Chart(ctxWeekly, {
            type: 'doughnut',
            data: {
                labels: ['Accepted', 'Rejected', 'Waiting'],
                datasets: [{
                    label: 'Applications',
                    data: weeklyApplications,
                    backgroundColor: [
                        colors.accepted,
                        colors.rejected,
                        colors.waiting,
                    ],
                    borderColor: [
                        colors.accepted,
                        colors.rejected,
                        colors.waiting,
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                cutout: '50%', // Play with the donut effect 
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                    },
                }
            }
        });
        const lifetimeChart = new Chart(ctxLifetime, {
            type: 'doughnut',
            data: {
                labels: ['Accepted', 'Rejected', 'Waiting'],
                datasets: [{
                    label: 'Applications',
                    data: lifetimeApplications, // Bogus data to serve as a placeholder while I set up the controller function
                    backgroundColor: [
                        colors.accepted,
                        colors.rejected,
                        colors.waiting,
                    ],
                    borderColor: [
                        colors.accepted,
                        colors.rejected,
                        colors.waiting,
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                cutout: '50%', // Play with the donut effect 
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                    },
                }
            }
        });
    </script>
</x-app-layout>