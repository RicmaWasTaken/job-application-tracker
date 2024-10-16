<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom CSS for help card -->
    <style>
        #help-card li {
            list-style: disc;
            margin-left: 2rem;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="absolute top-2 right-2 p-1">
        <p>Version {{ config('app.version') }}</p>
    </div>
    <div class="min-h-screen h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="h-3/5 flex flex-col justify-start gap-20">
            <div class="text-center flex flex-col gap-10">
                <h1 class="text-5xl">JOB TRACKER</h1>
                <h2 class="text-3xl">The best companion for your job-hunting adventure</h2>
            </div>
            <div class="box-border flex flex-row gap-40 justify-center items-center">
                <a href="/register" class="py-3 text-xl min-w-32 text-center rounded-lg text-indigo-400 border-2 border-indigo-400">Register</a>
                <a href="/login" class="py-3 text-xl min-w-32 text-center rounded-lg bg-indigo-400 text-gray-100">Login</a>
            </div>
            <div id="help-button" class="absolute bottom-8 right-8 bg-indigo-400 rounded-full flex justify-center items-center aspect-square w-[50px] h-[50px] hover:cursor-pointer">
                <p class="text-3xl text-white">?</p>
            </div>
        </div>
    </div>
    <div id="help-wrapper" class="hidden bg-slate-600 bg-opacity-50 w-screen h-screen absolute top-0 left-0 justify-center items-center">
        <div id="help-card" class="bg-white w-4/5 p-6 flex flex-col items-center gap-6 rounded-lg relative">
            <h2 id="card-title" class="text-2xl font-bold">(title)</h2>
            <p id="card-text">(text)</p>
            <img src="#" id="card-image" class=" max-w-[50%] max-h-full aspect-auto border-2 border-indigo-400">
            <div id="card-button" class="hover:cursor-pointer text-white text-xl bg-indigo-400 border-4 border-indigo-400 p-2 rounded-lg flex justify-center items-center min-w-[90px]">
                (button)
            </div>
            <button id="close-button" type="button" class="top-4 right-4 absolute bg-white rounded-md inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-400">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    <script>
        const cardContent = {
            1: {
                title: "Job Tracker",
                text: "A web app designed to help you keep track of your leads and applications during your job-seeking endeavours",
                img: "blblblbbll",
            },
            2: {
                title: "Dashboard",
                text: "A collection of data to help you better visualise your progress by sets of time (all-time or weekly)",
                img: "{{asset('images/dashboard.png')}}",
            },
            3: {
                title: "Applications",
                text: "Every application you've sent is kept here, in a summarized version. Each application has a variety of data, which includes : <ul><li>Details about the company (company name, sector, location)</li><li>Important dates (date of discovery, first contact and last contact)</li><li>Which platform you applied through (via)</li><li>Whether or not you had an interview</li><li>Overall status (waiting, accepted or rejected)</li></ul>You can create a new application by hitting the <b>+</b> button or edit an existing one by clicking on it",
                img: "{{asset('images/applications.png')}}",
            },
            4: {
                title: "Leads",
                text: "Keep track of your leads (offers you wish to apply for but haven't yet) by creating or editing them. Once you've applied, you can convert the lead into an application by clicking the <b>Apply</b> button next to it. It will then enter default status (last contact on date of conversion, no interview and waiting for reply)",
                img: "{{asset('images/leads.png')}}",
            },
            5: {
                title: "Future Updates",
                text: "A to-do list, custom timeframes for reminders (from 3 days to 1 month) and many other useful features will make their debut in a future version of the app",
                img: "#",
            }

        }
        const helpElement = {
            button: document.getElementById('help-button'), // button that starts the help process 
            wrapper: document.getElementById('help-wrapper'),
            card: document.getElementById('help-card'),
            closeButton: document.getElementById('close-button'),
            currentCard: 0,
            components: {
                title: document.getElementById('card-title'),
                text: document.getElementById('card-text'),
                img: document.getElementById('card-image'),
                button: document.getElementById('card-button'), // button located within the help card
            },
            show() {
                helpElement.wrapper.style.display = "flex"
            },
            hide() {
                helpElement.wrapper.style.display = "none";
            },
            setup() { // sets up help card by loading first-page content 
                setContentTo(cardContent[1])
            },
            handle() {
                if (helpElement.currentCard == Object.keys(cardContent).length) {
                    helpElement.currentCard = 0;
                    helpElement.hide();
                }
                helpElement.currentCard++;
                setContentTo(cardContent[helpElement.currentCard])
            },

        }

        function setContentTo(content) {
            helpElement.components.title.innerHTML = content.title;
            helpElement.components.text.innerHTML = content.text;
            helpElement.components.img.src = content.img;
            if (helpElement.currentCard == Object.keys(cardContent).length) {
                helpElement.components.button.innerHTML = "Got it !";
            } else {
                helpElement.components.button.innerHTML = "Next";
            }
        }

        helpElement.button.addEventListener('click', function() {
            helpElement.show();
            helpElement.handle();
        });

        helpElement.wrapper.addEventListener('click', function() {
            temporaryArray = [helpElement.card, helpElement.components.title, helpElement.components.text, helpElement.components.img, helpElement.components.button, ]
            if (event.target != temporaryArray[0, 1, 2, 3, 4]) {
                helpElement.hide();
                helpElement.currentCard = 0;
            }
        });

        helpElement.components.button.addEventListener('click', helpElement.handle);

        helpElement.closeButton.addEventListener('click', helpElement.hide);
    </script>
</body>

</html>