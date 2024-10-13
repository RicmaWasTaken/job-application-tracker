<x-app-layout>
    {{-- Validation errors received from controller's create method --}}
    @if ($errors->any())
    <div id="error-message" class="relative w-3/4 min-h-10 bg-red-400 mx-auto p-2">
        <svg id="close-error" class="h-6 w-6 absolute right-2 top-2 hover:cursor-pointer stroke-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif
    {{-- Other errors folowing a redirection (unauthorized or wrong app_id during edit request) --}}
    @if(session('error'))
    <div id="error-message" class="relative w-3/4 min-h-10 bg-red-400 mx-auto p-2">
        <p>{{session('error')}}</p>
    </div>
    @endif
    {{-- Success message after a successful lead creation --}}
    @if (isset($successMessage))
    <div id="success-message" class="transition-opacity duration-300 opacity-100 relative w-3/4 min-h-10 bg-green-400 mx-auto p-2">
        {{$successMessage}}
    </div>
    @endif
    <div class="py-12 flex-1 min-h-full flex flex-col">
        <div class="w-full mx-auto sm:px-6 lg:px-8 h-full flex flex-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex-1">
                <div class="p-6 text-gray-900 h-full flex flex-col">
                    <a href="#">
                        <div id="new-lead" class="h-28 w-full sm:rounded-lg p-6 border-4 border-indigo-400 flex flex-row justify-center items-center border-dashed group bg-gradient-to-b from-indigo-400 to-indigo-400 bg-center bg-no-repeat bg-0100 transition-fillout duration-500 hover:bg-100100">
                            <div class="border-box h-12 stroke-indigo-400 group-hover:stroke-white">
                                <svg width="auto" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 12H18M12 6V18" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                    @if(isset($user_leads))
                    @foreach ($user_leads as $lead)

                    <div id="lead" class="h-28 w-full relative sm:rounded-lg flex flex-row custom-border">
                        <a href="/leads/{{$lead->id}}" class="flex flex-1 hover:bg-indigo-400">
                            <div id="lead-content" class="flex flex-row flex-1 p-6">
                                <div id="lead-id" class="h-full aspect-square border-r-4 border-indigo-400 flex items-center justify-center self-center">
                                    <p class="text-4xl">{{$lead->index}}</p>
                                </div>
                                <div class="flex flex-row justify-between w-[calc(100%-4rem)]">
                                    <div id="lead-main-info" class="h-full flex flex-col pl-6 justify-center">
                                        <p id="company-name" class="text-2xl">{{$lead->company_name}}</p>
                                        <div class="flex flex-row">
                                            <p id="location" class="pr-1 border-r-2 border-indigo-400">{{$lead->location}}</p>
                                            <p id="sector" class="pl-1">{{$lead->sector}}</p>
                                        </div>
                                    </div>
                                    <div id="lead-secondary-info" class="flex flex-row w-max h-full items-center gap-8">
                                        <div id="dates">
                                            <p class="text-3xl">{{$lead->days_ago}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="/leads/{{$lead->id}}/convert" id="convert-lead" class="flex flex-col justify-center items-center bg-indigo-400 [clip-path:polygon(0%_0%,75%_0%,100%_50%,75%_100%,0%_100%)] group">
                            <div class="flex justify-center items-center scale-90 w-full h-full p-6 [clip-path:polygon(0%_0%,75%_0%,100%_50%,75%_100%,0%_100%)] group-hover:bg-white">
                                <p class=" text-xl">Apply</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div id="form-wrapper" class="hidden absolute w-full h-full bg-slate-600 bg-opacity-50 justify-center items-center">
        <div id="form-container" class="min-w-[750px] relative bg-white w-1/2 h-3/4 rounded-xl p-6">
            <form action="/leads/create" method="POST" name="new-lead-form" class="h-full flex flex-col justify-between items-center">
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
                    </div>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <p class="text-lg">Details</p>
                    <div class="flex flex-row justify-between flex-wrap gap-8">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Via" name="via">
                        <input class="rounded-md border-2 border-indigo-300 flex-1" type="url" placeholder="Link" name="link">
                        <input class="rounded-md border-2 border-indigo-300 flex-1" type="text" placeholder="Comments" name="comments">
                    </div>
                </div>
                <p class="text-lg">Quality</p>
                <div class="flex flex-col gap-2 w-9/12">
                    <input type="range" min="0" max="10" value="5" class="slider fillable-input" id="myRange" oninput="sliderThumbColor(this.value)" name="quality">
                    <div class="flex justify-between w-full slider-values">
                        <p>0</p>
                        <p>1</p>
                        <p>2</p>
                        <p>3</p>
                        <p>4</p>
                        <p>5</p>
                        <p>6</p>
                        <p>7</p>
                        <p>8</p>
                        <p>9</p>
                        <p>10</p>
                    </div>
                </div>
                <button onclick="validateInputs()" type="button" class="w-max py-2 px-4 text-white rounded-md bg-indigo-400 hover:animate-pulse">Submit</button>
                <input class="absolute bottom-6 left-6 underline text-gray-500 hover:cursor-pointer" type="reset" value="Reset" />
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
        document.getElementById('new-lead').addEventListener('click', function() {
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
        function validateInputs() {
            const fillableInputs = document.querySelectorAll('.fillable-input');
            var isFormValid = true;
            fillableInputs.forEach(input => {
                if (input.value === '') {
                    isFormValid = false;
                    input.classList.add('border-red-500');
                } else {
                    input.classList.remove('border-red-500');
                }
            });
            if (isFormValid) {
                document.forms["new-lead-form"].submit();
            }
        };

        //error message closing
        document.getElementById('close-error').addEventListener('click', function() {
            document.getElementById('error-message').style.display = 'none';
        });

        //success message closing
        setTimeout(function() {
            document.getElementById('success-message').style.opacity = '0';
        }, 2000);

        function sliderThumbColor(value) {
            const slider = document.querySelector('.slider');
            const colors = ['#FF7070', '#F2CA02', '#5DC951'];
            let color;
            if (value >= 0 && value <= 4) {
                color = colors[0];
            } else if (value >= 5 && value <= 7) {
                color = colors[1];
            } else {
                color = colors[2];
            }
            slider.style.setProperty('--thumb-color', color);
        }
    </script>
</x-app-layout>