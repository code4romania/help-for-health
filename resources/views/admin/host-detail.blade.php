@extends('layouts.admin')

@section('content')
    <section class="mb-5">
        <h6 class="page-title font-weight-600 mb-3">@if ($user->name) {{ $user->name }} @else - @endif</h6>
    </section>

    <div class="card shadow">
        <div class="card-header bg-admin-blue py-3 d-flex justify-content-between align-content-center">
            <h6 class="font-weight-600 text-white mb-0">
                {{ __("Personal information") }}
            </h6>

            <div>
                <a href="#" class="btn btn-sm btn-danger px-4 delete-host" data-id="{{ $user->id }}">{{ __('Delete') }}</a>
                <a class="btn btn-secondary btn-sm px-4" href="{{ route('admin.host-edit', ['id' => $user->id]) }}">{{ __("Profile edit") }}</a>
            </div>
        </div>
        <div class="card-body pt-4">
            <div class="kv d-flex">
                <b class="mr-3">
                    {{ __("Full Name") }}:
                </b>
                <p>
                    @if ($user->name) {{ $user->name }} @else - @endif
                </p>
            </div>
            <div class="kv d-flex">
                <b class="mr-3">
                    {{ __("Country") }}:
                </b>
                <p>
                    @if ($user->country) {{ $user->country->name }} @else - @endif
                </p>
            </div>
            <div class="kv d-flex">
                <b class="mr-3">
                    {{ __("City") }}:
                </b>
                <p>
                    @if ($user->city) {{ $user->city }} @else - @endif
                </p>
            </div>
            <div class="kv d-flex">
                <b class="mr-3">
                    {{ __("Address") }}:
                </b>
                <p>
                    @if ($user->address) {{ $user->address }} @else - @endif
                </p>
            </div>
            <div class="kv d-flex">
                <b class="mr-3">
                    {{ __("Phone Number") }}:
                </b>
                <p>
                    @if ($user->phone_number) {{ $user->phone_number }} @else - @endif
                </p>
            </div>
            <div class="kv d-flex">
                <b class="mr-3">
                    {{ __("E-Mail Address") }}:
                </b>
                <p>
                    {{ $user->email }}
                </p>
            </div>
        </div>
    </div>

    @if (!$user->approved_at)
    <div class="alert alert-secondary d-flex justify-content-between align-items-center">
        <h6 class="mb-0 font-weight-600 text-white">
            {{ __("Validate host and reset password") }}
        </h6>
        <a class="btn btn-white text-secondary px-4 ml-3" id="validateAccount" href="{{ route('admin.host-activate-and-reset', ['id' => $user->id]) }}">{{ __("Send") }}</a>
    </div>
    @else
        <div class="alert alert-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0 font-weight-600 text-dark">
                {{ __("Reset password in case you forgot it") }}
            </h6>
            <a class="btn btn-secondary px-4 ml-3" id="resetAccount" href="{{ route('admin.host-reset', ['id' => $user->id]) }}">{{ __("Send") }}</a>
        </div>
    @endif



    <div class="card shadow">
        <div class="card-header bg-admin-blue py-3 d-flex justify-content-between align-content-center rounded">
            <h6 class="font-weight-600 text-white mb-0">
                {{ trans_choice('Accommodation places', $accommodations->total(), ['value' => $accommodations->total()]) }}
            </h6>
            <a class="btn btn-secondary btn-sm px-4" href="{{ route('admin.accommodation-add', ['userId' => $user->id]) }}">{{ __('Add accommodation') }}</a>
        </div>
    </div>

    <div class="alert bg-white text-dark d-flex align-items-center shadow-sm mb-4">
        <span class="alert-inner--icon mr-3"><i class="fa fa-info-circle"></i></span>
        <span class="alert-inner--text font-weight-600">{{ __('You can add one or more accommodation to offer to people who need help!') }}</span>
    </div>

    <div class="card-deck accomodation-list row rows-2">
        @foreach($accommodations->items() as $accommodation)
            <div class="col-12 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="media">
                            @if (!empty($accommodation->photos()->count()))
                                <img src="{{ $accommodation->photos()->first()->getPhotoUrl() }}" alt="" class="w-50 mr-4">
                            @endif
                            <div class="media-body">
                                <h6 class="text-primary font-weight-600 mb-1">
                                    <a href="{{ route('admin.accommodation-detail', $accommodation->id) }}" class="text-underline">{{ __($accommodation->accommodationtype->name) }}</a>
                                </h6>
                                <p>{{ $accommodation->address_city }}, {{ $accommodation->addresscountry->name }}</p>
                                <p>{{ trans_choice('Maximum accommodated rooms', $accommodation->available_rooms, ['value' => $accommodation->available_rooms]) }}</p>

                                @if (!empty($accommodation->unavailable_from_date) && !empty($accommodation->unavailable_to_date))
                                    <div class="kv mb-2">
                                        <p>{{ __('Unavailability') }}</p>
                                        <p>{{ formatDate($accommodation->unavailable_from_date) }} - {{ formatDate($accommodation->unavailable_to_date) }}</p>
                                    </div>
                                @endif
                                <div class="kv d-flex mb-0">
                                    <p class="mr-3">{{ __('Maximum') }}</p>
                                    <p class="text-admin-blue">{{ trans_choice('Maximum accommodated persons', $accommodation->max_guests, ['value' => $accommodation->max_guests]) }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.accommodation-detail', $accommodation->id) }}" class="btn btn-sm btn-secondary mb-2 mb-sm-0">{{ __('See details') }}</a>
                        <a href="{{ route('admin.accommodation-edit', $accommodation->id) }}" class="btn btn-sm btn-outline-primary mb-2 mb-sm-0">{{ __('Edit') }}</a>
                        <a href="#" class="btn btn-sm btn-outline-danger mb-2 mb-sm-0 delete-accommodation" data-id="{{ $accommodation->id }}">{{ __('Delete') }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        <nav aria-label="...">
            <ul class="pagination justify-content-center mb-0"></ul>
        </nav>
    </div>

    <!-- Confirmare stergere gazda -->
    <div class="modal fade bd-example-modal-sm" id="deleteHostModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Delete host') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to delete this host?') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link text-dark" data-dismiss="modal" id="cancel">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-secondary" id="proceedDeleteHost">{{ __('Yes') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmare stergere cazare -->
    <div class="modal fade bd-example-modal-sm" id="deleteAccommodationModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">{{ __('Delete accommodation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to delete this accommodation') }}?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link text-dark" data-dismiss="modal" id="cancel">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-secondary" id="proceedDeleteAccommodation">{{ __('Yes') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmare activare si resetare parola host -->
    <div class="modal fade bd-example-modal-sm" id="activateHostAndResetPassword" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __("Activate host") }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __("Validate host and reset password") }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link text-dark" data-dismiss="modal" id="cancel">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="proceedActivateHostAndResetPassword">{{ __('Yes') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmare activare si resetare parola host -->
    <div class="modal fade bd-example-modal-sm" id="resetPassword" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __("Reset host password") }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __("Reset password in case you forgot it") }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link text-dark" data-dismiss="modal" id="cancel">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="proceedResetPassword">{{ __('Yes') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let selectedHost = null;

        $('.delete-host').on('click', function(event) {
            event.preventDefault();
            selectedHost = $(this).data('id');
            $('#deleteHostModal').modal('show');
        });

        $('#proceedDeleteHost').on('click', function() {
            $('#deleteHostModal').modal('hide');
            window.location.href = '/admin/host/'+selectedHost+'/delete';
        });
        class AccommodationRenderer {
            renderPagination(response) {
                $('.pagination li').remove();

                if (1 === response.last_page) {
                    return;
                }

                let morePages = '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';

                let currentPage = '<li class="page-item active"><a class="page-link" data-page="' + response.current_page + '" href="{{ route('host.accommodation') }}/'+response.current_page+'">' + response.current_page + ' <span class="sr-only">(current)</span></a></li>';

                let firstPage = '';
                if (response.current_page > 1) {
                    firstPage = '<li class="page-item"><a class="page-link" data-page="1" href="{{ route('host.accommodation') }}/1">1</a></li>';
                }

                let step = response.current_page
                let counter = 0;

                let previousPages = '';
                while(step > 2 && 2 > counter) {
                    counter++;
                    step--;
                    previousPages = '<li class="page-item"><a class="page-link" data-page="' + step + '" href="{{ route('host.accommodation') }}/'+ step +'">' + step + '</a></li>' + previousPages;
                }

                if (response.current_page > 4) {
                    previousPages = morePages + previousPages;
                }

                step = response.current_page;
                counter = 0;

                let nextPages = '';
                while(step < response.last_page - 1 && 2 > counter) {
                    counter++;
                    step++;
                    nextPages += '<li class="page-item"><a class="page-link" data-page="' + step + '" href="{{ route('host.accommodation') }}/'+ step +'">' + step + '</a></li>';
                }

                if ((response.last_page - response.current_page) > 3) {
                    nextPages += morePages;
                }

                let lastPage = '';
                if (response.current_page < response.last_page) {
                    lastPage = '<li class="page-item"><a class="page-link" data-page="' + response.last_page + '" href="{{ route('host.accommodation') }}/'+response.last_page+'">' + response.last_page + '</a></li>';
                }

                $('.pagination').append(firstPage).append(previousPages).append(currentPage).append(nextPages).append(lastPage);
            }
        }

        $(document).ready(function () {
            renderer = new AccommodationRenderer;
            renderer.renderPagination({!! json_encode($accommodations->toArray()) !!});

            let selectedAccommodation = null;

            $('.delete-accommodation').on('click', function(event) {
                event.preventDefault();
                selectedAccommodation = $(this).data('id');
                $('#deleteAccommodationModal').modal('show');
            });

            $('#proceedDeleteAccommodation').on('click', function() {
                $('#deleteAccommodationModal').modal('hide');
                window.location.href = '/admin/accommodation/'+selectedAccommodation+'/delete';
            });

            $('#validateAccount').on('click', function (event) {
                event.preventDefault();
                $('#activateHostAndResetPassword').modal('show');
                const url = this.href;
                $('#proceedActivateHostAndResetPassword').on('click', function () {
                    window.location.href = url;
                });
            });

            $('#resetAccount').on('click', function (event) {
                event.preventDefault();
                $('#resetPassword').modal('show');
                const url = this.href;
                $('#proceedResetPassword').on('click', function () {
                    window.location.href = url;
                });
            });
        });
    </script>
@endsection
