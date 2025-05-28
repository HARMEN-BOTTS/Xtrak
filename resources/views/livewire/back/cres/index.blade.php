<div>

    <!-- end page title -->
    <div class="d-flex">
        <div class="p-2 flex-grow-1">

        </div>

        <div class="p-2">
            @if ($candidate->cres()->exists())
                <a type="button" href="#"  wire:click.prevent="goToCre('{{ $candidate->id }}')"
                    class="btn btn-success">
                    Détail
                </a>
                <a type="button" href="{{ route('add.cre', ['candidate' => $candidate, 'action' => 'update']) }}"
                    class="btn btn-info ms-2">
                    <i class="ri-add-line align-bottom me-1"></i> Modifier
                </a>
                <a type="button" href="#" wire:click.prevent="confirmDelete('{{ $candidate->id }}')" class="btn btn-danger ms-2">
    <i class="ri-delete-bin-line align-bottom me-1"></i> Supprimer
</a>

            @else
                <a type="button" href="{{ route('add.cre', ['candidate' => $candidate, 'action' => 'create']) }}"
                    class="btn btn-primary">
                    <i class="ri-add-line align-bottom me-1"></i> Nouveau
                </a>
            @endif
        </div>
    </div>
         @livewire('back.cres.show-pdf', ['candidate' => $candidate])
    <!-- end row -->
    <div class="row g-0 text-center text-sm-start align-items-center mb-4">
        <!-- end col -->
        {{ $cres->links() }}
    </div><!-- end row -->
</div>


