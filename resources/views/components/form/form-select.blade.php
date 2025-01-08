@props([
    'limit' => 'null',
    'selectClass' => 'form-control form-control-lg'
])

@push('headerFiles')
    <style>
        .ts-wrapper.form-control-lg .ts-control {
            font-size: 15px;
        }

        .ts-dropdown {
            font-size: 15px;
        }
    </style>
@endpush

<div class="form-group mb-4 {{ $wrapperClasses }}">
    @if($label)
        <label for="{{ $id }}">{{ $label }}@if($isRequired) <strong class="text-danger">*</strong> @endif</label>
    @endif
    <select id="{{ $id }}"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            {{ $multiple ? 'multiple' : 0 }}
            {{ $attributes }}
            class="{{ $selectClass }} @error($name) is-invalid @enderror">
        @if(!$multiple)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($dataValues as $item)
            <option
                value="{{ $item->$selectValueAttribute }}"
                @if(is_array(old($name, $values)))
                    @selected(in_array($item->$selectValueAttribute, old($name, $values)))
                @else
                    @selected(strval($item->$selectValueAttribute) === strval(old($name, $values)))
                @endif
            >
                {{ __($item->$selectValueLabel) }}
            </option>
        @endforeach
    </select>
    @error($name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

@push('footerFiles')
    <script>
        // Multi Select
        $(document).ready(function () {
            let url = new URL(window.location);

            let select = new TomSelect("#{{ $id }}", {
                maxItems: {{ $multiple ? $limit : 1 }},
                closeAfterSelect: {{ $multiple ? 0 : 1 }},
                placeholder: '{{ $placeholder }}',
                persist: false,
                render: {
                    no_results: function(data, escape) {
                        return '<div class="no-results">{{ __('Không tìm thấy kết quả nào') }}</div>';
                    }
                },
                onChange: function (value) {
                    @if($isFilter)
                    let currentUrl = new URL(window.location);
                    if (value) {
                        if ($.isArray(value)) {
                            if (value.length) {
                                currentUrl.searchParams.set(`{{ $name }}`, value)
                            } else {
                                currentUrl.searchParams.delete(`{{ $name }}`)
                            }
                        } else {
                            currentUrl.searchParams.set(`{{ $name }}`, value)
                        }
                    } else {
                        currentUrl.searchParams.delete(`{{ $name }}`)
                    }
                    window.history.pushState({}, '', currentUrl);
                    if ($('#{{ $datatableId }}').length) {
                        $('#{{ $datatableId }}').DataTable().ajax.reload()
                    }
                    @endif
                }
            });

            $('#remove-filter-btn').on('click', function() {
                select.clear();
            })

            if (url.searchParams.has('{{ $name }}')) {
                let selectedId = url.searchParams.get('{{ $name }}');
                if (selectedId.includes(',')) {
                    selectedId = selectedId.split(',');
                }
                select.setValue(selectedId)
            }
        })
    </script>
@endpush

