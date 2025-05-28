<div class="p-6 bg-gray-100 min-h-screen">

    @include('components.breadcrumb', [
    'title' => auth()->user()->hasRole('Administrateur') ? 'Espace Administrateur' : (
    auth()->user()->hasRole('Manager') ? 'Espace Manager' : (
    auth()->user()->hasRole('CST+') ? 'Espace Consultant+' : 'Espace Consultant')),
    'breadcrumbItems' => [['text' => 'Landing', 'url' => '#']],
    ])

    <!-- <h3 class="headings">Welcome to Xtrak</h3> -->

    <div class="button-container">
        <button id="openAllBtn" class="btn-green text-white px-4 py-2 rounded hover:bg-green-600 transition-all">Open all</button>
        <button id="closeAllBtn" class="btn-red text-white px-4 py-2 rounded hover:bg-red-600 transition-all">Close all</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-6">
            @php
            $leftSections = [
            'Views' => ['CDT_CST+ vue' => '/dashboard', 'CDT_CSTvue' => '/views/cdt-cst','OPP_CDTvue' => '/views/opp'],
            'Queries' => ['Generator' => '/queries/generator', 'Query1' => '/queries/query1', 'Query2' => '/queries/query2'],
            'Vaults' => ['BackUp1' => '/vaults/backup1', 'BackUp2' => '/vaults/backup2'],
            // 'Dashboard' => ['KPIs' => '/kpi' , 'Plateform' => '/plateform' , 'Commercial' => '/commercial' , 'Head hunt' => '/head' , 'Statistics' => '/statistics' , 'Map' => '/map']
            ];
            @endphp

            @foreach ($leftSections as $title => $items)
            <div class="bg-blue-50 rounded-lg">
                <div class="hack">
                    <button class="toggle-btn text-blue-500 transition-all" data-target="#{{ Str::slug($title) }}">
                        <span class="toggle-icon">+</span>
                    </button>
                    <h2 class="font-semibold text-lg text-blue-800">{{ $title }}</h2>
                </div>
                <div id="{{ Str::slug($title) }}" class="hack1 dropdown hidden">
                    <ul class="pl-6 pb-4 space-y-2">
                        @foreach ($items as $itemName => $itemUrl)
                        <li><a href="{{ $itemUrl }}" class="text-blue-500 hover:underline">{{ $itemName }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </div>

        <div class="space-y-6">
            @php
            $rightSections = [
            'Forms' => ['CDTform' => '/candidates/create'],
            // 'Tables' => ['CDTtable' => '/tables/cdt', 'TRGtable' => '/tables/trg', 'OPPtable' => '/tables/opp', 'CTCtable' => '/tables/ctc', 'PREFtable' => '/tables/pref', 'ANNtable' => '/tables/ann', 'CAMtable' => '/tables/cam', 'MAItable' => '/tables/mai'],
            // 'Activity' => ['Connection' => '/connexions', 'Upload' => '/import-candidat'],
            'Parameters' => ['Profile' => '/user-profile'],
            // 'Technics' => ['Technical Reference book' => '/book', 'DtoD Reporting' => '/reporting', 'SGPD' => '/sgpd'],
            ];
            @endphp

            @foreach ($rightSections as $title => $items)
            <div class="bg-blue-50 rounded-lg">
                <div class="hack">
                    <button class="toggle-btn text-blue-500 transition-all" data-target="#{{ Str::slug($title) }}">
                        <span class="toggle-icon">+</span>
                    </button>
                    <h2 class="font-semibold text-lg text-blue-800">{{ $title }}</h2>
                </div>
                <div id="{{ Str::slug($title) }}" class="hack1 dropdown hidden">
                    <ul class="pl-6 pb-4 space-y-2">
                        @foreach ($items as $itemName => $itemUrl)
                        <li><a href="{{ $itemUrl }}" class="text-blue-500 hover:underline">{{ $itemName }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButtons = document.querySelectorAll('.toggle-btn');
            const openAllBtn = document.getElementById('openAllBtn');
            const closeAllBtn = document.getElementById('closeAllBtn');
            const dropdowns = document.querySelectorAll('.dropdown');

            toggleButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const target = document.querySelector(button.getAttribute('data-target'));
                    const icon = button.querySelector('.toggle-icon');
                    target.classList.toggle('hidden');
                    icon.textContent = target.classList.contains('hidden') ? '+' : '-';
                });
            });

            openAllBtn.addEventListener('click', () => {
                dropdowns.forEach(dropdown => dropdown.classList.remove('hidden'));
                toggleButtons.forEach(button => button.querySelector('.toggle-icon').textContent = '-');
            });

            closeAllBtn.addEventListener('click', () => {
                dropdowns.forEach(dropdown => dropdown.classList.add('hidden'));
                toggleButtons.forEach(button => button.querySelector('.toggle-icon').textContent = '+');
            });
        });
    </script>

    <style>
        body {
            background: white;
        }

        .hack {
            display: flex;
            padding: 15px;
            gap: 1rem;
            align-items: center;
            margin-left: 12rem;
        }

        .hack1 {
            margin-left: 15rem;
        }

        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-bottom: 1.5rem;
            margin-top: 1rem;
        }

        .min-h-screen {
            min-height: 100vh;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .btn-green {
            background-color: #38a169;
        }

        .btn-red {
            background-color: #e53e3e;
        }

        button {
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .space-y-6>div {
            border-radius: 5px;
            overflow: hidden;
            margin: 10px 0px 10px 0px;
        }


        .p-4 {
            padding: 1rem;
        }

        .text-lg {
            font-size: 1.4rem;
        }

        .font-semibold {
            font-weight: 600;
            margin-top: 6px;
        }

        a {
            font-size: 1rem;
        }

        .text-blue-500 {
            color: #2b6cb0;
        }

        .text-green-500 {
            color: #38a169;
        }

        .hidden {
            display: none;
        }

        .flex {
            display: flex;
            flex-wrap: wrap;
            gap: rem;
        }

        @media (min-width: 768px) {
            .flex {
                justify-content: space-between;
            }
        }

        .headings {
            background: #010066;
            color: white;
            width: 19%;
            padding: 7px 15px 7px;
            border-radius: 7px;
        }

        .btn-green {
            background-color: green;
            border: none;
            border-radius: 8px;
            font-size: 0.8rem;
            margin-bottom: 2px;
        }

        .btn-red {
            background-color: red;
            border: none;
            border-radius: 8px;
            font-size: 0.8rem;
            margin-bottom: 2px;
        }

        .toggle-btn {
            background: none;
            border: 1px solid black;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-icon {
            font-size: 1.5rem;
            padding: 3px;
        }
    </style>
</div>