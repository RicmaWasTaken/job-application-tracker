<x-app-layout>
    <div class="py-12 flex-1 min-h-full flex flex-col">
        <div class="w-full mx-auto sm:px-6 lg:px-8 h-full flex flex-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex-1">
                <div class="p-6 text-gray-900 h-full flex flex-col">
                    <a href="../">
                        <div id="new-application" class="h-28 w-full sm:rounded-lg p-6 border-4 border-indigo-400 flex flex-row justify-center items-center border-dashed group bg-gradient-to-b from-indigo-400 to-indigo-400 bg-center bg-no-repeat bg-0100 transition-fillout duration-500 hover:bg-100100">
                            <div class="border-box h-12 stroke-indigo-400 group-hover:stroke-white">
                                <svg width="auto" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 12H18M12 6V18" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                    {{$user_applications}}
                    @foreach ($user_applications as $application)
                    <a href="/applications/{{$application->id}}">
                        <div id="application" class="h-28 w-full relative sm:rounded-lg p-6 flex flex-row hover:bg-indigo-400 custom-border">
                            <div id="application-id" class="h-full aspect-square border-r-4 border-indigo-400 flex items-center justify-center self-center">
                                <p class="text-4xl">{{$application->id}}</p>
                            </div>
                            <div class="flex flex-row justify-between w-[calc(100%-4rem)]">
                                <div id="application-main-info" class="h-full flex flex-col pl-6 justify-center">
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
                                    <div id="icons" class="h-3/5 w-auto flex flex-row gap-4">
                                        <img fill="white" src="{{asset($application->interviewSource)}}" alt="">
                                        <img class="h-full w-auto" src="{{asset('images/pending.svg')}}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>