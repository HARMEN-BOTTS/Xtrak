<div class="p-6 bg-gray-100 min-h-screen">

    @include('components.breadcrumb', [
    'title' => auth()->user()->hasRole('Administrateur') ? 'Espace Administrateur' : (
    auth()->user()->hasRole('Manager') ? 'Espace Manager' : (
    auth()->user()->hasRole('CST+') ? 'Espace Consultant+' : 'Espace Consultant')),
    'breadcrumbItems' => [['text' => 'Landing', 'url' => '/landing']],
    ])

    <div class="button-container">
        <button id="openAllBtn" class="btn-green text-white px-4 py-2 rounded hover:bg-green-600 transition-all">Open all</button>
        <button id="closeAllBtn" class="btn-red text-white px-4 py-2 rounded hover:bg-red-600 transition-all">Close all</button>
    </div>


    <div id="popupForm" class="popup-form">
        <div class="popup-content">
            <h3>Add Query</h3>
            <form id="addQueryForm">
                <label for="table">Table :</label>
                <select id="table" name="table" required>
                    <option value="table1">CDT</option>
                    <option value="table2">TRG</option>
                    <option value="table3">OPP</option>
                    <option value="table4">CTC</option>
                    <option vlaue="table5">EVT</option>
                </select><br>

                <label for="author">Author :</label>
                <select id="author" name="author" required>
                    <option value="author1">BGS</option>
                    <option value="author2">PH</option>
                    <option value="author3">ADF</option>
                    <option value="author4">PMK</option>
                    <option value="author5">CS+</option>
                </select><br>

                <label for="description">Short Description :</label><br>
                <textarea id="description" name="description" rows="4" cols="50" required></textarea><br>

                <button type="submit" class="save-button">Save</button>
                <button type="button" id="cancelButton" class="cancel-button">Cancel</button>

            </form>
        </div>
    </div>


    <div id="queryModal" class="popup-form">
        <div class="popup-content">
            <h3>Query Details</h3>
            <div id="queryDetails"></div>
            <button id="editButton" class="edit-button">Edit</button>
            <button id="deleteButton" class="delete-button">Delete</button>
            <button id="closeQueryModal" class="close-button">Close</button>
        </div>
    </div>



    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-6">
            @php
            $leftSections = [
            'Views' => [
            'CDTvue' => ['url' => '/dashboard', 'disabled' => false],
            'TRGvue' => ['url' => '/trgdashboard', 'disabled' => false],
            'OPPvue' => ['url' => '/oppdashboard', 'disabled' => false],
            'CTCvue' => ['url' => '/ctcdashboard', 'disabled' => false],
            'PREFvue' => ['url' => '/views/pref', 'disabled' => true],
            'ANNvue' => ['url' => '/views/ann', 'disabled' => true],
            'CAMvue' => ['url' => '/views/cam', 'disabled' => true],
            'MAIvue' => ['url' => '/views/mai', 'disabled' => true]
            ],
            'Queries' => [],
            'Vaults' => [
            'BackUp1' => ['url' => '/vaults/backup1', 'disabled' => true],
            'BackUp2' => ['url' => '/vaults/backup2', 'disabled' => true]
            ],
            'Dashboard' => [
            'KPIs' => ['url' => '/kpis', 'disabled' => false],
            'Plateform' => [
            'url' => '#',
            'disabled' => false,
            'subItems' => [
            'Activity' => [
            'Connection' => ['url' => '/connexions', 'disabled' => false],
            'Upload' => ['url' => '/import-candidat', 'disabled' => false]
            ]
            ]
            ],
            'Commercial' => ['url' => '/commercial', 'disabled' => true],
            'Head hunt' => ['url' => '/head', 'disabled' => true],
            'Statistics' => ['url' => '/statistics', 'disabled' => true],
            'Map' => ['url' => '/map', 'disabled' => true],
            ],
            ];
            @endphp

            @foreach ($leftSections as $title => $items)
            <div class="bg-blue-50 rounded-lg">
                <div class="hack">
                    <button class="toggle-btn text-blue-500 transition-all" data-target="#{{ Str::slug($title) }}">
                        <span class="toggle-icon">+</span>
                    </button>
                    <h2 class="land-title font-semibold text-lg text-blue-800" data-target="#{{ Str::slug($title) }}">{{ $title }}</h2>
                </div>
                <div id="{{ Str::slug($title) }}" class="hack1 dropdown hidden">
                    <ul style="color:#a6a6a6;" class="pl-6 pb-4 space-y-2 left-section-subitems">
                        @foreach ($items as $itemName => $itemData)
                        @php
                        $isDisabled = is_array($itemData) ? ($itemData['disabled'] ?? false) : false;
                        $url = is_array($itemData) ? $itemData['url'] : $itemData;
                        $linkClass = $isDisabled
                        ? 'main-black cursor-not-allowed'
                        : 'main-blue hover:underline';
                        @endphp

                        @if(is_array($itemData) && isset($itemData['subItems']))
                        <li>
                            <button class="toggle-btn1 {{ $linkClass }} transition-all"
                                data-target="#{{ Str::slug($itemName) }}"
                                {{ $isDisabled ? 'disabled' : '' }}>
                                <span class="text-blue-800">{{ $itemName }}</span>
                            </button>
                            <ul style="color:#a6a6a6;" id="{{ Str::slug($itemName) }}" class="pl-6 pb-4 space-y-2 hidden left-section-subitems">
                                @foreach ($itemData['subItems'] as $subItemName => $subItemUrl)
                                @if(is_array($subItemUrl))
                                <li>
                                    @php
                                    $isSubDisabled = $subItemUrl['disabled'] ?? false;
                                    $subLinkClass = $isSubDisabled
                                    ? 'main-black cursor-not-allowed'
                                    : 'main-blue hover:underline';
                                    @endphp
                                    <button class="toggle-btn1 {{ $subLinkClass }} transition-all"
                                        data-target="#{{ Str::slug($subItemName) }}"
                                        {{ $isSubDisabled ? 'disabled' : '' }}>
                                        <span class="text-blue-800">{{ $subItemName }}</span>
                                    </button>
                                    <ul style="color:#a6a6a6;" id="{{ Str::slug($subItemName) }}" class="pl-6 pb-4 space-y-2 hidden left-section-subitems">
                                        @foreach ($subItemUrl as $subSubItemName => $subSubItemData)
                                        @php
                                        $isSubSubDisabled = is_array($subSubItemData) ? ($subSubItemData['disabled'] ?? false) : false;
                                        $subSubUrl = is_array($subSubItemData) ? $subSubItemData['url'] : $subSubItemData;
                                        $subSubLinkClass = $isSubSubDisabled
                                        ? 'main-black cursor-not-allowed'
                                        : 'main-blue hover:underline';
                                        @endphp
                                        @if($isSubSubDisabled)
                                        <li><span class="{{ $subSubLinkClass }}">{{ $subSubItemName }}</span></li>
                                        @else
                                        <li><a href="{{ $subSubUrl }}" class="{{ $subSubLinkClass }}">{{ $subSubItemName }}</a></li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </li>
                                @else
                                @php
                                $isSubDisabled = $subItemUrl['disabled'] ?? false;
                                $subLinkClass = $isSubDisabled
                                ? 'main-black cursor-not-allowed'
                                : 'main-blue hover:underline';
                                $subUrl = $subItemUrl['url'] ?? $subItemUrl;
                                @endphp
                                @if($isSubDisabled)
                                <li><span class="{{ $subLinkClass }}">{{ $subItemName }}</span></li>
                                @else
                                <li><a href="{{ $subUrl }}" class="{{ $subLinkClass }}">{{ $subItemName }}</a></li>
                                @endif
                                @endif
                                @endforeach
                            </ul>
                        </li>
                        @else
                        @if($isDisabled)
                        <li><span class="{{ $linkClass }}">{{ $itemName }}</span></li>
                        @else
                        <li><a href="{{ $url }}" class="{{ $linkClass }}">{{ $itemName }}</a></li>
                        @endif
                        @endif
                        @endforeach

                        @if ($title == 'Queries')
                        <div id="savedQueriesContainer" class="saved-queries-container">
                            <table id="savedQueriesTable" class="saved-queries-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Table</th>
                                        <th>Aut.</th>
                                        <th>Short Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="tb">
                            <button id="newButton" class="new-button text-blue-500 hover:underline">
                                New Query
                            </button>
                            <button id="seeAllButton" class="see-button text-blue-500 hover:underline">
                                See All
                            </button>
                        </div>
                        @endif
                    </ul>
                </div>
            </div>
            @endforeach
        </div>

        <div class="space-y-6">
            @php
            $rightSections = [
            'Forms' => [
            'CDTform' => ['url' => '/candidates/create', 'enabled' => true],
            'TRGform' => ['url' => '/trgform', 'enabled' => true],
            'OPPform' => ['url' => '/opportunity', 'enabled' => true],
            'CTCform' => ['url' => '/ctcform', 'enabled' => true],
            'PREFform' => ['url' => '/forms/pref', 'enabled' => false],
            'ANNform' => ['url' => '/forms/ann', 'enabled' => false],
            'CAMform' => ['url' => '/forms/cam', 'enabled' => false],
            'MAIform' => ['url' => '/forms/mai', 'enabled' => false],
            ],
            'Tables' => [
            'CDTtable' => ['url' => '/tables/cdt', 'enabled' => false],
            'TRGtable' => ['url' => '/tables/trg', 'enabled' => false],
            'OPPtable' => ['url' => '/tables/opp', 'enabled' => false],
            ],
            'Parameters' => [
            'Presentation' => ['url' => '/parameters/presentation', 'enabled' => false],
            'Profile' => ['url' => '/user-profile', 'enabled' => true],
            ],
            'Technics' => [
            'Technical Reference book' => ['url' => '/book', 'enabled' => false],
            'DtoD Reporting' => ['url' => '/reporting', 'enabled' => false],
            'SGPD' => ['url' => '/sgpd', 'enabled' => false],
            ],
            ];
            @endphp



            @foreach ($rightSections as $title => $items)
            <div class="bg-blue-50 rounded-lg">
                <div class="hack">
                    <button class="toggle-btn text-blue-500 transition-all" data-target="#{{ Str::slug($title) }}">
                        <span class="toggle-icon">+</span>
                    </button>
                    <h2 class="land-title font-semibold text-lg text-blue-800" data-target="#{{ Str::slug($title) }}">{{ $title }}</h2>
                </div>
                <div id="{{ Str::slug($title) }}" class="hack1 dropdown hidden">
                    <ul style="color:#a6a6a6;" class="pl-6 pb-4 space-y-2">
                        @foreach ($items as $itemName => $itemData)
                        <li>
                            <a
                                href="{{ $itemData['enabled'] ? $itemData['url'] : '#' }}"
                                class="{{ $itemData['enabled'] ? 'right-section' : 'right-bar' }}"
                                {{ !$itemData['enabled'] ? 'aria-disabled="true"' : '' }}>
                                {{ $itemName }}
                            </a>
                        </li>
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
            const landTitles = document.querySelectorAll('.land-title');
            const toggleButtons1 = document.querySelectorAll('.toggle-btn1');
            const openAllBtn = document.getElementById('openAllBtn');
            const closeAllBtn = document.getElementById('closeAllBtn');
            const dropdowns = document.querySelectorAll('.dropdown');

            function saveDropdownStates() {
                const states = {};
                dropdowns.forEach(dropdown => {
                    states[dropdown.id] = !dropdown.classList.contains('hidden');
                });
                localStorage.setItem('dropdownStates', JSON.stringify(states));
            }

            function loadDropdownStates() {
                const states = JSON.parse(localStorage.getItem('dropdownStates'));
                if (states) {
                    dropdowns.forEach(dropdown => {
                        const isOpen = states[dropdown.id];
                        dropdown.classList.toggle('hidden', !isOpen);

                        const button = document.querySelector(`[data-target="#${dropdown.id}"]`);
                        if (button) {
                            const icon = button.querySelector('.toggle-icon');
                            if (icon) {
                                icon.textContent = isOpen ? '-' : '+';
                            }
                        }
                    });
                }
            }

            toggleButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const target = document.querySelector(button.getAttribute('data-target'));
                    const icon = button.querySelector('.toggle-icon');
                    target.classList.toggle('hidden');
                    icon.textContent = target.classList.contains('hidden') ? '+' : '-';
                    saveDropdownStates();
                });
            });

            landTitles.forEach(button => {
                button.addEventListener('click', () => {
                    const target = document.querySelector(button.getAttribute('data-target'));
                    const icon = button.previousElementSibling.querySelector('.toggle-icon');
                    target.classList.toggle('hidden');
                    icon.textContent = target.classList.contains('hidden') ? '+' : '-';
                    saveDropdownStates();
                });
            });

            toggleButtons1.forEach(button => {
                button.addEventListener('click', () => {
                    const target = document.querySelector(button.getAttribute('data-target'));
                    const icon = button.querySelector('.toggle-icon');
                    target.classList.toggle('hidden');
                    icon.textContent = target.classList.contains('hidden') ? '+' : '-';
                    saveDropdownStates();
                });
            });

            openAllBtn.addEventListener('click', () => {
                dropdowns.forEach(dropdown => dropdown.classList.remove('hidden'));
                toggleButtons.forEach(button => button.querySelector('.toggle-icon').textContent = '-');
                toggleButtons1.forEach(button => {
                    const icon = button.querySelector('.toggle-icon');
                    if (icon) icon.textContent = '-';
                });
                saveDropdownStates();
            });


            closeAllBtn.addEventListener('click', () => {
                dropdowns.forEach(dropdown => dropdown.classList.add('hidden'));
                toggleButtons.forEach(button => button.querySelector('.toggle-icon').textContent = '+');
                toggleButtons1.forEach(button => {
                    const icon = button.querySelector('.toggle-icon');
                    if (icon) icon.textContent = '+';
                });
                localStorage.removeItem('dropdownStates');
            });

            loadDropdownStates();

            
            // const toggleButtons = document.querySelectorAll('.toggle-btn');
            // const landTitles = document.querySelectorAll('.land-title');
            // const toggleButtons1 = document.querySelectorAll('.toggle-btn1');
            // const openAllBtn = document.getElementById('openAllBtn');
            // const closeAllBtn = document.getElementById('closeAllBtn');
            // const dropdowns = document.querySelectorAll('.dropdown');

            // toggleButtons.forEach(button => {
            //     button.addEventListener('click', () => {
            //         const target = document.querySelector(button.getAttribute('data-target'));
            //         const icon = button.querySelector('.toggle-icon');
            //         target.classList.toggle('hidden');
            //         icon.textContent = target.classList.contains('hidden') ? '+' : '-';
            //     });
            // });


            // landTitles.forEach(button => {
            //     button.addEventListener('click', () => {
            //         const target = document.querySelector(button.getAttribute('data-target'));
            //         const icon = button.querySelector('.toggle-icon');
            //         target.classList.toggle('hidden');
            //         icon.textContent = target.classList.contains('hidden') ? '+' : '-';
            //     });
            // });

            // toggleButtons1.forEach(button => {
            //     button.addEventListener('click', () => {
            //         const target = document.querySelector(button.getAttribute('data-target'));
            //         const icon = button.querySelector('.toggle-icon');
            //         target.classList.toggle('hidden');
            //         icon.textContent = target.classList.contains('hidden') ? '+' : '-';
            //     });
            // });

            // openAllBtn.addEventListener('click', () => {
            //     dropdowns.forEach(dropdown => dropdown.classList.remove('hidden'));
            //     toggleButtons.forEach(button => button.querySelector('.toggle-icon').textContent = '-');
            // });

            // closeAllBtn.addEventListener('click', () => {
            //     dropdowns.forEach(dropdown => dropdown.classList.add('hidden'));
            //     toggleButtons.forEach(button => button.querySelector('.toggle-icon').textContent = '+');
            // });

            // openAllBtn.addEventListener('click', () => {
            //     dropdowns.forEach(dropdown => dropdown.classList.remove('hidden'));
            //     toggleButtons1.forEach(button => button.querySelector('.toggle-icon').textContent = '-');
            // });

            // closeAllBtn.addEventListener('click', () => {
            //     dropdowns.forEach(dropdown => dropdown.classList.add('hidden'));
            //     toggleButtons1.forEach(button => button.querySelector('.toggle-icon').textContent = '+');
            // });

            const newButton = document.getElementById('newButton');
            const popupForm = document.getElementById('popupForm');
            const cancelButton = document.getElementById('cancelButton');
            const addQueryForm = document.getElementById('addQueryForm');
            const savedQueriesContainer = document.getElementById('savedQueriesContainer');
            const savedQueriesTable = document.getElementById('savedQueriesTable').querySelector('tbody');
            const seeAllButton = document.getElementById('seeAllButton');

            const queryModal = document.getElementById('queryModal');
            const queryDetails = document.getElementById('queryDetails');
            const editButton = document.getElementById('editButton');
            const deleteButton = document.getElementById('deleteButton');
            const closeQueryModal = document.getElementById('closeQueryModal');
            let selectedQueryIndex = null;

            newButton.addEventListener('click', () => {
                popupForm.style.display = 'flex';
                addQueryForm.dataset.mode = 'add';
                addQueryForm.reset();
            });

            cancelButton.addEventListener('click', () => {
                popupForm.style.display = 'none';
            });



            function loadSavedQueries(showAll = false) {
                const queries = JSON.parse(localStorage.getItem('queries')) || [];
                savedQueriesTable.innerHTML = '';

                if (queries.length > 0) {
                    savedQueriesContainer.style.display = 'block';

                    const queriesToDisplay = showAll ? queries : queries.slice(Math.max(queries.length - 5, 0));

                    queriesToDisplay.forEach((query, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                <td>${query.date}</td>
                <td>${query.table}</td>
                <td>${query.author}</td>
                <td>${query.description}</td>
            `;
                        row.addEventListener('click', () => openQueryModal(query, showAll ? index : queries.length - 5 + index));
                        savedQueriesTable.appendChild(row);
                    });

                    seeAllButton.textContent = showAll ? 'Close All' : 'Show All';
                    if (showAll) {
                        addTableScroll();
                    } else {
                        addTableScroll();
                    }
                } else {
                    savedQueriesContainer.style.display = 'none';
                }
            }



            function openQueryModal(query, index) {
                selectedQueryIndex = index;
                queryDetails.innerHTML = `
        <p><strong>Date:</strong> ${query.date}</p>
        <p><strong>Table:</strong> ${query.table}</p>
        <p><strong>Author:</strong> ${query.author}</p>
        <p><strong>Description:</strong> ${query.description}</p>
    `;
                queryModal.style.display = 'flex';
            }

            editButton.addEventListener('click', () => {
                const queries = JSON.parse(localStorage.getItem('queries')) || [];
                const query = queries[selectedQueryIndex];

                addQueryForm.dataset.mode = 'edit';
                addQueryForm.dataset.editIndex = selectedQueryIndex;

                Array.from(addQueryForm.table.options).forEach(option => {
                    if (option.text === query.table) option.selected = true;
                });

                Array.from(addQueryForm.author.options).forEach(option => {
                    if (option.text === query.author) option.selected = true;
                });

                addQueryForm.description.value = query.description;

                queryModal.style.display = 'none';
                popupForm.style.display = 'flex';
            });

            deleteButton.addEventListener('click', () => {
                if (confirm('Are you sure you want to delete this query?')) {
                    const queries = JSON.parse(localStorage.getItem('queries')) || [];
                    queries.splice(selectedQueryIndex, 1);
                    localStorage.setItem('queries', JSON.stringify(queries));

                    queryModal.style.display = 'none';
                    loadSavedQueries(seeAllButton.textContent === 'Close All');
                }
            });

            closeQueryModal.addEventListener('click', () => {
                queryModal.style.display = 'none';
            });

            seeAllButton.addEventListener('click', () => {
                const isShowingAll = seeAllButton.textContent === 'Show All';
                loadSavedQueries(isShowingAll);
            });

            addQueryForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const table = this.table.options[this.table.selectedIndex].text;
                const author = this.author.options[this.author.selectedIndex].text;
                const description = this.description.value;
                const queries = JSON.parse(localStorage.getItem('queries')) || [];

                if (this.dataset.mode === 'edit') {
                    const editIndex = parseInt(this.dataset.editIndex);
                    queries[editIndex] = {
                        ...queries[editIndex],
                        table,
                        author,
                        description
                    };
                } else {
                    const date = new Date().toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: '2-digit',
                        year: '2-digit'
                    });
                    queries.push({
                        date,
                        table,
                        author,
                        description
                    });
                }

                localStorage.setItem('queries', JSON.stringify(queries));
                loadSavedQueries(seeAllButton.textContent === 'Close All');

                popupForm.style.display = 'none';
                this.reset();
            });

            function addTableScroll() {
                savedQueriesContainer.style.maxHeight = '250px';
                savedQueriesContainer.style.overflowY = 'scroll';
            }

            function removeTableScroll() {
                savedQueriesContainer.style.maxHeight = '';
                savedQueriesContainer.style.overflowY = '';
            }

            window.onload = () => loadSavedQueries(false);

        });
    </script>
    <style>
        body {
            background: white;
        }

        .land-title {
            color: #010066;
            cursor: pointer;
        }

        .land-title:hover {
            text-decoration: underline;
        }

        .main-black {
            color:#a6a6a6;
        }

        .main-blue {
            color: #010066;
        }


        .left-section-subitems {
            font-size: 1rem;
        }

        .left-section-subitems li a {
            text-decoration: none;
        }

        .left-section-subitems li a:hover {
            text-decoration: underline;
        }

        .right-section {
            text-decoration: none;
            color: #010066;
        }

        .right-section:hover {
            text-decoration: underline;
        }

        .right-bar {
            text-decoration: none;
            cursor: text;
            color:#a6a6a6;
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

        .toggle-btn1 {
            background: none;
            border: 1px solid white;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-icon {
            font-size: 1rem;
            padding: 1px;
            color: #010066;
        }

        .new-button {
            padding: 3px 12px;
            font-size: 1rem;
            margin-left: -65px;
            /* background-color: white; */
            color: black;
            border: none;
            cursor: pointer;
        }

        .see-button {
            padding: 3px 8px;
            font-size: 1rem;
            /* background-color: white; */
            color: black;
            border: none;
            cursor: pointer;
        }

        .tb {
            display: flex;
            gap: 145px;
            margin-top: -15px;
        }

        .popup-form {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1;
        }

        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 400px;
        }

        .popup-content h3 {
            margin-bottom: 15px;
        }

        .popup-content label {
            font-size: 14px;
        }

        .popup-content select,
        .popup-content textarea {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .popup-content button {
            padding: 10px 15px;
            margin-top: 10px;
            border: none;
            cursor: pointer;
        }

        .save-button {
            background-color: #4caf50;
            color: white;
        }

        .save-button:hover {
            background-color: #45a049;
        }

        .cancel-button {
            background-color: #f44336;
            color: white;
        }

        .cancel-button:hover {
            background-color: #da190b;
        }

        .saved-queries-container {
            max-width: 100%;
            overflow-x: auto;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
            margin-left: -65px;
            padding: 5px;
        }

        .saved-queries-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-family: "Arial", sans-serif;
        }

        .saved-queries-table thead th {
            background-color: #010066;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            padding: 8px;
            border: 1px solid black;
            width: 25%;
        }

        .saved-queries-table tbody td {
            padding: 5px;
            border-bottom: 1px solid black;
            color: #333;
            font-size: 14px;
        }

        .saved-queries-table th {
            border: 1px solid white;
        }

        .saved-queries-table td {
            border: 1px solid black;
        }

        .saved-queries-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .saved-queries-table tbody tr:hover {
            background-color: #578FCA;
            transition: background-color 0.3s ease;
        }

        @media (max-width: 768px) {
            .saved-queries-container {
                padding: 5px;
            }

            .saved-queries-table thead th {
                border: 1px solid white;
                padding: 8px;
                font-size: 12px;
            }

            .saved-queries-table tbody td {
                border: 1px solid black;
                padding: 8px;
                font-size: 12px;
            }
        }

        #queryModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        #queryDetails p {
            margin: 10px 0;
            font-size: 1em;
            color: #555;
        }

        .edit-button {
            background-color: #28a745;
            color: #fff;
        }

        .delete-button {
            background-color: #dc3545;
            color: #fff;
        }

        .close-button {
            background-color: #007bff;
            color: #fff;
        }
    </style>

</div>
