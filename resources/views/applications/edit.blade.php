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
                        <input class="rounded-md border-2 border-indigo-300 flex-1" type="url" placeholder="Link" value="{{ isset($link) ? $link : '' }}" name="link">
                        <input class="rounded-md border-2 border-indigo-300 flex-1" type="text" placeholder="Comments" value="{{ isset($comments) ? $comments : '' }}" name="comments">
                    </div>
                </div>
                <button onclick="validateInputs()" type="button" class="w-max py-2 px-4 text-white rounded-md bg-indigo-400 hover:animate-pulse">Submit</button>
                <input class="absolute bottom-6 left-6 underline text-gray-500 hover:cursor-pointer" type="reset" value="Reset" />
            </form>
        </div>
    </div>
    <script>
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