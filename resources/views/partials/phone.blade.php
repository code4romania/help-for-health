<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <select name="{{ $controlName }}Prefix" id="{{ $controlName }}Prefix" class="custom-select form-control @error($controlName.'Prefix') is-invalid @enderror">
                <option value="">Selectați Țara</option>
                @foreach ($prefixes as $country)
                    @if (!empty($country->phone_prefix))
                        <option value="{{ $country->code }}"{{ old($controlName.'Prefix', $prefixCode ?? "ro") == $country->code ? ' selected' : '' }}>
                            {{ $country->name }} (+{{ $country->phone_prefix }})
                        </option>
                    @endif
                @endforeach
            </select>

            @error($controlName.'Prefix')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-8">
        <div class="form-group">

            <input type="tel" placeholder="742000000" class="form-control @error($controlName) is-invalid @enderror" name="{{ $controlName }}Local" id="{{ $controlName }}Local" value="{{ old($controlName . 'Local', ltrim($controlDefault, $prefixValue ?? '')) }}" />
            <input type="hidden" name="{{ $controlName }}" id="{{ $controlName }}" value="{{ old($controlName, $controlDefault) }}" />

            @error($controlName)
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>


@section('scripts')
    <script>
        const updatePhone{{ md5($controlName) }} = function () {
            let countryCode = $("#{{ $controlName }}Prefix").val();
            let phoneNumber = $("#{{ $controlName }}Local").val();

            axios.post('{{ @route('ajax.phone') }}', {
                _token: "{{ csrf_token() }}",
                countryCode: countryCode,
                phoneNumber: phoneNumber
            }).then(response => {
                {{--$("#{{ $controlName }}Local").attr("placeholder", response.data.data.mask);--}}
                $("#{{ $controlName }}").val(response.data.data.intlPhone);

                if (countryCode !== response.data.data.countryCode) {
                    $("#{{ $controlName }}Prefix").val(response.data.data.countryCode);
                }

            }).catch(error => {
                console.log(error);
            });
        }

        $(document).ready(function () {
            updatePhone{{ md5($controlName) }}();

            $( "#{{ $controlName }}Local" ).keyup(updatePhone{{ md5($controlName) }});
            $( "#{{ $controlName }}Prefix" ).change(updatePhone{{ md5($controlName) }});

        });
    </script>
    @parent
@endsection
