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
                        <div class="flex flex-col relative bg-white sm:rounded-lg w-4/12">
                            <div id="chart-labels" class="flex flex-row">
                                <div class="flex flex-col justify-center items-center w-1/2 hover:cursor-pointer rounded-tl-lg p-1">
                                    <p class="text-center">Weekly</p>
                                    <p>({{$dates->weeklyDates}})</p>
                                </div>
                                <div class="flex flex-col justify-center items-center w-1/2 bg-slate-100 hover:cursor-pointer rounded-tr-lg p-1">
                                    <p class="text-center">Lifetime</p>
                                </div>
                            </div>
                            <div id="chart-container" class="flex-1 relative">
                                <div id="weekly-chart-container" class="flex max-h-72 w-full justify-center">
                                    <canvas id="weekly-stats" width="200px" height="200px"></canvas>
                                </div>
                                <div id="lifetime-chart-container" class="hidden max-h-72 w-full justify-center">
                                    <canvas id="lifetime-stats" width="200px" height="200px"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col relative bg-white sm:rounded-lg w-4/12">
                            <div id="stats-labels" class="flex flex-row">
                                <div class="flex flex-col justify-center items-center w-1/2 hover:cursor-pointer rounded-tl-lg p-1">
                                    <p class="text-center">Weekly</p>
                                    <p>({{$dates->weeklyDates}})</p>
                                </div>
                                <div class="flex flex-col justify-center items-center w-1/2 bg-slate-100 hover:cursor-pointer rounded-tr-lg p-1">
                                    <p class="text-center">Lifetime</p>
                                </div>
                            </div>
                            <div id="stats-container" class="flex-1 relative p-4">
                                <div id="weekly-stats-container" class="flex flex-col max-h-72 w-full justify-evenly">
                                    <div class="flex flex-row w-full justify-between p-1">
                                        <p>Application Total</p>
                                        <p>{{$statsData->weekly->applicationTotal}}</p>
                                    </div>
                                    <div class="flex flex-row w-full justify-between p-1">
                                        <p>Application evolution</p>
                                        <p>{{$statsData->weekly->applicationEvolution}}</p>
                                    </div>
                                    <div class="flex flex-row w-full justify-between p-1">
                                        <p>Application response rate</p>
                                        <p>{{$statsData->weekly->applicationResponseRate}}</p>
                                    </div>
                                    <br>
                                    <div class="flex flex-row w-full justify-between p-1">
                                        <p>Lead Total</p>
                                        <p>{{$statsData->weekly->leadTotal}}</p>
                                    </div>
                                    <div class="flex flex-row w-full justify-between p-1">
                                        <p>Lead Evolution</p>
                                        <p>{{$statsData->weekly->leadEvolution}}</p>
                                    </div>
                                </div>
                                <div id="lifetime-stats-container" class="hidden flex-col max-h-72 w-full justify-evenly">
                                <div class="flex flex-row w-full justify-between p-1">
                                        <p>Application Total</p>
                                        <p>{{$statsData->lifetime->applicationTotal}}</p>
                                    </div>
                                    <div class="flex flex-row w-full justify-between p-1">
                                        <p>Application evolution</p>
                                        <p>{{$statsData->lifetime->applicationEvolution}}</p>
                                    </div>
                                    <div class="flex flex-row w-full justify-between p-1">
                                        <p>Application response rate</p>
                                        <p>{{$statsData->lifetime->applicationResponseRate}}</p>
                                    </div>
                                    <br>
                                    <div class="flex flex-row w-full justify-between p-1">
                                        <p>Lead Total</p>
                                        <p>{{$statsData->lifetime->leadTotal}}</p>
                                    </div>
                                    <div class="flex flex-row w-full justify-between p-1">
                                        <p>Lead Evolution</p>
                                        <p>{{$statsData->lifetime->leadEvolution}}</p>
                                    </div>
                                </div>
                            </div>
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
                            <div class="h-full flex-1 flex flex-col p-3 box-border sm:rounded-lg border-y-4 border-transparent hover:border-indigo-400 transition-all">
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
        // ----- DATA ----- \\

        const data = {
            weekly : {{$chartData->weeklyApplications}}, //[accepted, rejected, waiting] -> follows alphabetical order
            lifetime : {{$chartData->lifetimeApplications}}, //[accepted, rejected, waiting] -> follows alphabetical order
        }

        // ----- CHARTS ----- \\
        const charts = {
            buttons : {
                weekly : document.getElementById('chart-labels').children[0],
                lifetime : document.getElementById('chart-labels').children[1],
            },
            colors: {
                accepted: '#5BC269',
                rejected: '#E46773',
                waiting: '#FCBA37',
            },
            containers: {
                weekly : document.getElementById('weekly-chart-container'),
                lifetime : document.getElementById('lifetime-chart-container'),
            },
            contexts: {
                weekly : document.getElementById('weekly-stats').getContext('2d'),
                lifetime : document.getElementById('lifetime-stats').getContext('2d'),
            },
            switch() {
                if (charts.containers.weekly.style.display === 'none') {
                    charts.containers.weekly.style.display = 'flex';
                    charts.buttons.weekly.classList.remove('bg-slate-100');
                    charts.buttons.weekly.classList.add('bg-white');
                    charts.containers.lifetime.style.display = 'none';
                    charts.buttons.lifetime.classList.remove('bg-white');
                    charts.buttons.lifetime.classList.add('bg-slate-100');
                } else {
                    charts.containers.weekly.style.display = 'none';
                    charts.buttons.weekly.classList.remove('bg-white');
                    charts.buttons.weekly.classList.add('bg-slate-100');
                    charts.buttons.lifetime.classList.remove('bg-slate-100');
                    charts.buttons.lifetime.classList.add('bg-white');
                    charts.containers.lifetime.style.display = 'flex';
                }
            }
        }

        // chart creation
        const weeklyChart = new Chart(charts.contexts.weekly, {
            type: 'doughnut',
            data: {
                labels: ['Accepted', 'Rejected', 'Waiting'],
                datasets: [{
                    label: 'Applications',
                    data: data.weekly,
                    backgroundColor: [
                        charts.colors.accepted,
                        charts.colors.rejected,
                        charts.colors.waiting,
                    ],
                    borderColor: [
                        charts.colors.accepted,
                        charts.colors.rejected,
                        charts.colors.waiting,
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
        const lifetimeChart = new Chart(charts.contexts.lifetime, {
            type: 'doughnut',
            data: {
                labels: ['Accepted', 'Rejected', 'Waiting'],
                datasets: [{
                    label: 'Applications',
                    data: data.lifetime,
                    backgroundColor: [
                        charts.colors.accepted,
                        charts.colors.rejected,
                        charts.colors.waiting,
                    ],
                    borderColor: [
                        charts.colors.accepted,
                        charts.colors.rejected,
                        charts.colors.waiting,
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

        // chart button listeners
        charts.buttons.weekly.addEventListener('click', function(){
            if (charts.containers.weekly.style.display !== 'flex') {
                charts.switch();
            }
        });
        charts.buttons.lifetime.addEventListener('click', function(){
            if (charts.containers.lifetime.style.display !== 'flex') {
                charts.switch();
            }
        });

        // ----- STATS ----- \\

        const stats = {
            buttons : {
                weekly : document.getElementById('stats-labels').children[0],
                lifetime : document.getElementById('stats-labels').children[1],
            },
            colors: {
                accepted: '#5BC269',
                rejected: '#E46773',
                waiting: '#FCBA37',
            },
            containers: {
                weekly : document.getElementById('weekly-stats-container'),
                lifetime : document.getElementById('lifetime-stats-container'),
            },
            switch() {
                if (stats.containers.weekly.style.display === 'none') {
                    stats.containers.weekly.style.display = 'flex';
                    stats.buttons.weekly.classList.remove('bg-slate-100');
                    stats.buttons.weekly.classList.add('bg-white');
                    stats.containers.lifetime.style.display = 'none';
                    stats.buttons.lifetime.classList.remove('bg-white');
                    stats.buttons.lifetime.classList.add('bg-slate-100');
                } else {
                    stats.containers.weekly.style.display = 'none';
                    stats.buttons.weekly.classList.remove('bg-white');
                    stats.buttons.weekly.classList.add('bg-slate-100');
                    stats.buttons.lifetime.classList.remove('bg-slate-100');
                    stats.buttons.lifetime.classList.add('bg-white');
                    stats.containers.lifetime.style.display = 'flex';
                }
            }
        }

        // stats buttons listeners
        stats.buttons.weekly.addEventListener('click', function(){
            if (stats.containers.weekly.style.display !== 'flex') {
                stats.switch();
            }
        });
        stats.buttons.lifetime.addEventListener('click', function(){
            if (stats.containers.lifetime.style.display !== 'flex') {
                stats.switch();
            }
        });
    </script>
</x-app-layout>