<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 ms-5 ps-3">{{ $title }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    @isset($breadcrumbItems)
                        @foreach ($breadcrumbItems as $breadcrumb)
                            <li class="breadcrumb-item {{ Request::is($breadcrumb['url']) ? 'active' : '' }}">
                                @if (!empty($breadcrumb['url']))
                                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['text'] }}</a>
                                @else
                                    {{ $breadcrumb['text'] }}
                                @endif
                            </li>
                        @endforeach
                    @endisset

                </ol>
            </div>

        </div>
    </div>
</div>
