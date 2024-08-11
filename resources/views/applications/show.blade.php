<x-app-layout>
    <div class="py-12 flex-1 min-h-full flex flex-col">
        <div class="w-full mx-auto sm:px-6 lg:px-8 h-full flex flex-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex-1">
                <div class="p-6 text-gray-900 h-full flex flex-col">
                    <a href="#">
                        <div id="new-application" class="h-28 w-full sm:rounded-lg p-6 border-4 border-indigo-400 flex flex-row justify-center items-center border-dashed group bg-gradient-to-b from-indigo-400 to-indigo-400 bg-center bg-no-repeat bg-0100 transition-fillout duration-500 hover:bg-100100">
                            <div class="border-box h-12 stroke-indigo-400 group-hover:stroke-white">
                                <svg width="auto" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 12H18M12 6V18" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
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
    <div id="form-wrapper" class="hidden absolute w-full h-[calc(100%-64.8px)] bg-slate-600 bg-opacity-50 justify-center items-center">
        <div id="form-container" class="min-w-[750px] relative bg-white w-1/2 h-3/4 rounded-xl p-6">
            <form action="/applications/dump" method="POST" class="h-full flex flex-col justify-between items-center">
                @csrf
                <div class="flex flex-col gap-2 w-full">
                    <p class="text-lg">Company</p>
                    <div class="flex flex-row justify-between flex-wrap">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Company Name" name="company_name">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Location" name="location">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Sector" name="sector">
                    </div>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <p class="text-lg">Dates</p>
                    <div class="flex flex-row justify-between flex-wrap">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Discovered" name="discovered_on" onfocus="(this.type='date')" onblur="(this.type='text')">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="First Contact" name="first_contact" onfocus="(this.type='date')" onblur="(this.type='text')">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Last Contact" name="last_contact" onfocus="(this.type='date')" onblur="(this.type='text')">
                    </div>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <p class="text-lg">Details</p>
                    <div class="flex flex-row justify-between flex-wrap gap-8">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Via" name="via">
                        <select class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Interview" name="interview">
                            <option value="" disabled selected>Interview</option>
                            <option value="true">Yes</option>
                            <option value="false">No</option>
                        </select>
                        <select class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Status" name="status">
                            <option value="" disabled selected>Status</option>
                            <option value="waiting">Waiting</option>
                            <option value="accepted">Accepted</option>
                            <option value="rejected">Rejected</option>
                        </select>
                        <input class="fillable-input rounded-md border-2 border-indigo-300 flex-1" type="url" placeholder="Link" name="link">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 flex-1" type="text" placeholder="Comments" name="comments">
                    </div>
                </div>
                <button type="submit" class="w-max py-2 px-4 text-white rounded-md bg-indigo-400 hover:animate-pulse">Submit</button>
                <input class="absolute bottom-6 left-6 underline text-gray-500 hover:cursor-pointer" type="reset" value="Reset"/>
            </form>
            <button id="close-button" type="button" class="top-4 right-4 absolute bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-400">
              <span class="sr-only">Close menu</span>
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
        </div>
    </div>
    <script>
        //form opening and closing
        var isFormOpen = false;
        document.getElementById('new-application').addEventListener('click', function() {
            if (!isFormOpen) {
                document.getElementById('form-wrapper').style.display = 'flex';
                isFormOpen = true;
            }
        });
        document.getElementById('form-wrapper').addEventListener('click', function() {
            if (!document.getElementById('form-container').contains(event.target)) {
                document.getElementById('form-wrapper').style.display = 'none';
                isFormOpen = false;
            }
        });
        document.getElementById('close-button').addEventListener('click', function() {
            document.getElementById('form-wrapper').style.display = 'none';
            isFormOpen = false;
        });

        //form filling checking
        function checkInputs() {
            const fillableInputs = document.querySelectorAll('.fillable-input');
            fillableInputs.forEach(input => {
                if(input.value === '') {
                    console.error(`${input} is empty !`);
                };
            });
        };
    </script>
</x-app-layout>