<x-app-layout>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div id="delete-confirmation-popup" class="hidden absolute z-10 bg-slate-600 bg-opacity-50 h-[calc(100vh-64.8px)] w-full">
        <div id="popup-content" class="flex flex-col justify-around items-center bg-white p-6 w-2/3 min-h-52 h-1/2 absolute z-10 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 sm:rounded-lg">
            <p>Are you sure that you want to <b>permanently</b> delete your lead at {{$lead->company_name}} ?</p>
            <div class="flex flex-row w-1/2 justify-between">
                <div class="h-10 box-border flex flex-row gap-2 border-2 border-gray-900 sm:rounded-lg py-2 px-4 hover:cursor-pointer">
                    <p>Cancel</p>
                </div>
                <a href="/leads/{{$lead->id}}/delete" class="h-10 box-border flex flex-row gap-2 sm:rounded-lg py-2 px-4 bg-red-400">
                    <p>Delete</p>
                    <img src="{{asset('images/delete.svg')}}" alt="" class="max-h-full">
                </a>
            </div>
        </div>
    </div>
    <div id="form-wrapper" class="w-full min-h-[calc(100vh-64.8px)] flex justify-center items-center">
        <div id="form-container" class="relative min-w-[750px] w-1/2 h-[calc((100vh-68.4px)*0.75)] mx-auto bg-white p-6 rounded-xl">
            <form action="/leads/{{$lead->id}}" method="POST" name="new-lead-form" class="h-full w-full flex flex-col justify-between items-center">
                @csrf
                <div class="flex flex-col gap-2 w-full">
                    <p class="text-lg">Company</p>
                    <div class="flex flex-row justify-between flex-wrap">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Company Name" value="{{$lead->company_name}}" name="company_name">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Location" value="{{$lead->location}}" name="location">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Sector" value="{{$lead->sector}}" name="sector">
                    </div>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <p class="text-lg">Dates</p>
                    <div class="flex flex-row justify-between flex-wrap">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Discovered" value="{{$lead->discovered_on}}" name="discovered_on" onfocus="(this.type='date')" onblur="(this.type='text')">
                    </div>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <p class="text-lg">Details</p>
                    <div class="flex flex-row justify-between flex-wrap gap-8">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Via" value="{{$lead->via}}" name="via">
                        <input class="rounded-md border-2 border-indigo-300 flex-1" type="url" placeholder="Link" value="{{$lead->link}}" name="link">
                        <input class="rounded-md border-2 border-indigo-300 flex-1" type="text" placeholder="Comments" value="{{$lead->comments}}" name="comments">
                    </div>
                </div>
                <p class="text-lg">Quality</p>
                <div class="flex flex-col gap-2 w-9/12">
                    <input type="range" min="0" max="10" value="{{$lead->quality}}" class="slider fillable-input" id="myRange" oninput="sliderThumbColor(this.value)" name="quality">
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
                <div id="delete-button" class="h-10 box-border flex flex-row gap-2 bg-red-400 sm:rounded-lg py-2 px-4 absolute bottom-6 right-6 hover:cursor-pointer">
                    <p>Delete</p>
                    <img src="{{asset('images/delete.svg')}}" alt="" class="max-h-full">
                </div>
            </form>
        </div>
    </div>
    <script>
        //popup opening and closing
        var isPopupOpen = false;
        const popup = document.getElementById('delete-confirmation-popup');
        const deleteButton = document.getElementById('delete-button');
        const popupContent = document.getElementById('popup-content');
        deleteButton.addEventListener('click', function() {
            if (!isPopupOpen) {
                popup.style.display = 'flex';
                isPopupOpen = true;
            }
        });
        popup.addEventListener('click', function() {
            if (!popupContent.contains(event.target)) {
                popup.style.display = 'none';
                isPopupOpen = false;
            }
        });

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