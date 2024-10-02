<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 flex-1 min-h-full flex flex-col">
        <div class="w-full mx-auto sm:px-6 lg:px-8 h-full flex flex-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex-1">
                <div class="p-6 text-gray-900 h-full flex flex-col gap-6 box-border">
                    <div class="flex flex-row bg-fuchsia-400 justify-between flex-1">
                        <div class="bg-red-500 w-7/12">
                            <p>Weekly stats</p>
                            <div class="max-h-72 max-w-72">
                                <canvas id="user-stats" width="200px" height="200px"></canvas>
                            </div>
                        </div>
                        <div class="bg-blue-500 w-4/12">
                            <p>To-do</p>
                        </div>
                    </div>
                    <div class="bg-yellow-500 flex-1">
                        <p>Latest applications</p>
                        @if (isset($lastApplications))
                            <div class="flex flex-row bg-lime-400 h-[calc(100%-1.5rem)] max-w-[calc(100%-1.5rem)] gap-8">
                                @foreach ($lastApplications as $application)
                                    <div class="bg-red-300 h-full w-44">
                                        <p class="text-2xl text-center">{{$application->company_name}}</p>
                                        <p class=" text-lg text-center">{{$application->location}}</p>
                                        <p class="text-1xl text-center">{{$application->days_ago}}</p>
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
        const weeklyApplications = {!!json_encode($weeklyApplications) !!}; //[accepted, rejected, waiting] -> follows alphabetical order
        const ctx = document.getElementById('user-stats').getContext('2d');
        const colors = {
            accepted: 'green',
            rejected: 'red',
            waiting: '#FFA500',
        }
        const myDonutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Accepted', 'Rejected', 'Waiting'],
                datasets: [{
                    label: 'Applications',
                    data: weeklyApplications, // Bogus data to serve as a placeholder while I set up the controller function
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