<x-app-layout>
    <div class="py-12 flex-1 min-h-full flex flex-col">
        <div class="w-full mx-auto sm:px-6 lg:px-8 h-full flex flex-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex-1">
                <div class="p-6 text-gray-900 h-full flex flex-col gap-6">
                    <a href="">
                        <div id="new-application" class="h-28 w-full sm:rounded-lg p-6 border-4 border-indigo-400 flex flex-row justify-center items-center border-dashed group hover:bg-indigo-400">
                            <div class="border-box h-12 stroke-indigo-400 group-hover:stroke-white group-hover:animate-bounce">
                                <svg width="auto" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 12H18M12 6V18" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            </div>
                        </div>
                    </a>
                    {{ $user_applications }}
                    @foreach ($user_applications as $application)
                    <div id="application" class="h-28 w-full bg-red-400 sm:rounded-lg p-6 flex flex-row [&:not(:last-child)]:border-b-4 border-indigo-400">
                        <div id="application-id" class="h-full aspect-square border-r-4 border-indigo-400 flex items-center justify-center self-center">
                            <p class="text-4xl">{{$application->id}}</p>
                        </div>
                        <div class="flex flex-row justify-between w-full w-[calc(100%-4rem)]">
                            <div id="application-main-info" class="h-full flex flex-col pl-6">
                                <p id="company-name" class="text-2xl">{{$application->company_name}}</p>
                                <div class="flex flex-row">
                                    <p id="location" class="pr-1 border-r-2 border-indigo-400">{{$application->location}}</p>
                                    <p id="sector" class="pl-1">{{$application->sector}}</p>
                                </div>
                            </div>
                            <div id="application-secondary-info" class="flex flex-row w-max h-full items-center gap-8">
                                <div id="dates">
                                    <p class="text-3xl">{{$application->days_ago}}</p>
                                </div>
                                <div id="icons" class="h-3/4 w-auto flex flex-row gap-4">
                                    <svg class="h-full w-auto" fill="#00a56a" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 943.118 943.118" xml:space="preserve"><path d="M54.182,670.915v189.128c0,11.047,8.955,20,20,20h362.347c-3.137-6.688-4.899-14.143-4.899-22.006V670.915H54.182z"></path> <path d="M30,639.904h24.182h377.446V622.67v-24.418c0-0.229,0.007-0.456,0.009-0.685c0.107-15.218,3.8-29.6,10.277-42.337 c2.796-5.496,6.107-10.688,9.873-15.506c4.478-5.729,9.597-10.934,15.245-15.507c16.361-13.248,37.182-21.197,59.827-21.197 h22.555v-43.313c0-32.846-26.627-59.473-59.473-59.473h-53.809c-10.504,0-19.628,7.229-22.029,17.455l-25.013,106.529 l-3.642,15.507l-2.578,10.977c-0.36,1.538-0.785,3.049-1.271,4.528h-16.584c-0.183-5.188-0.711-10.367-1.577-15.506 c-0.148-0.892-0.306-1.779-0.476-2.666l-3.326-12.841l-19.571-75.542l15.62-34.473c2.965-6.545-1.82-13.968-9.006-13.968h-33.525 c-7.186,0-11.972,7.423-9.006,13.968l15.62,34.473l-20.313,75.542l-3.086,11.478c-0.268,1.339-0.506,2.683-0.728,4.029 c-0.848,5.14-1.36,10.317-1.527,15.506h-15.88c-0.484-1.48-0.909-2.99-1.271-4.528l-2.578-10.977l-3.641-15.508l-25.013-106.525 c-2.401-10.227-11.524-17.455-22.029-17.455h-53.808c-32.846,0-59.473,26.627-59.473,59.473v64.513v15.506v15.506H30 c-16.568,0-30,13.431-30,30v24.674C0,626.474,13.432,639.904,30,639.904z"></path> <path d="M329.919,368.094c73.717,0,133.477-59.76,133.477-133.477V92.744c0-18.391-16.561-32.347-34.686-29.233 c-39.276,6.747-128.839,24.62-184.565,35.864c-27.752,5.599-47.704,29.986-47.704,58.297v76.946 C196.442,308.335,256.202,368.094,329.919,368.094z"></path> <path d="M526.859,533.021c-10.345,0-20.121,2.418-28.812,6.703c-7.723,3.809-14.576,9.102-20.201,15.506 c-9.95,11.325-16.036,26.118-16.204,42.337c-0.002,0.229-0.017,0.455-0.017,0.685v24.418v17.234v15.505v15.506v187.122 c0,12.154,9.853,22.006,22.005,22.006h334.086h103.396c12.153,0,22.006-9.852,22.006-22.006V598.252 c0-31.565-22.422-57.893-52.209-63.928c-4.207-0.852-8.562-1.303-13.021-1.303H549.414H526.859L526.859,533.021z"></path> <path d="M702.375,497.769c80.854,0,146.4-65.546,146.4-146.4v-84.396c0-31.052-21.886-57.8-52.322-63.941 c-61.123-12.332-159.355-31.935-202.434-39.336c-1.879-0.323-3.743-0.478-5.577-0.478c-17.574,0-32.468,14.276-32.468,32.542 v155.609C555.975,432.223,621.52,497.769,702.375,497.769z"></path></svg>
                                    <img class="h-full w-auto" src="{{asset('images/waiting.svg')}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>