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
            <p>Are you sure that you want to <b>permanently</b> delete your application at {{$application->company_name}} ?</p>
            <div class="flex flex-row w-1/2 justify-between">
                <div class="h-10 box-border flex flex-row gap-2 border-2 border-gray-900 sm:rounded-lg py-2 px-4 hover:cursor-pointer">
                    <p>Cancel</p>
                </div>
                <a href="/applications/{{$application->id}}/delete" class="h-10 box-border flex flex-row gap-2 sm:rounded-lg py-2 px-4 bg-red-400">
                    <p>Delete</p>
                    <img src="{{asset('images/delete.svg')}}" alt="" class="max-h-full">
                </a>
            </div>
        </div>
    </div>
    <div class="w-full min-h-[calc(100vh-64.8px)] flex justify-center items-center">
        <div class="relative min-w-[750px] w-1/2 h-[calc((100vh-68.4px)*0.75)] mx-auto bg-white p-6 rounded-xl">
            <form action="/applications/{{$application->id}}" method="POST" name="edit-application-form" class="h-full w-full flex flex-col justify-between items-center">
                @csrf
                <div class="flex flex-col gap-2 w-full">
                    <p class="text-lg">Company</p>
                    <div class="flex flex-row justify-between flex-wrap">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Company Name" value="{{$application->company_name}}" name="company_name">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Location" value="{{$application->location}}" name="location">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Sector" value="{{$application->sector}}" name="sector">
                    </div>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <p class="text-lg">Dates</p>
                    <div class="flex flex-row justify-between flex-wrap">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Discovered" value="{{$application->discovered_on}}" name="discovered_on" onfocus="(this.type='date')" onblur="(this.type='text')">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="First Contact" value="{{$application->first_contact}}" name="first_contact" onfocus="(this.type='date')" onblur="(this.type='text')">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Last Contact" value="{{$application->last_contact}}" name="last_contact" onfocus="(this.type='date')" onblur="(this.type='text')">
                    </div>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <p class="text-lg">Details</p>
                    <div class="flex flex-row justify-between flex-wrap gap-8">
                        <input class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Via" value="{{$application->via}}" name="via">
                        <select class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Interview" name="interview">
                            <option value="" disabled>Interview</option>
                            <option value="1" {{ $application->interview == true ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ $application->interview == false ? 'selected' : '' }}>No</option>
                        </select>
                        <select class="fillable-input rounded-md border-2 border-indigo-300 w-[30%]" type="text" placeholder="Status" name="status">
                            <option value="" disabled>Status</option>
                            <option value="waiting" {{ $application->status == "waiting" ? 'selected' : '' }}>Waiting</option>
                            <option value="accepted" {{ $application->status == "accepted" ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ $application->status == "rejected" ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <input class="rounded-md border-2 border-indigo-300 flex-1" type="url" placeholder="Link" value="{{ isset($application->link) ? $application->link : '' }}" name="link">
                        <input class="rounded-md border-2 border-indigo-300 flex-1" type="text" placeholder="Comments" value="{{ isset($application->comments) ? $application->comments : '' }}" name="comments">
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
                document.forms["edit-application-form"].submit();
            }
        };
    </script>
</x-app-layout>