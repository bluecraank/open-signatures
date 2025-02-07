@extends('layouts.app')

@section('content')
    @can('read templates')
        <h3 class="mb-3">{{ __('Templates') }}</h3>

        <div class="card">
            <h5 class="card-header">
                {{ __('Overview') }}
                @can('create templates')
                    <a href="{{ route('templates.create') }}" class="btn-primary btn btn-sm float-end">
                        <span class="icon"><i class="bi-plus"></i></span>
                        <span>{{ __('Create template') }}</span>
                    </a>
                @endcan
            </h5>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>{{ __('Used by') }}</th>
                            <th>{{ __('Created by') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($templates as $template)
                            <tr>
                                <td>{{ $template->name }}</td>
                                <td>{{ $template->groupList() }}</td>
                                <td>{{ $template->created_by }}</td>
                                <td class="actions-cell">

                                    <form action="{{ route('templates.destroy', ['id' => $template->id]) }}" method="POST"
                                        onsubmit="return confirm('{{ __('Are you sure to delete this template?') }}')">
                                        @method('DELETE')
                                        @csrf
                                        @can('read templates')
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('templates.update', ['id' => $template->id]) }}"><i
                                                    class="bi-pen"></i></a>
                                        @endcan
                                        @can('delete templates')
                                            <button class="btn btn-danger btn-sm" type="submit"><i class="bi-trash"></i></button>
                                        @endcan
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if ($templates->count() == 0)
                            <tr>
                                <td colspan="5" class="text-center">
                                    {{ __('No templates found') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endcan
    @cannot('read templates')
        @include('unauthorized')
    @endcannot
@endsection
