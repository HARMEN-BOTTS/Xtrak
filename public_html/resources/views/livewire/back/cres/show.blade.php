<div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <!-- start page title -->
    @include('components.breadcrumb', [
        'title' => 'Détails du CRE',
        'breadcrumbItems' => [['text' => 'Détail du CRE', 'url' => '#']],
    ])
    <div class="d-flex" style="display: flex;">
        <div class="p-2 flex-grow-1" style="padding: 0.5rem; flex-grow: 1;">
            <div class="hstack gap-2 justify-content-center d-print-none" style="display: flex; gap: 0.5rem; justify-content: center;">
                <a href="javascript:window.print()" class="btn btn-success" style="background-color: #28a745; color: white;"><i
                        class="ri-printer-line align-bottom me-1"></i> Imprimer</a>
                <button onclick="downloadPDF()" class="btn btn-primary position-relative" style="position: relative; background-color: #007bff; color: white;">
                    <i class="ri-download-2-line align-bottom me-1"></i>
                    <span class="download-text">Télécharger</span>
                </button>
                <a href="#" onclick="goBack()" class="btn btn-secondary me-1 ms-5" style="margin-left: 1.25rem; background-color: #6c757d; color: white;"><i
                        class="mdi mdi-arrow-left me-1"></i>Retour</a>
            </div>
        </div>
    </div>
    <div class="row justify-content-center" style="display: flex; justify-content: center;">
        <div class="col-xxl-9" style="max-width: 100%; flex: 0 0 auto;">
            <div class="card" id="demo" style="border: 1px solid #dee2e6; border-radius: 0.25rem; width: 100%;">
                <div class="row" style="display: flex;">
                    <div class="col-lg-12" style="flex: 0 0 auto; width: 100%;">
                        <div class="card-header border-bottom-dashed p-4" style="border-bottom: 1px dashed #dee2e6; padding: 1.5rem;">
                            <div class="d-flex" style="display: flex;">
                                <div class="p-2 flex-fill" style="padding: 0.5rem; flex: 1 1 auto;">
                                    <img src="{{ asset('assets/images/logo.jpg') }}" alt="" class="img-fluid" height="200" width="200" style="max-width: 100%; height: auto;">
                                </div>
                                <div class="p-2 flex-fill mt-4" style="padding: 0.5rem; flex: 1 1 auto; margin-top: 1.5rem;">
                                    <span class="fw-bold" style="font-weight: bold;">CONFIDENTIEL</span>
                                </div>
                                <div class="p-2 flex-fill" style="padding: 0.5rem; flex: 1 1 auto;">
                                    <h6><span class="fw-bold" style="font-weight: bold;">Réf: </span><span class="badge bg-light-subtle text-body text-wrap" style="background-color: #f8f9fa; color: #212529; display: inline-block; white-space: normal;" id="legal-register-no">{{ $candidate->cre_ref ?? '---' }}</span></h6>
                                    <h6><span class="fw-bold" style="font-weight: bold;">Auteur: </span><span class="badge bg-light-subtle text-body text-wrap" style="background-color: #f8f9fa; color: #212529; display: inline-block; white-space: normal;">{{ $candidate->auteur->trigramme ?? '' }}</span></h6>
                                    <h6><span class="fw-bold" style="font-weight: bold;">Date: </span><span class="badge bg-light-subtle text-body text-wrap" style="background-color: #f8f9fa; color: #212529; display: inline-block; white-space: normal;">{{ $candidate->cre_created_at ? \Carbon\Carbon::parse($candidate->cre_created_at)->format('d-m-Y') : '--' }}</span></h6>
                                </div>
                            </div>
                            <div class="mt-4 ms-1" style="margin-top: 1.5rem; margin-left: 0.25rem;">
                                <div>
                                    <p class="fw-bold" style="font-weight: bold;">COMPTE RENDU D'ENTRETIEN DE {{ $candidate->civ->name ?? '---' }}. <span class="badge bg-light-subtle text-body text-wrap fs-15" style="background-color: #f8f9fa; color: #212529; display: inline-block; white-space: normal; font-size: 1.875rem;">{{ $candidate->first_name ?? '---' }} {{ $candidate->last_name ?? '---' }}</span></p>
                                </div>
                                <div class="d-flex justify-content-start mt-2" style="display: flex; justify-content: flex-start; margin-top: 0.5rem;">
                                    <p class="fw-bold" style="font-weight: bold;">POSTE : <span class="badge bg-light-subtle text-body text-wrap fs-15" style="background-color: #f8f9fa; color: #212529; display: inline-block; white-space: normal; font-size: 1.875rem;">{{ $candidate->position->name ?? '---' }}</span></p>
                                </div>
                            </div>
                        </div>
                        <!--end card-header-->
                    </div><!--end col-->

                    <div class="col-lg-12" style="flex: 0 0 auto; width: 100%;">
                        <div class="card-body p-4" style="padding: 1.5rem;">
                            <ol>
                                @forelse ($cres as $cre)
                                    <li>
                                        <p class="fw-bold" style="font-weight: bold;">{{ $cre->question }} :</p>
                                        <p class="text-start badge bg-light-subtle text-body fs-6 text-wrap" style="text-align: left; background-color: #f8f9fa; color: #212529; display: inline-block; white-space: normal; font-size: 1rem;">{{ $cre->response }}</p>
                                    </li>

                                @empty
                                    <div class="alert alert-warning" role="alert" style="color: #856404; background-color: #fff3cd; border-color: #ffeeba; padding: 1rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.25rem;">Aucun compte rendu d'entretien n'est disponible pour le moment.</div>
                                @endforelse
                            </ol>
                        </div>
                        <!--end card-body-->
                    </div><!--end col-->
                    <div class="hstack gap-2 justify-content-center mt-2" style="display: flex; gap: 0.5rem; justify-content: center; margin-top: 0.5rem;">
                        <span>-----+-----+-----+-----</span>
                    </div>
                </div><!--end row-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
    <script>
    function downloadPDF() {
        const element = document.getElementById('demo');
        const opt = {
            margin: 0.5,
            filename: 'CRE_{{ $candidate->first_name }}_{{ $candidate->last_name }}.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        // Calculate the height of the element
        const elementHeight = element.scrollHeight;
        const pageHeight = 841.89; // A4 height in points (1 inch = 72 points, A4 height = 11.69 inches)

                // If the element height is greater than the page height, set the scale to fit it on one page
                if (elementHeight > pageHeight) {
            opt.jsPDF.scale = pageHeight / elementHeight;
        }

        html2pdf().from(element).set(opt).save();
    }
    </script>

</div>

