<div>
    @include('components.breadcrumb', [
    'title' => auth()->user()->hasRole('Manager') ? '' : '',
    'breadcrumbItems' => [['text' => 'ADM', 'url' => ''] ,['text' => 'Landing', 'url' => '/landing'] ,['text' => 'Views', 'url' => ''] ,['text' => 'MCPvue', 'url' => '/mcpdashboard'] , ['text' => 'MCP_EVTlist', 'url' => '/mcpevtlist']],
    ])


    <div class="container-fluid">
        <div class="row">

            <div style="margin-top: -1%;margin-left:-10px;" class="p-2 mb-4 d-flex justify-content-between">
                <div>
                </div>
                <div>
                    <a href="{{ route('trgdashboard') }}" class="me-2 text-black {{ request()->routeIs('trgdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">TRG</a> -
                    <a href="{{ route('dashboard') }}" class="mx-2 text-black {{ request()->routeIs('dashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">CDT</a> -
                    <a href="{{ route('oppdashboard') }}" class="mx-2 text-black  {{ request()->routeIs('oppdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">OPP</a> -
                    <a href="{{ route('mcpdashboard') }}" class="mx-2 text-black  {{ request()->routeIs('mcpdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">MCP</a> -
                    <a href="{{ route('ctcdashboard') }}" class="mx-2 text-black {{ request()->routeIs('ctcdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">CTC</a> -
                    <a href="{{ route('dashboard') }}" class="mx-2 text-black  {{ request()->routeIs('dashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">ANN</a> -
                    <a href="{{ route('cstdashboard') }}" class="ms-2 text-black {{ request()->routeIs('cstdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">CST</a>
                </div>
            </div>

            <div class="col-12">
                <div class="card">

                    <div class="card-header-modern">
                        <div class="header-content">
                            <div class="title-section">
                                <h4 class="report-title">MCM Report Code : {{ $mcpCode }}</h4>
                                <div class="campaign-info">
                                    <span class="campaign-subject">Campaign Subject : {{ $campaignInfo->subject?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="stats-section">
                                <div class="stat-item total">
                                    <span class="stat-value">{{ $emailLogs->total() }}</span>
                                    <span class="stat-label">Total</span>
                                </div>
                                <div class="stat-item success">
                                    <span class="stat-value">{{ $emailLogs->where('status', 'Success')->count() }}</span>
                                    <span class="stat-label">Success</span>
                                </div>
                                <div class="stat-item failed">
                                    <span class="stat-value">{{ $emailLogs->where('status', 'Failed')->count() }}</span>
                                    <span class="stat-label">Failed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover align-middle">
                                <!-- Your table header remains the same -->
                                <thead class="text-white sticky-top">
                                    <tr>
                                        <th class="col-index" style="background-color: #7D0A0A; cursor: pointer;">#</th>
                                        <th class="col-date" style="background-color: #7D0A0A; cursor: pointer;">Launch Date</th>
                                        <th class="col-hour" style="background-color: #7D0A0A; cursor: pointer;">Hour</th>
                                        <th class="col-pause" style="background-color: #7D0A0A; cursor: pointer;">Pause</th>
                                        <th class="col-status" style="background-color: #7D0A0A; cursor: pointer;">Status</th>
                                        <th class="col-designation" style="background-color: #7D0A0A; cursor: pointer;">Designation</th>
                                        <th class="col-target" style="background-color: #7D0A0A; cursor: pointer;">Target Status</th>
                                        <th class="col-email" style="background-color: #7D0A0A; cursor: pointer;">Recipient Email</th>
                                        <th class="col-name" style="background-color: #7D0A0A; cursor: pointer;">Recipient Name</th>
                                        <th class="col-company" style="background-color: #7D0A0A; cursor: pointer;">Company</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($emailLogs as $index => $log)
                                    <tr>
                                        <td>{{ $emailLogs->firstItem() + $index }}</td>
                                        <td>{{ $log->launch_date }}</td>
                                        <td>{{ $log->hour }}</td>
                                        <td>{{ $log->pause }}</td>
                                        <td>
                                            <span class="status-badge {{ $log->status === 'Success' ? 'success' : 'danger' }}">
                                                {{ $log->status }}
                                            </span>
                                        </td>
                                        <td>{{ $log->designation }}</td>
                                        <td>{{ $campaignInfo->target_status }}</td>
                                        <td>{{ $log->recipient_email }}</td>
                                        <td>{{ $log->recipient_name }}</td>
                                        <td>{{ $log->company }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No email logs found for MCP Code: {{ $mcpCode }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $emailLogs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: none;
            overflow: hidden;
        }

        /* Compact Header */
        .card-header-modern {
            background: linear-gradient(135deg, #7D0A0A 0%, #a01414 100%);
            color: white;
            padding: 20px 24px;
            border: none;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .title-section {
            flex: 1;
            min-width: 300px;
        }

        .report-title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            color: white;
        }

        .campaign-info {
            margin-top: 4px;
        }

        .campaign-subject {
            font-size: 0.9rem;
            opacity: 0.9;
            font-weight: 400;
        }

        .stats-section {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 16px;
            /* background: rgba(255, 255, 255, 0.1); */
            background: white;
            border-radius: 8px;
            min-width: 70px;
        }

        .stat-value {
            font-size: 1.4rem;
            font-weight: 700;
            line-height: 1;
            color: black;
        }

        .stat-label {
            font-size: 0.75rem;
            opacity: 0.9;
            margin-top: 2px;
            color: black;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-item.success .stat-value {
            color: #10b981;
        }

        .stat-item.failed .stat-value {
            color: #ef4444;
        }


        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .report-table th {
            background-color: #7D0A0A;
            color: white;
            padding: 8px;
            text-align: left;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .report-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .report-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .report-table tr:hover {
            background-color: #ddd;
        }

        /* Status Badge */
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .status-badge.danger {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        @media print {
            .no-print {
                display: none;
            }

            .report-table {
                width: 100%;
            }
        }

        /* Table Container */
        .table-responsive {
            overflow-x: auto;
            min-height: 400px;
        }

        .table {
            min-width: 1200px;
            /* Ensure minimum table width */
            table-layout: fixed;
            /* Use fixed layout for consistent column widths */
        }

        /* Optimized Column Widths */
        .col-index {
            width: 40px;
            min-width: 60px;
            text-align: center;
        }

        .col-date {
            width: 110px;
            min-width: 120px;
        }

        .col-hour {
            width: 80px;
            min-width: 80px;
            text-align: center;
        }

        .col-pause {
            width: 60px;
            min-width: 80px;
            text-align: center;
        }

        .col-status {
            width: 100px;
            min-width: 100px;
            text-align: center;
        }

        .col-designation {
            width: 130px;
            min-width: 150px;
        }

        .col-target {
            width: 110px;
            min-width: 120px;
        }

        .col-email {
            width: 230px;
            min-width: 280px;
            word-break: break-all;
            /* Break long emails if needed */
        }

        .col-name {
            width: 200px;
            min-width: 200px;
        }

        .col-company {
            width: 230px;
            min-width: 200px;
        }

        /* Table cell styling for better text handling */
        .table td,
        .table th {
            padding: 12px 8px;
            vertical-align: middle;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Allow text wrapping for email and company columns */
        .col-email,
        .col-company,
        .col-name {
            white-space: normal;
            word-wrap: break-word;
        }

        /* Hover effect to show full content */
        .table td:hover {
            white-space: normal;
            overflow: visible;
            position: relative;
            z-index: 5;
            background-color: #f8f9fa;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Responsive adjustments */
        @media screen and (max-width: 1400px) {
            .col-email {
                width: 250px;
                min-width: 250px;
            }

            .col-company,
            .col-name {
                width: 180px;
                min-width: 180px;
            }
        }

        @media screen and (max-width: 1200px) {
            .table {
                min-width: 1000px;
            }

            .col-email {
                width: 220px;
                min-width: 220px;
            }

            .col-company,
            .col-name {
                width: 160px;
                min-width: 160px;
            }

            .col-designation {
                width: 130px;
                min-width: 130px;
            }
        }

        /* Print styles */
        @media print {
            .table {
                min-width: 100%;
                font-size: 0.8rem;
            }

            .table td,
            .table th {
                padding: 6px 4px;
                font-size: 0.75rem;
            }

            .col-email {
                width: 25%;
            }

            .col-company,
            .col-name {
                width: 18%;
            }
        }
    </style>
</div>

