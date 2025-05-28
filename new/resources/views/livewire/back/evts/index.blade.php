<div>
    @include('components.breadcrumb', [
    'title' => auth()->user()->hasRole('Manager') ? 'Espace Manager' : 'Espace Administrateur',
    'breadcrumbItems' => [['text' => 'Vue', 'url' => '#'] , ['text' => 'OPPvue', 'url' => '#'] , ['text' => 'OPPform', 'url' => '#']],
    ])
    <div class="row">

        <div class="card">
            <h2 style="font-size:1.2rem;margin-top:2%; margin-left:1.4%;" class="page-title">OPP : EIFFAGE CLEMESSY MULHOUSE / Responsable Sureté Nucléaire</h2>
            <div class="card-header">
                <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ $step == 1 ? 'active' : '' }} fw-bold {{ $step != 1 ? 'enabled' : '' }}"
                            href="/opportunity">
                            Description
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $step == 4 ? 'active' : '' }} fw-bold {{ $step != 4 ? 'enabled' : '' }}"
                            href="/job">
                            F.P.
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $step == 2 ? 'active' : '' }} fw-bold {{ $step != 2 ? 'enabled' : '' }}"
                            href="/management">
                            CDTlist
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $step == 4 ? 'active' : '' }} fw-bold {{ $step != 4 ? 'enabled' : '' }}"
                            data-bs-toggle="tab" href="/evts" role="tab">
                            Hiring
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $step == 3 ? 'active' : '' }} fw-bold {{ $step != 3 ? 'enabled' : '' }}"
                            href="/opportunity#invoicement">
                            Facturation
                        </a>
                    </li>

                </ul>
            </div>



            <div class="interview-form">
                <!-- PUSCH CV Section -->
                <div class="form-section">
                    <div class="section-header">PUSCH CV</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Sent_TRG</label>
                            <input style="width:auto;" type="date" class="form-input" placeholder="dd/mm/yy">
                        </div>
                        <div class="form-group">
                            <label>Retour</label>
                            <select class="form-select">
                                <option value="">Select</option>
                                <option value="positif">Positif</option>
                                <option value="en-cours">En cours</option>
                                <option value="negatif">Négatif</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Debrief TRG</label>
                            <input type="text" class="form-input wide" value="">
                        </div>
                        <div class="form-group">
                            <label>Rém. souhaitée</label>
                            <input type="text" class="form-input">
                        </div>
                        <div class="form-group">
                            <label>Préf. géo</label>
                            <input type="text" class="form-input">
                        </div>
                        <div class="form-group">
                            <label>Mobilité</label>
                            <select class="form-select">
                                <option value="">Select</option>
                                <option value="non">Non</option>
                                <option value="regionale">Régionale</option>
                                <option value="nationale">Nationale</option>
                                <option value="internationale">Internationale</option>
                            </select>
                        </div>
                    </div>

                    <!-- RV Tél. 1 -->
                    <!-- <div class="form-section"> -->
                    <div class="section-header">RV Tél. 1</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Prévu</label>
                            <input style="width:auto;" type="date" class="form-input" placeholder="dd/mm/yy">
                        </div>
                        <div class="form-group">
                            <label>Statut</label>
                            <input type="text" class="form-input" value="">
                        </div>
                        <div class="form-group">
                            <label>Avec</label>
                            <input type="text" class="form-input" value="">
                        </div>
                        <div class="form-group">
                            <label>Fonction</label>
                            <input type="text" class="form-input">
                        </div>
                        <div class="form-group">
                            <label>Comment./Debrief</label>
                            <input type="text" class="form-input extra-wide" value="">
                        </div>
                        <div class="form-group">
                            <label>Retour</label>
                            <select class="form-select">
                                <option value="">Select</option>
                                <option value="positif">Positif</option>
                                <option value="en-cours">En cours</option>
                                <option value="negatif">Négatif</option>
                            </select>
                        </div>
                    </div>


                    <!-- Visio -->

                    <div class="section-header">Visio</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Prévu</label>
                            <input style="width:auto;" type="date" class="form-input" placeholder="dd/mm/yy">
                        </div>
                        <div class="form-group">
                            <label>Statut</label>
                            <input type="text" class="form-input" value="">
                        </div>
                        <div class="form-group">
                            <label>Avec</label>
                            <input type="text" class="form-input" value="">
                        </div>
                        <div class="form-group">
                            <label>Fonction</label>
                            <input type="text" class="form-input">
                        </div>
                        <div class="form-group">
                            <label>Comment./Debrief</label>
                            <input type="text" class="form-input extra-wide">
                        </div>
                        <div class="form-group">
                            <label>Retour</label>
                            <select class="form-select">
                                <option value="">Select</option>
                                <option value="positif">Positif</option>
                                <option value="en-cours">En cours</option>
                                <option value="negatif">Négatif</option>
                            </select>
                        </div>
                    </div>

                    <!-- RV PHYSIQUE 1 -->

                    <div class="section-header">RV PHYSIQUE 1</div>
                    <div class="form-content">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Prévu</label>
                                <input style="width:auto;" type="date" class="form-input" placeholder="dd/mm/yy">
                            </div>
                            <div class="form-group">
                                <label>Statut</label>
                                <input type="text" class="form-input" value="">
                            </div>
                            <div class="participant-column">
                                <label>Avec</label>
                                <div class="stacked-inputs">
                                    <input type="text" class="form-input" value="">
                                    <input type="text" class="form-input" value="">
                                    <input type="text" class="form-input" value="">
                                </div>
                            </div>
                            <div class="function-column">
                                <label>Fonction</label>
                                <div class="stacked-inputs">
                                    <input type="text" class="form-input" value="">
                                    <input type="text" class="form-input" value="">
                                    <input type="text" class="form-input" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Comment./Debrief</label>
                                <textarea style="height:160px;" type="text" class="form-input extra-wide"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Retour</label>
                                <select class="form-select">
                                    <option value="">Select</option>
                                    <option value="positif">Positif</option>
                                    <option value="en-cours">En cours</option>
                                    <option value="negatif">Négatif</option>
                                </select>
                            </div>
                        </div>
                        <div style="margin-top:-12%;" class="form-row">
                            <div class="form-group">
                                <label>Lieu</label>
                                <input style="width:300px;" type="text" class="form-input">
                            </div>
                        </div>
                    </div>

                    <!-- RV PHYSIQUE 2 -->

                    <div class="section-header">RV PHYSIQUE 2</div>
                    <div class="form-content">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Prévu</label>
                                <input style="width:auto;" type="date" class="form-input" placeholder="dd/mm/yy">
                            </div>
                            <div class="form-group">
                                <label>Statut</label>
                                <input type="text" class="form-input" value="">
                            </div>
                            <div class="participant-column">
                                <label>Avec</label>
                                <div class="stacked-inputs">
                                    <input type="text" class="form-input" value="">
                                    <input type="text" class="form-input" value="">
                                    <input type="text" class="form-input" value="">
                                </div>
                            </div>
                            <div class="function-column">
                                <label>Fonction</label>
                                <div class="stacked-inputs">
                                    <input type="text" class="form-input" value="">
                                    <input type="text" class="form-input" value="">
                                    <input type="text" class="form-input" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Comment./Debrief</label>
                                <textarea style="height:160px;" type="text" class="form-input extra-wide"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Retour</label>
                                <select class="form-select">
                                    <option value="">Select</option>
                                    <option value="positif">Positif</option>
                                    <option value="en-cours">En cours</option>
                                    <option value="negatif">Négatif</option>
                                </select>
                            </div>
                        </div>
                        <div style="margin-top:-12%;" class="form-row">
                            <div class="form-group">
                                <label>Lieu</label>
                                <input style="width:300px;" type="text" class="form-input">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <script>
                document.querySelectorAll('.form-select').forEach(select => {
                    if (select.value) {
                        select.setAttribute('data-selected', select.value);
                    }

                    select.addEventListener('change', function() {
                        if (this.value) {
                            this.setAttribute('data-selected', this.value);
                        } else {
                            this.removeAttribute('data-selected');
                        }
                    });
                })
            </script>
            <style>
                .interview-form {
                    font-family: 'Inter', system-ui, -apple-system, sans-serif;
                    max-width: 1200px;
                    padding: 2rem;
                    color: #1a1a1a;
                }

                .form-section {
                    margin-bottom: 1rem;
                    background: #ffffff;
                    border-radius: 12px;
                    padding: 1.5rem;
                    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
                    transition: box-shadow 0.2s ease-in-out;
                }

                .form-section:hover {
                    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
                }

                .section-header {
                    font-size: 1.125rem;
                    font-weight: 600;
                    margin-bottom: 0.8rem;
                    color: #111827;
                    letter-spacing: -0.025em;
                }

                .form-row {
                    display: flex;
                    align-items: flex-start;
                    gap: 1.5rem;
                    margin-bottom: 1.5rem;
                    flex-wrap: wrap;
                }

                .form-group {
                    margin-bottom: 1rem;
                }

                .form-group label {
                    display: block;
                    font-size: 0.875rem;
                    margin-bottom: 0.5rem;
                    color: #4b5563;
                    font-weight: 500;
                }

                .form-input,
                .form-select {
                    background-color: #f9fafb;
                    border: 1px solid #006BFF;
                    border-radius: 8px;
                    padding: 0.75rem 1rem;
                    font-size: 0.875rem;
                    width: 120px;
                    transition: all 0.2s ease-in-out;
                }

                .form-input:hover,
                .form-select:hover {
                    border-color: #d1d5db;
                }

                .form-input:focus,
                .form-select:focus {
                    outline: none;
                    border-color: #2563eb;
                    box-shadow: 0 0 0 4px rgb(37 99 235 / 0.1);
                }

                .form-input.wide {
                    width: 200px;
                }

                .form-input.extra-wide {
                    width: 300px;
                    /* height: 150px; */
                }

                .form-select {
                    height: 42px;
                    appearance: none;
                    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
                    background-repeat: no-repeat;
                    background-position: right 0.75rem center;
                    background-size: 1rem;
                    padding-right: 2.5rem;
                }

                .form-input[readonly] {
                    background-color: #f3f4f6;
                    border-color: #e5e7eb;
                    cursor: not-allowed;
                    color: #6b7280;
                }

                .multi-participant {
                    display: grid;
                    grid-template-columns: 200px 300px 1fr auto;
                    gap: 1.5rem;
                    align-items: start;
                }

                .participant-column,
                .function-column {
                    display: flex;
                    flex-direction: column;
                    gap: 0.75rem;
                }

                .stacked-inputs {
                    display: flex;
                    flex-direction: column;
                    gap: 0.75rem;
                    margin-top: -12px;
                }

                .full-width {
                    width: 100%;
                }

                .full-width .form-input {
                    width: 100%;
                }

                /* Base styles for both inputs and selects */
                .form-input,
                .form-select {
                    background-color: #f9fafb;
                    border: 1px solid #006BFF;
                    border-radius: 8px;
                    padding: 0.75rem 1rem;
                    font-size: 0.875rem;
                    width: 120px;
                    transition: all 0.2s ease-in-out;
                }

                .form-select {
                    cursor: pointer;
                    appearance: none;
                    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23006BFF'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
                    background-repeat: no-repeat;
                    background-position: right 0.75rem center;
                    background-size: 1rem;
                    padding-right: 2.5rem;
                }

                .form-select option {
                    padding: 0.75rem 1rem;
                }

                .form-select option[value="positif"],
                .form-select[data-selected="positif"] {
                    color: #047857;
                    background-color: #ecfdf5;
                }

                .form-select option[value="en-cours"],
                .form-select[data-selected="en-cours"] {
                    color: #b45309;
                    background-color: #fffbeb;
                }

                .form-select option[value="negatif"],
                .form-select[data-selected="negatif"] {
                    color: #b91c1c;
                    background-color: #fef2f2;
                }

                .form-select:focus {
                    outline: none;
                    box-shadow: 0 0 0 2px rgba(0, 107, 255, 0.2);
                }

                /* Modern custom scrollbar */
                .form-select::-webkit-scrollbar {
                    width: 8px;
                }

                .form-select::-webkit-scrollbar-track {
                    background: #f1f1f1;
                    border-radius: 4px;
                }

                .form-select::-webkit-scrollbar-thumb {
                    background: #d1d5db;
                    border-radius: 4px;
                }

                .form-select::-webkit-scrollbar-thumb:hover {
                    background: #9ca3af;
                }

                @media (max-width: 1200px) {
                    .multi-participant {
                        grid-template-columns: repeat(2, 1fr);
                        gap: 1rem;
                    }
                }

                @media (max-width: 768px) {
                    .interview-form {
                        padding: 1rem;
                    }

                    .form-section {
                        padding: 1rem;
                    }

                    .form-row {
                        flex-direction: column;
                        gap: 1rem;
                    }

                    .form-input,
                    .form-select,
                    .form-input.wide,
                    .form-input.extra-wide {
                        width: 100%;
                    }

                    .multi-participant {
                        grid-template-columns: 1fr;
                    }
                }


                @media (prefers-color-scheme: dark) {
                    .interview-form {
                        color: #e5e7eb;
                    }

                    .form-section {
                        background: #1f2937;
                        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.4);
                    }

                    .section-header {
                        color: #f3f4f6;
                    }

                    .form-group label {
                        color: #d1d5db;
                    }

                    .form-input,
                    .form-select {
                        background-color: #374151;
                        border-color: #4b5563;
                        color: #e5e7eb;
                    }

                    .form-input:hover,
                    .form-select:hover {
                        border-color: #6b7280;
                    }

                    .form-input[readonly] {
                        background-color: #1f2937;
                        border-color: #374151;
                        color: #9ca3af;
                    }
                }
            </style>
        </div>
