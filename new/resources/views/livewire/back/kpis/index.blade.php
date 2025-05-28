<div class="p-6 bg-gray-100 min-h-screen">
    @include('components.breadcrumb', [
    'title' => auth()->user()->hasRole('Administrateur') ? 'Espace Administrateur' : (
    auth()->user()->hasRole('Manager') ? 'Espace Manager' : (
    auth()->user()->hasRole('CST+') ? 'Espace Consultant+' : 'Espace Consultant'
    )
    ),
    'breadcrumbItems' => [['text' => 'KPIs', 'url' => '#']],
    ])

    <div class="heading">
        <h4 class="headDate">KPIs - <span id="date"></span></h4>
        <h5 class="tableHead">Table - Graphs -<span wire:click="toggleFormOBJ" class="objectives">Objectives </span></h5>
    </div>

    <div class="kpi-section">
        <h6 class="section-title">TARGETS</h6>
        @if (session()->has('message'))
        <div class="d-flex justify-content-left">
            <div style="font-weight:bold;" class="alert alert-success alert-dismissible fade show " role="alert" id="successAlert">
                {{ session()->get('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        </div>
        @endif
        @if($latestTrgDoneEntry && $latestTrgObjEntry)
        <div class="table-container">
            @php

            $trgCallsPerformance = 0;
            if ($latestTrgDoneEntry && $latestTrgObjEntry && $latestTrgObjEntry->trg_calls_obj > 0) {
            $trgCallsPerformance = round(($latestTrgDoneEntry->trg_calls_done / $latestTrgObjEntry->trg_calls_obj) * 100);
            }

            $trgWnPerformance = 0;
            if ($latestTrgDoneEntry && $latestTrgObjEntry && $latestTrgObjEntry->trg_wn_obj > 0) {
            $trgWnPerformance = round(($latestTrgDoneEntry->trg_wn_done / $latestTrgObjEntry->trg_wn_obj) * 100);
            }

            $trgNrpPerformance = 0;
            if ($latestTrgDoneEntry && $latestTrgObjEntry && $latestTrgObjEntry->trg_nrp_obj > 0) {
            $trgNrpPerformance = round(($latestTrgDoneEntry->trg_nrp_done / $latestTrgObjEntry->trg_nrp_obj) * 100);
            }

            $trgCtcPerformance = 0;
            if ($latestTrgDoneEntry && $latestTrgObjEntry && $latestTrgObjEntry->trg_ctc_obj > 0) {
            $trgCtcPerformance = round(($latestTrgDoneEntry->trg_ctc_done / $latestTrgObjEntry->trg_ctc_obj) * 100);
            }

            $trgRvPerformance = 0;
            if ($latestTrgDoneEntry && $latestTrgObjEntry && $latestTrgObjEntry->trg_rv_obj > 0) {
            $trgRvPerformance = round(($latestTrgDoneEntry->trg_rv_done / $latestTrgObjEntry->trg_rv_obj) * 100);
            }

            $trgBqfPerformance = 0;
            if ($latestTrgDoneEntry && $latestTrgObjEntry && $latestTrgObjEntry->trg_bqf_obj > 0) {
            $trgBqfPerformance = round(($latestTrgDoneEntry->trg_bqf_done / $latestTrgObjEntry->trg_bqf_obj) * 100);
            }

            $trgKlfPerformance = 0;
            if ($latestTrgDoneEntry && $latestTrgObjEntry && $latestTrgObjEntry->trg_klf_obj > 0) {
            $trgKlfPerformance = round(($latestTrgDoneEntry->trg_klf_done / $latestTrgObjEntry->trg_klf_obj) * 100);
            }

            $trgHrdPerformance = 0;
            if ($latestTrgDoneEntry && $latestTrgObjEntry && $latestTrgObjEntry->trg_hrd_obj > 0) {
            $trgHrdPerformance = round(($latestTrgDoneEntry->trg_hrd_done / $latestTrgObjEntry->trg_hrd_obj) * 100);
            }

            // Gap Calculation of Lats 7 days, 30 days, 12 months and Overall :

            // Last 7 days:
            $trgCallsGap_7 = ($averages['7_days']['trg_calls_obj'] > 0)
            ? round(($averages['7_days']['trg_calls_done'] / $averages['7_days']['trg_calls_obj']) * 100)
            : 0;

            $trgCtcGap_7 = ($averages['7_days']['trg_ctc_obj'] > 0)
            ? round(($averages['7_days']['trg_ctc_done'] / $averages['7_days']['trg_ctc_obj']) * 100)
            : 0;

            $trgRvGap_7 = ($averages['7_days']['trg_rv_obj'] > 0)
            ? round(($averages['7_days']['trg_rv_done'] / $averages['7_days']['trg_rv_obj']) * 100)
            : 0;

            $trgBqfGap_7 = ($averages['7_days']['trg_bqf_obj'] > 0)
            ? round(($averages['7_days']['trg_bqf_done'] / $averages['7_days']['trg_bqf_obj']) * 100)
            : 0;

            $trgKlfGap_7 = ($averages['7_days']['trg_klf_obj'] > 0)
            ? round(($averages['7_days']['trg_klf_done'] / $averages['7_days']['trg_klf_obj']) * 100)
            : 0;

            $trgHrdGap_7 = ($averages['7_days']['trg_hrd_obj'] > 0)
            ? round(($averages['7_days']['trg_hrd_done'] / $averages['7_days']['trg_hrd_obj']) * 100)
            : 0;

            // Last 30 days:
            $trgCallsGap_30 = ($averages['30_days']['trg_calls_obj'] > 0)
            ? round(($averages['30_days']['trg_calls_done'] / $averages['30_days']['trg_calls_obj']) * 100)
            : 0;

            $trgCtcGap_30 = ($averages['30_days']['trg_ctc_obj'] > 0)
            ? round(($averages['30_days']['trg_ctc_done'] / $averages['30_days']['trg_ctc_obj']) * 100)
            : 0;

            $trgRvGap_30 = ($averages['30_days']['trg_rv_obj'] > 0)
            ? round(($averages['30_days']['trg_rv_done'] / $averages['30_days']['trg_rv_obj']) * 100)
            : 0;

            $trgBqfGap_30 = ($averages['30_days']['trg_bqf_obj'] > 0)
            ? round(($averages['30_days']['trg_bqf_done'] / $averages['30_days']['trg_bqf_obj']) * 100)
            : 0;

            $trgKlfGap_30 = ($averages['30_days']['trg_klf_obj'] > 0)
            ? round(($averages['30_days']['trg_klf_done'] / $averages['30_days']['trg_klf_obj']) * 100)
            : 0;

            $trgHrdGap_30 = ($averages['30_days']['trg_hrd_obj'] > 0)
            ? round(($averages['30_days']['trg_hrd_done'] / $averages['30_days']['trg_hrd_obj']) * 100)
            : 0;

            // Last 12 months:
            $trgCallsGap_12 = ($averages['12_months']['trg_calls_obj'] > 0)
            ? round(($averages['12_months']['trg_calls_done'] / $averages['12_months']['trg_calls_obj']) * 100)
            : 0;

            $trgCtcGap_12 = ($averages['12_months']['trg_ctc_obj'] > 0)
            ? round(($averages['12_months']['trg_ctc_done'] / $averages['12_months']['trg_ctc_obj']) * 100)
            : 0;

            $trgRvGap_12 = ($averages['12_months']['trg_rv_obj'] > 0)
            ? round(($averages['12_months']['trg_rv_done'] / $averages['12_months']['trg_rv_obj']) * 100)
            : 0;

            $trgBqfGap_12 = ($averages['12_months']['trg_bqf_obj'] > 0)
            ? round(($averages['12_months']['trg_bqf_done'] / $averages['12_months']['trg_bqf_obj']) * 100)
            : 0;

            $trgKlfGap_12 = ($averages['12_months']['trg_klf_obj'] > 0)
            ? round(($averages['12_months']['trg_klf_done'] / $averages['12_months']['trg_klf_obj']) * 100)
            : 0;

            $trgHrdGap_12 = ($averages['12_months']['trg_hrd_obj'] > 0)
            ? round(($averages['12_months']['trg_hrd_done'] / $averages['12_months']['trg_hrd_obj']) * 100)
            : 0;

            // Overall:
            $trgCallsGap_overall = ($averages['overall']['trg_calls_obj'] > 0)
            ? round(($averages['overall']['trg_calls_done'] / $averages['overall']['trg_calls_obj']) * 100)
            : 0;

            $trgCtcGap_overall = ($averages['overall']['trg_ctc_obj'] > 0)
            ? round(($averages['overall']['trg_ctc_done'] / $averages['overall']['trg_ctc_obj']) * 100)
            : 0;

            $trgRvGap_overall = ($averages['overall']['trg_rv_obj'] > 0)
            ? round(($averages['overall']['trg_rv_done'] / $averages['overall']['trg_rv_obj']) * 100)
            : 0;

            $trgBqfGap_overall = ($averages['overall']['trg_bqf_obj'] > 0)
            ? round(($averages['overall']['trg_bqf_done'] / $averages['overall']['trg_bqf_obj']) * 100)
            : 0;

            $trgKlfGap_overall = ($averages['overall']['trg_klf_obj'] > 0)
            ? round(($averages['overall']['trg_klf_done'] / $averages['overall']['trg_klf_obj']) * 100)
            : 0;

            $trgHrdGap_overall = ($averages['overall']['trg_hrd_obj'] > 0)
            ? round(($averages['overall']['trg_hrd_done'] / $averages['overall']['trg_hrd_obj']) * 100)
            : 0;


            @endphp
            <table class="kpi-table">
                <thead>
                    <tr>
                        <th rowspan="2">N of</th>
                        <th style="border-right:2px solid black;" colspan="3">Last day : <span>{{ $latestTrgObjEntry ? $latestTrgObjEntry->trg_date : '0' }}</span></th>
                        <th style="border-right:2px solid black;" colspan="3">Last 7 days</th>
                        <th style="border-right:2px solid black;" colspan="3">Last 30 days</th>
                        <th style="border-right:2px solid black;" colspan="3">Last 12 months</th>
                        <th colspan="3">Overall</th>
                    </tr>
                    <tr>
                        <th>Done</th>
                        <th>Obj</th>
                        <th style="border-right:2px solid black;">Gap</th>
                        <th>Done</th>
                        <th>Obj</th>
                        <th style="border-right:2px solid black;">Gap</th>
                        <th>Done</th>
                        <th>Obj</th>
                        <th style="border-right:2px solid black;">Gap</th>
                        <th>Done</th>
                        <th>Obj</th>
                        <th style="border-right:2px solid black;">Gap</th>
                        <th>Done</th>
                        <th>Obj</th>
                        <th>Gap</th>
                    </tr>
                </thead>
                <tbody id="kpiTableBody">
                    <tr>
                        <td class="aspect">Calls</td>
                        <td> {{ $latestTrgDoneEntry ? $latestTrgDoneEntry->trg_calls_done : '0' }}</td>
                        <td contenteditable="false"> {{ $latestTrgObjEntry ? $latestTrgObjEntry->trg_calls_obj : '0' }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgCallsPerformance }}%</td>
                        <td contenteditable="false"> {{ number_format($averages['7_days']['trg_calls_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['trg_calls_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgCallsGap_7 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['trg_calls_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['trg_calls_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgCallsGap_30 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['trg_calls_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['trg_calls_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgCallsGap_12 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['trg_calls_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['trg_calls_obj'], 0) }}</td>
                        <td style="font-weight:bold;" contenteditable="false">{{ $trgCallsGap_overall }}%</td>
                    </tr>
                    <tr>
                        <td class="aspect">WN</td>
                        <td contenteditable="false"> {{ $latestTrgDoneEntry ? $latestTrgDoneEntry->trg_wn_done : '0' }}</td>
                        <td class="dark" contenteditable="false"></td>
                        <td class="dark" style="font-weight:bold; border-right:2px solid black;" contenteditable="false"></td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['trg_wn_done'], 0) }}</td>
                        <td class="dark" contenteditable="false"></td>
                        <td class="dark" style="font-weight:bold; border-right:2px solid black;" contenteditable="false"></td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['trg_wn_done'], 0) }}</td>
                        <td class="dark" contenteditable="false"></td>
                        <td class="dark" style="font-weight:bold; border-right:2px solid black;" contenteditable="false"></td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['trg_wn_done'], 0) }}</td>
                        <td class="dark" contenteditable="false"></td>
                        <td class="dark" style="font-weight:bold; border-right:2px solid black;" contenteditable="false"></td>
                        <td contenteditable="false">{{ number_format($averages['overall']['trg_wn_done'], 0) }}</td>
                        <td class="dark" contenteditable="false"></td>
                        <td class="dark" contenteditable="false"></td>
                    </tr>
                    <tr>
                        <td class="aspect">NRP</td>
                        <td contenteditable="false"> {{ $latestTrgDoneEntry ? $latestTrgDoneEntry->trg_nrp_done : '0' }}</td>
                        <td class="dark" contenteditable="false"></td>
                        <td class="dark" style="font-weight:bold; border-right:2px solid black;" contenteditable="false"></td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['trg_nrp_done'], 0) }}</td>
                        <td class="dark" contenteditable="false"></td>
                        <td class="dark" style="font-weight:bold; border-right:2px solid black;" contenteditable="false"></td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['trg_nrp_done'], 0) }}</td>
                        <td class="dark" contenteditable="false"></td>
                        <td class="dark" style="font-weight:bold; border-right:2px solid black;" contenteditable="false"></td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['trg_nrp_done'], 0) }}</td>
                        <td class="dark" contenteditable="false"></td>
                        <td class="dark" style="font-weight:bold; border-right:2px solid black;" contenteditable="false"></td>
                        <td contenteditable="false">{{ number_format($averages['overall']['trg_nrp_done'], 0) }}</td>
                        <td class="dark" contenteditable="false"></td>
                        <td class="dark" contenteditable="false"></td>
                    </tr>
                    <tr>
                        <td class="aspect">CTC</td>
                        <td contenteditable="false"> {{ $latestTrgDoneEntry ? $latestTrgDoneEntry->trg_ctc_done : '0' }}</td>
                        <td contenteditable="false">{{ $latestTrgObjEntry ? $latestTrgObjEntry->trg_ctc_obj : '0' }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgCtcPerformance }}%</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['trg_ctc_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['trg_ctc_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgCtcGap_7 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['trg_ctc_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['trg_ctc_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgCtcGap_30 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['trg_ctc_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['trg_ctc_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgCtcGap_12 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['trg_ctc_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['trg_ctc_obj'], 0) }}</td>
                        <td style="font-weight:bold;" contenteditable="false">{{ $trgCtcGap_overall }}%</td>
                    </tr>
                    <tr>
                        <td class="aspect">RV</td>
                        <td contenteditable="false"> {{ $latestTrgDoneEntry ? $latestTrgDoneEntry->trg_rv_done : '0' }}</td>
                        <td contenteditable="false">{{ $latestTrgObjEntry ? $latestTrgObjEntry->trg_rv_obj : '0' }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgRvPerformance }}%</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['trg_rv_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['trg_rv_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgRvGap_7 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['trg_rv_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['trg_rv_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgRvGap_30 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['trg_rv_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['trg_rv_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgRvGap_12 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['trg_rv_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['trg_rv_obj'], 0) }}</td>
                        <td style="font-weight:bold;" contenteditable="false">{{ $trgRvGap_overall }}%</td>
                    </tr>
                    <tr>
                        <td class="aspect">BQF</td>
                        <td contenteditable="false"> {{ $latestTrgDoneEntry ? $latestTrgDoneEntry->trg_bqf_done : '0' }}</td>
                        <td contenteditable="false">{{ $latestTrgObjEntry ? $latestTrgObjEntry->trg_bqf_obj : '0' }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgBqfPerformance }}%</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['trg_bqf_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['trg_bqf_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{$trgBqfGap_7 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['trg_bqf_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['trg_bqf_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgBqfGap_30 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['trg_bqf_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['trg_bqf_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgBqfGap_12 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['trg_bqf_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['trg_bqf_obj'], 0) }}</td>
                        <td style="font-weight:bold;" contenteditable="false">{{ $trgBqfGap_overall }}%</td>
                    </tr>
                    <tr>
                        <td class="aspect">KLF</td>
                        <td contenteditable="false"> {{ $latestTrgDoneEntry ? $latestTrgDoneEntry->trg_klf_done : '0' }}</td>
                        <td contenteditable="false">{{ $latestTrgObjEntry ? $latestTrgObjEntry->trg_klf_obj : '0' }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgKlfPerformance }}%</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['trg_klf_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['trg_klf_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgKlfGap_7 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['trg_klf_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['trg_klf_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgKlfGap_30 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['trg_klf_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['trg_klf_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgKlfGap_12 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['trg_klf_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['trg_klf_obj'], 0) }}</td>
                        <td style="font-weight:bold;" contenteditable="false">{{ $trgKlfGap_overall }}%</td>
                    </tr>
                    <tr>
                        <td class="aspect">HRD</td>
                        <td contenteditable="false">{{ $latestTrgDoneEntry ? $latestTrgDoneEntry->trg_hrd_done : '0' }}</td>
                        <td contenteditable="false">{{ $latestTrgObjEntry ? $latestTrgObjEntry->trg_hrd_obj : '0' }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgHrdPerformance }}%</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['trg_hrd_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['trg_hrd_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgHrdGap_7 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['trg_hrd_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['trg_hrd_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgHrdGap_30 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['trg_hrd_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['trg_hrd_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $trgHrdGap_12 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['trg_hrd_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['trg_hrd_obj'], 0) }}</td>
                        <td style="font-weight:bold;" contenteditable="false">{{ $trgHrdGap_overall }}%</td>
                    </tr>
                </tbody>
            </table>
            <button wire:click="toggleFormTRG" class="capture-btn">Capture</button>
        </div>
        @else
        <div class="mt-8 bg-yellow-50 p-4 rounded-md">
            <h5 class="text-yellow-800">No KPI data available yet. Please submit your first entry.</h5>
        </div>
        <button wire:click="toggleFormTRG" class="capture-btn">Capture</button>
        @endif
    </div>

    <div class="kpi-section">
        <h6 class="section-title">CANDIDATES</h6>
        @if (session()->has('message'))
        <div class="d-flex justify-content-left">
            <div style="font-weight:bold;" class="alert alert-success alert-dismissible fade show " role="alert" id="successAlert">
                {{ session()->get('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        </div>
        @endif
        @if($latestCdtDoneEntry && $latestCdtObjEntry)
        <div class="table-container">
            @php

            $cdtCallsPerformance = 0;
            if ($latestCdtDoneEntry && $latestCdtObjEntry && $latestCdtObjEntry->cdt_calls_obj > 0) {
            $cdtCallsPerformance = round(($latestCdtDoneEntry->cdt_calls_done / $latestCdtObjEntry->cdt_calls_obj) * 100);
            }

            $cdtCtcPerformance = 0;
            if ($latestCdtDoneEntry && $latestCdtObjEntry && $latestCdtObjEntry->cdt_ctc_obj > 0) {
            $cdtCtcPerformance = round(($latestCdtDoneEntry->cdt_ctc_done / $latestCdtObjEntry->cdt_ctc_obj) * 100);
            }

            $cdtRefsPerformance = 0;
            if ($latestCdtDoneEntry && $latestCdtObjEntry && $latestCdtObjEntry->cdt_refs_obj > 0) {
            $cdtRefsPerformance = round(($latestCdtDoneEntry->cdt_refs_done / $latestCdtObjEntry->cdt_refs_obj) * 100);
            }

            $cdtCvPerformance = 0;
            if ($latestCdtDoneEntry && $latestCdtObjEntry && $latestCdtObjEntry->cdt_cv_obj > 0) {
            $cdtCvPerformance = round(($latestCdtDoneEntry->cdt_cv_done / $latestCdtObjEntry->cdt_cv_obj) * 100);
            }

            $cdtPushPerformance = 0;
            if ($latestCdtDoneEntry && $latestCdtObjEntry && $latestCdtObjEntry->cdt_push_obj > 0) {
            $cdtPushPerformance = round(($latestCdtDoneEntry->cdt_push_done / $latestCdtObjEntry->cdt_push_obj) * 100);
            }

            $cdtCrePerformance = 0;
            if ($latestCdtDoneEntry && $latestCdtObjEntry && $latestCdtObjEntry->cdt_cre_obj > 0) {
            $cdtCrePerformance = round(($latestCdtDoneEntry->cdt_cre_done / $latestCdtObjEntry->cdt_cre_obj) * 100);
            }

            // Last 7 days:
            $cdtCallsGap_7 = ($averages['7_days']['cdt_calls_obj'] > 0)
            ? round(($averages['7_days']['cdt_calls_done'] / $averages['7_days']['cdt_calls_obj']) * 100)
            : 0;

            $cdtCtcGap_7 = ($averages['7_days']['cdt_ctc_obj'] > 0)
            ? round(($averages['7_days']['cdt_ctc_done'] / $averages['7_days']['cdt_ctc_obj']) * 100)
            : 0;

            $cdtCreGap_7 = ($averages['7_days']['cdt_cre_obj'] > 0)
            ? round(($averages['7_days']['cdt_cre_done'] / $averages['7_days']['cdt_cre_obj']) * 100)
            : 0;

            $cdtRefsGap_7 = ($averages['7_days']['cdt_refs_obj'] > 0)
            ? round(($averages['7_days']['cdt_refs_done'] / $averages['7_days']['cdt_refs_obj']) * 100)
            : 0;

            $cdtCvGap_7 = ($averages['7_days']['cdt_cv_obj'] > 0)
            ? round(($averages['7_days']['cdt_cv_done'] / $averages['7_days']['cdt_cv_obj']) * 100)
            : 0;

            $cdtPushGap_7 = ($averages['7_days']['cdt_push_obj'] > 0)
            ? round(($averages['7_days']['cdt_push_done'] / $averages['7_days']['cdt_push_obj']) * 100)
            : 0;

            // Last 30 days:
            $cdtCallsGap_30 = ($averages['30_days']['cdt_calls_obj'] > 0)
            ? round(($averages['30_days']['cdt_calls_done'] / $averages['30_days']['cdt_calls_obj']) * 100)
            : 0;

            $cdtCtcGap_30 = ($averages['30_days']['cdt_ctc_obj'] > 0)
            ? round(($averages['30_days']['cdt_ctc_done'] / $averages['30_days']['cdt_ctc_obj']) * 100)
            : 0;

            $cdtCreGap_30 = ($averages['30_days']['cdt_cre_obj'] > 0)
            ? round(($averages['30_days']['cdt_cre_done'] / $averages['30_days']['cdt_cre_obj']) * 100)
            : 0;

            $cdtRefsGap_30 = ($averages['30_days']['cdt_refs_obj'] > 0)
            ? round(($averages['30_days']['cdt_refs_done'] / $averages['30_days']['cdt_refs_obj']) * 100)
            : 0;

            $cdtCvGap_30 = ($averages['30_days']['cdt_cv_obj'] > 0)
            ? round(($averages['30_days']['cdt_cv_done'] / $averages['30_days']['cdt_cv_obj']) * 100)
            : 0;

            $cdtPushGap_30 = ($averages['30_days']['cdt_push_obj'] > 0)
            ? round(($averages['30_days']['cdt_push_done'] / $averages['30_days']['cdt_push_obj']) * 100)
            : 0;

            // Last 12 months:
            $cdtCallsGap_12 = ($averages['12_months']['cdt_calls_obj'] > 0)
            ? round(($averages['12_months']['cdt_calls_done'] / $averages['12_months']['cdt_calls_obj']) * 100)
            : 0;

            $cdtCtcGap_12 = ($averages['12_months']['cdt_ctc_obj'] > 0)
            ? round(($averages['12_months']['cdt_ctc_done'] / $averages['12_months']['cdt_ctc_obj']) * 100)
            : 0;

            $cdtCreGap_12 = ($averages['12_months']['cdt_cre_obj'] > 0)
            ? round(($averages['12_months']['cdt_cre_done'] / $averages['12_months']['cdt_cre_obj']) * 100)
            : 0;

            $cdtRefsGap_12 = ($averages['12_months']['cdt_refs_obj'] > 0)
            ? round(($averages['12_months']['cdt_refs_done'] / $averages['12_months']['cdt_refs_obj']) * 100)
            : 0;

            $cdtCvGap_12 = ($averages['12_months']['cdt_cv_obj'] > 0)
            ? round(($averages['12_months']['cdt_cv_done'] / $averages['12_months']['cdt_cv_obj']) * 100)
            : 0;

            $cdtPushGap_12 = ($averages['12_months']['cdt_push_obj'] > 0)
            ? round(($averages['12_months']['cdt_push_done'] / $averages['12_months']['cdt_push_obj']) * 100)
            : 0;

            // Overall:
            $cdtCallsGap_overall = ($averages['overall']['cdt_calls_obj'] > 0)
            ? round(($averages['overall']['cdt_calls_done'] / $averages['overall']['cdt_calls_obj']) * 100)
            : 0;

            $cdtCtcGap_overall = ($averages['overall']['cdt_ctc_obj'] > 0)
            ? round(($averages['overall']['cdt_ctc_done'] / $averages['overall']['cdt_ctc_obj']) * 100)
            : 0;

            $cdtCreGap_overall = ($averages['overall']['cdt_cre_obj'] > 0)
            ? round(($averages['overall']['cdt_cre_done'] / $averages['overall']['cdt_cre_obj']) * 100)
            : 0;

            $cdtRefsGap_overall = ($averages['overall']['cdt_refs_obj'] > 0)
            ? round(($averages['overall']['cdt_refs_done'] / $averages['overall']['cdt_refs_obj']) * 100)
            : 0;

            $cdtCvGap_overall = ($averages['overall']['cdt_cv_obj'] > 0)
            ? round(($averages['overall']['cdt_cv_done'] / $averages['overall']['cdt_cv_obj']) * 100)
            : 0;

            $cdtPushGap_overall = ($averages['overall']['cdt_push_obj'] > 0)
            ? round(($averages['overall']['cdt_push_done'] / $averages['overall']['cdt_push_obj']) * 100)
            : 0;



            @endphp
            <table class="kpi-table">
                <thead>
                    <tr>
                        <th rowspan="2">N</th>
                        <th style="border-right:2px solid black;" colspan="3">Last day : <span>{{ $latestCdtObjEntry ? $latestCdtObjEntry->ctc_date : '0' }}</span></th>
                        <th style="border-right:2px solid black;" colspan="3">Last 7 days</th>
                        <th style="border-right:2px solid black;" colspan="3">Last 30 days</th>
                        <th style="border-right:2px solid black;" colspan="3">Last 12 months</th>
                        <th colspan="3">Overall</th>
                    </tr>
                    <tr>
                        <th>Done</th>
                        <th>Obj</th>
                        <th style="border-right:2px solid black;">Gap</th>
                        <th>Done</th>
                        <th>Obj</th>
                        <th style="border-right:2px solid black;">Gap</th>
                        <th>Done</th>
                        <th>Obj</th>
                        <th style="border-right:2px solid black;">Gap</th>
                        <th>Done</th>
                        <th>Obj</th>
                        <th style="border-right:2px solid black;">Gap</th>
                        <th>Done</th>
                        <th>Obj</th>
                        <th>Gap</th>
                    </tr>
                </thead>
                <tbody id="kpiTableBodyCDT">
                    <tr>
                        <td class="aspect">Calls</td>
                        <td contenteditable="false"> {{ $latestCdtDoneEntry ? $latestCdtDoneEntry->cdt_calls_done : '0' }}</td>
                        <td contenteditable="false"> {{ $latestCdtObjEntry ? $latestCdtObjEntry->cdt_calls_obj : '0' }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $cdtCallsPerformance }}%</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['cdt_calls_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['cdt_calls_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtCallsGap_7 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['cdt_calls_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['cdt_calls_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtCallsGap_30 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['cdt_calls_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['cdt_calls_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtCallsGap_12 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['cdt_calls_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['cdt_calls_obj'], 0) }}</td>
                        <td style="font-weight:bold;" contenteditable="false">{{ $cdtCallsGap_overall }}%</td>
                    </tr>
                    <tr>
                        <td class="aspect">CTC</td>
                        <td contenteditable="false"> {{ $latestCdtDoneEntry ? $latestCdtDoneEntry->cdt_ctc_done : '0' }}</td>
                        <td class="" contenteditable="false"> {{ $latestCdtObjEntry ? $latestCdtObjEntry->cdt_ctc_obj : '0' }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $cdtCtcPerformance }}%</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['cdt_ctc_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['cdt_ctc_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtCtcGap_7 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['cdt_ctc_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['cdt_ctc_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtCtcGap_30 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['cdt_ctc_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['cdt_ctc_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtCtcGap_12 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['cdt_ctc_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['cdt_ctc_obj'], 0) }}</td>
                        <td style="font-weight:bold;" contenteditable="false">{{ $cdtCtcGap_overall }}%</td>
                    </tr>
                    <tr>
                        <td class="aspect">CRE</td>
                        <td contenteditable="false"> {{ $latestCdtDoneEntry ? $latestCdtDoneEntry->cdt_cre_done : '0' }}</td>
                        <td class="" contenteditable="false"> {{ $latestCdtObjEntry ? $latestCdtObjEntry->cdt_cre_obj : '0' }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $cdtCrePerformance }}%</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['cdt_cre_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['cdt_cre_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtCreGap_7 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['cdt_cre_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['cdt_cre_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtCreGap_30 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['cdt_cre_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['cdt_cre_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtCreGap_12 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['cdt_cre_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['cdt_cre_obj'], 0) }}</td>
                        <td style="font-weight:bold;" contenteditable="false">{{ $cdtCreGap_overall }}%</td>
                    </tr>
                    <tr>
                        <td class="aspect">REFS</td>
                        <td contenteditable="false"> {{ $latestCdtDoneEntry ? $latestCdtDoneEntry->cdt_refs_done : '0' }}</td>
                        <td class="" contenteditable="false"> {{ $latestCdtObjEntry ? $latestCdtObjEntry->cdt_refs_obj : '0' }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $cdtRefsPerformance }}%</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['cdt_refs_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['cdt_refs_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtRefsGap_7 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['cdt_refs_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['cdt_refs_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtRefsGap_30 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['cdt_refs_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['cdt_refs_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtRefsGap_12 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['cdt_refs_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['cdt_refs_obj'], 0) }}</td>
                        <td style="font-weight:bold;" contenteditable="false">{{ $cdtRefsGap_overall }}%</td>
                    </tr>
                    <tr>
                        <td class="aspect">CV</td>
                        <td contenteditable="false">{{ $latestCdtDoneEntry ? $latestCdtDoneEntry->cdt_cv_done : '0' }}</td>
                        <td contenteditable="false"> {{ $latestCdtObjEntry ? $latestCdtObjEntry->cdt_cv_obj : '0' }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $cdtCvPerformance }}%</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['cdt_cv_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['cdt_cv_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtCvGap_7 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['cdt_cv_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['cdt_cv_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtCvGap_30 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['cdt_cv_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['cdt_cv_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtCvGap_12 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['cdt_cv_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['cdt_cv_obj'], 0) }}</td>
                        <td style="font-weight:bold;" contenteditable="false">{{ $cdtCvGap_overall }}%</td>
                    </tr>
                    <tr>
                        <td class="aspect">Push</td>
                        <td contenteditable="false"> {{ $latestCdtDoneEntry ? $latestCdtDoneEntry->cdt_push_done : '0' }}</td>
                        <td contenteditable="false"> {{ $latestCdtObjEntry ? $latestCdtObjEntry->cdt_push_obj : '0' }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{ $cdtPushPerformance }}%</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['cdt_push_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['7_days']['cdt_push_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtPushGap_7 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['cdt_push_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['30_days']['cdt_push_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtPushGap_30 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['cdt_push_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['12_months']['cdt_push_obj'], 0) }}</td>
                        <td style="font-weight:bold; border-right:2px solid black;" contenteditable="false">{{  $cdtPushGap_12 }}%</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['cdt_push_done'], 0) }}</td>
                        <td contenteditable="false">{{ number_format($averages['overall']['cdt_push_obj'], 0) }}</td>
                        <td style="font-weight:bold;" contenteditable="false">{{ $cdtPushGap_overall }}%</td>
                    </tr>
                </tbody>
            </table>
            <button wire:click="toggleForm" class="capture-btn">Capture</button>
        </div>
        @else
        <div class="mt-8 bg-yellow-50 p-4 rounded-md">
            <h5 class="text-yellow-800">No KPI data available yet. Please submit your first entry.</h5>
        </div>
        <button wire:click="toggleForm" class="capture-btn">Capture</button>
        @endif

    </div>


    @if($showFormTRG)
    <form wire:submit.prevent="save">
        <div id="trgModal" class="modal" style="display:block;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="date-section">
                        <label>Date:</label>
                        <input style="width:115px;" wire:model="trg_date" type="date" id="trgDate">
                    </div>
                </div>
                <h2 class="modal-title">TRG CAPTION REPORT</h2>
                <div class="modal-body">
                    <div class="metrics-grid" id="metricsForm">
                        <div class="column-labels">
                            <div class="label-data">Data</div>
                            <div class="label-obj">Obj</div>
                        </div>
                        <div class="metric-row">
                            <label>Calls :</label>
                            <div class="input-pair">
                                <input type="number" wire:model="trg_calls_done" name="calls_done" placeholder="">
                                <input type="number" wire:model="trg_calls_obj" name="calls_obj" placeholder="">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>WN :</label>
                            <div class="input-pair">
                                <input type="number" wire:model="trg_wn_done" name="wn_done" placeholder="">
                                <!-- <input type="number" name="wn_obj" placeholder=""> -->
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>NRP :</label>
                            <div class="input-pair">
                                <input type="number" wire:model="trg_nrp_done" name="nrp_done" placeholder="">
                                <!-- <input type="number" name="nrp_obj" placeholder=""> -->
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>CTC :</label>
                            <div class="input-pair">
                                <input type="number" wire:model="trg_ctc_done" name="ctc_done" placeholder="">
                                <input type="number" wire:model="trg_ctc_obj" name="ctc_obj" placeholder="">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>RV :</label>
                            <div class="input-pair">
                                <input type="number" wire:model="trg_rv_done" name="rv_done" placeholder="">
                                <input type="number" wire:model="trg_rv_obj" name="rv_obj" placeholder="">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>BQF :</label>
                            <div class="input-pair">
                                <input type="number" wire:model="trg_bqf_done" name="bqf_done" placeholder="">
                                <input type="number" wire:model="trg_bqf_obj" name="bqf_obj" placeholder="">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>KLF :</label>
                            <div class="input-pair">
                                <input type="number" wire:model="trg_klf_done" name="klf_done" placeholder="">
                                <input type="number" wire:model="trg_klf_obj" name="klf_obj" placeholder="">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>HRD :</label>
                            <div class="input-pair">
                                <input type="number" wire:model="trg_hrd_done" name="hrd_done" placeholder="">
                                <input type="number" wire:model="trg_hrd_obj" name="hrd_obj" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-buttons">
                        <button type="button" class="btn btn-erase" onclick="eraseModalData()">Clear All</button>
                        <button type="submit" class="btn btn-save">Capture</button>
                        <button type="button" class="btn btn-end" onclick="closeModal('trgModal')">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endif


    @if($showForm)
    <form wire:submit.prevent="save">
        <div id="cdtModal" class="modal" style="display: block;">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="date-section">
                        <label>Date :</label>
                        <input style="width:115px;" type="date" id="cdtDate" wire:model="ctc_date">
                    </div>
                    <!-- <div class="obj-section">
                    <label>Obj</label>
                    <input type="text" id="trgObj">
                </div> -->
                </div>
                <h2 class="modal-title">CDT CAPTION REPORT</h2>
                <div class="modal-body">
                    <div class="metrics-grid" id="metricsFormCDT">
                        <div class="column-labels">
                            <div class="label-data">Done</div>
                            <div class="label-obj">Obj</div>
                        </div>
                        <div class="metric-row">
                            <label>Calls :</label>
                            <div class="input-pair">
                                <input type="number" wire:model="cdt_calls_done" name="calls_done_cdt" placeholder="">
                                <input type="number" wire:model="cdt_calls_obj" name="calls_obj_cdt" placeholder="">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>CTC :</label>
                            <div class="input-pair">
                                <input type="number" wire:model="cdt_ctc_done" name="ctc_done_cdt" placeholder="">
                                <input type="number" wire:model="cdt_ctc_obj">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>CRE :</label>
                            <div class="input-pair">
                                <input type="number" wire:model="cdt_cre_done" name="ctc_done_cdt" placeholder="">
                                <input type="number" wire:model="cdt_cre_obj">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>REFS :</label>
                            <div class="input-pair">
                                <input type="number" wire:model="cdt_refs_done" name="refs_done_cdt" placeholder="">
                                <input type="number" wire:model="cdt_refs_obj">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>CV :</label>
                            <div class="input-pair">
                                <input type="number" wire:model="cdt_cv_done" name="cv_done_cdt" placeholder="">
                                <input type="number" wire:model="cdt_cv_obj" name="cv_obj_cdt" placeholder="">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>Push :</label>
                            <div class="input-pair">
                                <input type="number" wire:model="cdt_push_done" name="push_done_cdt" placeholder="">
                                <input type="number" wire:model="cdt_push_obj" name="push_obj_cdt" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-buttons">
                        <button type="button" class="btn btn-erase" onclick="eraseModalDataCDT()">Clear All</button>
                        <button type="submit" class="btn btn-save">Capture</button>
                        <button type="button" class="btn btn-end" onclick="closeModal('cdtModal')">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endif


    @if($showFormOBJ)
    <form wire:submit.prevent="save">
        <div id="objModal" class="modal" style="display:block;">
            <div class="modal-content">
                <h2 class="modal-titleObj">OBJECTIVES DEFINITION</h2>
                <hr>
                <div class="date-sectionObj">
                    <label>Last definition date :</label>
                    <input style="width:115px;" type="date" wire:model="trg_date">
                </div>
                <div class="obj-sectionObj">
                    <label>Last frequency :</label>
                    <input class="darkCDT" style="width:115px;" type="text" id="trgObj" readonly>
                </div>
                <div class="modal-body">
                    <div class="metrics-grid">
                        <div class="column-labelsObj">
                            <div class="label-dataObj">TRG</div>
                            <div class="label-objObj">CDT</div>
                        </div>
                        <div class="metric-row">
                            <label>Calls :</label>
                            <div class="input-pair">
                                <input class="objinput" wire:model="trg_calls_obj" type="number">
                                <label>Calls :</label>
                                <input class="objinput" wire:model="cdt_calls_obj" type="number">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>CTC :</label>
                            <div class="input-pair">
                                <input class="objinput" wire:model="trg_ctc_obj" type="number">
                                <label>CTC :</label>
                                <input class="objinput" wire:model="cdt_ctc_obj" type="number">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>RV :</label>
                            <div class="input-pair">
                                <input class="objinput" wire:model="trg_rv_obj" type="number">
                                <label>CRE :</label>
                                <input class="objinput" wire:model="cdt_cre_obj" type="number">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>BQF :</label>
                            <div class="input-pair">
                                <input class="objinput" wire:model="trg_bqf_obj" type="number">
                                <label>REFS :</label>
                                <input class="objinput" wire:model="cdt_refs_obj" type="number">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>KLF :</label>
                            <div class="input-pair">
                                <input class="objinput" wire:model="trg_klf_obj" type="number">
                                <label>CV :</label>
                                <input class="objinput" wire:model="cdt_cv_obj" type="number">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>HRD :</label>
                            <div class="input-pair">
                                <input class="objinput" wire:model="trg_hrd_obj" type="number">
                                <label>Push :</label>
                                <input class="objinput" wire:model="cdt_push_obj" type="text">
                            </div>
                        </div>
                        <!-- <div class="metric-row">
                            <label>KLF :</label>
                            <div class="input-pair">
                                <input wire:model="trg_klf_obj" type="number">
                            </div>
                        </div>
                        <div class="metric-row">
                            <label>HRD :</label>
                            <div class="input-pair">
                                <input wire:model="trg_hrd_obj" type="number">
                            </div>
                        </div> -->
                    </div>
                    <div class="modal-buttons">
                        <button type="button" class="btn btn-erase" onclick="eraseModalDataOBJ()">Clear All</button>
                        <button type="submit" class="btn btn-save">Capture</button>
                        <button type="button" class="btn btn-end" onclick="closeModal('objModal')">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endif


    <script>
        // setTimeout(function() {
        //     var successAlert = document.getElementById('successAlert');
        //     if (successAlert) {
        //         successAlert.style.display = 'none';
        //     }
        // }, 3000);

        const todaysDate = new Date().toLocaleDateString();
        document.getElementById("date").innerText = todaysDate;
        document.getElementById("dateTRG").innerText = todaysDate;
        document.getElementById("dateCDT").innerText = todaysDate;

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = "block";

            const dateInput = modal.querySelector('input[id$="Date"]');
            if (dateInput) {
                dateInput.value = new Date().toLocaleDateString('en-GB');
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = "none";
        }

        function eraseModalData() {
            const modal = document.getElementById('trgModal');
            const modalcdt = document.getElementById('cdtModal');
            const inputs = modal.querySelectorAll('input, textarea');
            const inputscdt = modal.querySelectorAll('input, textarea');

            inputs.forEach(input => {
                input.value = '';
            });

            inputscdt.forEach(input => {
                input.value = '';
            });
        }

        function eraseModalDataCDT() {
            const modal = document.getElementById('cdtModal');
            const inputs = modal.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.value = '';
            });
        }


        function eraseModalDataOBJ() {
            const modal = document.getElementById('objModal');
            const inputs = modal.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.value = '';
            });
        }
    </script>


    <style>
        .headDate {
            color: #010066;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .objinput {
            margin-top: 8px;
        }

        .tableHead {
            text-align: center;
            margin-bottom: 15px;
        }

        .objectives {
            margin-left: 10px;
            cursor: pointer;
        }

        .dark {
            /* background-color: #f5f5f5; */
            background-color: #D8D9DA;
        }

        .darkCDT {
            background-color: #D1F8EF;
        }

        .kpi-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        label {
            font-size: 1rem;
            margin-top: 8px;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .table-container {
            overflow-x: auto;
        }

        .kpi-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .kpi-table th,
        .kpi-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        .kpi-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .aspect {
            background-color: #f5f5f5;
        }

        .kpi-table td[contenteditable="false"] {
            /* background-color: #fff; */
            cursor: text;
            min-width: 60px;
        }

        .kpi-table td[contenteditable="false"]:focus {
            outline: 2px solid #4299e1;
            outline-offset: -2px;
        }

        .capture-btn {
            position: absolute;
            bottom: 8px;
            right: 20px;
            background-color: green;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 2px;
            cursor: pointer;
        }


        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            background-color: #e6e6e6;
            margin: 5% auto;
            padding: 5px;
            width: 400px;
            position: relative;
            border: 1px solid #999;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .date-section,
        .obj-section {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .date-section input,
        .obj-section input {
            width: 100px;
            height: 25px;
            border: 1px solid #999;
        }

        .date-sectionObj {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-left: 25px;
        }

        .obj-sectionObj {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-left: 25px;
        }

        .date-sectionObj input {
            width: 100px;
            height: 25px;
            margin-left: 30px;
            border: 1px solid #999;
        }

        .obj-sectionObj input {
            width: 100px;
            height: 25px;
            margin-left: 61px;
            border: 1px solid #999;
        }

        .modal-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            /* margin: 15px 0; */
        }

        .modal-titleObj {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
            /* margin: 15px 0; */
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
        }

        .btn {
            padding: 6px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-save {
            background-color: #48bb78;
            color: white;
        }

        .btn-save:hover {
            background-color: #48bb78;
            color: white;
        }

        .btn-erase {
            background-color: #f56565;
            color: white;
        }

        .btn-erase:hover {
            background-color: #f56565;
            color: white;
        }

        .btn-end {
            background-color: #4299e1;
            color: white;
        }

        .btn-end:hover {
            background-color: #4299e1;
            color: white;
        }

        .metric-row {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .metric-row label {
            width: 50px;
            text-align: right;
            margin-right: 10px;
        }

        .input-pair {
            display: flex;
            gap: 10px;
        }

        .input-pair input {
            width: 80px;
            height: 25px;
            border: 1px solid #999;
        }

        .notes-section {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .notes-section label {
            margin-bottom: 5px;
        }

        .notes-section textarea {
            width: 100%;
            height: 60px;
            border: 1px solid #999;
            resize: none;
        }

        input,
        textarea {
            background-color: white;
            padding: 4px;
        }

        input:focus,
        textarea:focus {
            outline: 1px solid #666;
        }

        label {
            font-weight: normal;
            color: #000;
        }

        .column-labels {
            display: flex;
            margin-bottom: 5px;
            padding-left: 60px;
        }

        .label-data,
        .label-obj {
            width: 80px;
            text-align: center;
            font-weight: 500;
            font-size: 1rem;
        }

        .column-labelsObj {
            display: flex;
            margin-bottom: 5px;
            padding-left: 60px;
        }

        .label-dataObj,
        .label-objObj {
            width: 80px;
            text-align: center;
            font-weight: 500;
            font-size: 1rem;
        }

        .label-objObj {
            margin-left: 80px;
        }

        .column-labels {
            display: flex;
            gap: 10px;

        }

        .metric-row {
            display: flex;
            align-items: center;
            margin-bottom: 1px;
        }

        .metric-row label {
            width: 50px;
            text-align: right;
            margin-right: 10px;
        }

        .input-pair {
            display: flex;
            gap: 10px;
        }

        .input-pair input {
            width: 80px;
            height: 25px;
            border: 1px solid #999;
        }
    </style>

</div>
