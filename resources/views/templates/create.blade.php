@extends('layouts.app')

@section('content')
    <h3 class="mb-3">{{ __('Templates') }}</h3>
    <div class="card">
        <h5 class="card-header">{{ __('Create template') }}</h5>
        <div class="card-body">
            <form action="{{ route('templates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">{{ __('Description of template') }}<span class="text-danger">*</span></label>
                    <input required type="text" class="form-control" id="inputDescription" name="name"
                        placeholder="{{ __('Description of template') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('HTML Content') }}<span class="text-danger">*</span></label>
                    <textarea required class="form-control" id="inputContent" name="html_content" placeholder="{{ __('HTML Content') }}"
                        rows="20">{{ old('html_content') }}</textarea>

                    <small class="text-muted">{{ __('For more Informations about Variables, see ') }} <a href="#">{{ __('List of variables') }}</a></small>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Plain-text only') }}</label>
                    <textarea class="form-control" name="plain_text_content" placeholder="{{ __('Plain-text only') }}"
                        rows="10"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('HTML Preview') }}</label>
                    <div class="form-control" id="preview"></div>
                    <hr>

                    <script>
                        document.getElementById('inputContent').addEventListener('input', function() {
                            document.getElementById('preview').innerHTML = this.value;
                        });
                    </script>

                    <div class="mb-3">
                        <input type="checkbox" name="previewIsOkay" required>
                        {{ __('I have checked the preview and it is okay') }}
                    </div>


                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                    <button type="reset" class="btn btn-danger">{{ __('Reset') }}</button>
            </form>
        </div>
    </div>
@endsection
