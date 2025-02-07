@extends('layouts.app')

@section('content')
    <script src="/data/js/jquery-3.7.1.min.js"></script>
    <script src="/data/js/jquery.multi-select.js"></script>
    <link rel="stylesheet" href="/data/css/multi-select.css ">
    <script>
        $(document).ready(function() {
            $('#multiselect').multiSelect({
                'selectableHeader': '<input type="text" class="mb-1 searchInputUsers form-control" placeholder="{{ __('Search users') }}">',
                'selectionHeader': '<input type="text" class="mb-1 searchInputUsersSelected form-control" placeholder="{{ __('Search selected users') }}">',
                afterInit: function(ms) {
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#' + that.$container.attr('id') +
                        ' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#' + that.$container.attr('id') +
                        ' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function(e) {
                            if (e.which === 40) {
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function(e) {
                            if (e.which == 40) {
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                },
                afterSelect: function() {
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterDeselect: function() {
                    this.qs1.cache();
                    this.qs2.cache();
                }
            });
            $('#multiselect2').multiSelect({
                'selectableHeader': '<input type="text" class="mb-1 searchInputGroups form-control" placeholder="{{ __('Search groups') }}">',
                'selectionHeader': '<input type="text" class="mb-1 searchInputGroupsSelected form-control" placeholder="{{ __('Search selected groups') }}">',
                afterInit: function(ms) {
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#' + that.$container.attr('id') +
                        ' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#' + that.$container.attr('id') +
                        ' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function(e) {
                            if (e.which === 40) {
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function(e) {
                            if (e.which == 40) {
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                },
                afterSelect: function() {
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterDeselect: function() {
                    this.qs1.cache();
                    this.qs2.cache();
                }
            });
        });
    </script>

    <h3 class="mb-3">{{ __('Groups') }}</h3>

    <div class="card">
        <h5 class="card-header">{{ __('Create group') }}</h5>
        <div class="card-body">

            <form action="{{ route('groups.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                    <input required type="text" class="form-control" name="name" placeholder="Name" id="name">
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Template') }}<span class="text-danger">*</span></label>
                    <select required class="form-select" name="template_id">
                        <option value="0">{{ __('Select a template') }}...</option>
                        @foreach ($templates as $template)
                            <option value="{{ $template->id }}">
                                {{ $template->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex">
                    <div class="p-2 flex-fill">
                        <label class="form-label">{{ __('AD Users') }}<span class="text-danger">*</span></label>

                        <select name="users[]" id="multiselect" multiple="multiple">
                            <option value="*">* (Alle)</option>
                            @foreach ($ldap_users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="p-2 flex-fill">
                        <label class="form-label">{{ __('AD Groups') }}<span class="text-danger">*</span></label>
                        <select name="groups[]" id="multiselect2" multiple="multiple">
                            <option value="*">* (Alle)</option>
                            @foreach ($ldap_groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr>

                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <button type="reset" class="btn btn-danger">{{ __('Reset') }}</button>
            </form>
        </div>
    </div>
@endsection
