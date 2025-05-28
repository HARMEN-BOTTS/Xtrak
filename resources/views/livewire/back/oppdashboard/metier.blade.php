<div>
    <!-- start page title -->
    @include('components.breadcrumb', [
        'title' => 'Paramètres métiers',
        'breadcrumbItems' => [['text' => 'métiers', 'url' => '#']],
    ])

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Paramètres métiers</h4>

        </div>
        <div class="card-hearder">
            <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active fw-bold " data-bs-toggle="tab" href="#positions" role="tab">
                        POSTES
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" data-bs-toggle="tab" href="#specialities" role="tab">
                        SPÉCIALITÉS
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" data-bs-toggle="tab" href="#fields" role="tab">
                        DOMAINES
                    </a>
                </li>

            </ul>

        </div>
    </div>

    <div class="tab-content text-muted">
        <div class="tab-pane fade show active" id="positions" role="tabpanel">
            <div class="row">
                <div class="col-sm-12">
                    @livewire('back.positions.index')
                    <!-- end card -->
                </div>
                <!-- ene col -->

                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end tab pane -->
        <div class="tab-pane fade" id="specialities" role="tabpanel">
            <div class="col-sm-12">

                @livewire('back.specialities.index')
                <!-- end card -->
            </div>
        </div>
        <!-- end tab pane -->
        <div class="tab-pane fade" id="fields" role="tabpanel">
            <div class="col-sm-12">
                @livewire('back.fields.index')
                <!-- end card -->
            </div>
            <!--end card-->
        </div>
        <!-- end tab pane -->

        <!-- end tab pane -->
    </div>
</div>
