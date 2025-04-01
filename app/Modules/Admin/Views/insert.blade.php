@extends('Admin::Layouts.admin')
@section('content')
    <div class="container-fluid">
        <form id="insert" method="post" action="{{ route($resource.'.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-8">
                     <div class="card">
                         <div class="card-body">
                             @foreach($form as $key => $val)
                                 <x-fields :key="$key" :val="$val"/>
                             @endforeach
                         </div>
                         <div class="card-footer">
                            <div class="form-group text-center">
                                <div class="col-12">
                                    <input type="submit" id="submit" name="submit" value="Lưu" class="btn btn-success">
                                    <input type="submit" id="submit" name="submit_edit" value="Lưu & Chỉnh Sửa Tiếp" class="btn btn-secondary">
                                    @if(Request::get('back'))
                                        <a class="btn btn-info" href="{{Request::root()}}/{{urldecode(Request::get('back'))}}"> Quay lại </a>
                                    @else
                                        <a class="btn btn-danger prefix_link" href="{{ route($resource.'.index') }}"> Hủy </a>
                                    @endif
                                    @if(isset($data['id']))
                                        <span class="option-order">
                                    @if(isset($control['next']))
                                                <a class="btn btn-info" href="{{Request::root()}}/{{$control['next']['link']}}/{{$data['id']}}"> {{$control['next']['title']}} <i title="{{$control['next']['title']}}" class="fa fa-chevron-right"></i></a>
                                            @endif
                                            @if(isset($control['prev']))
                                                <a class="btn btn-info" href="{{Request::root()}}/{{$control['prev']['link']}}/{{$data['id']}}"><i title="{{$control['prev']['title']}}" class="fa fa-chevron-left" aria-hidden="true">{{$control['next']['title']}}</i></a>
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Publish</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="choices-publish-status-input" class="form-label">Status</label>

                                <div class="choices" data-type="select-one" tabindex="0" role="listbox" aria-label="Status" aria-haspopup="true" aria-expanded="false">
                                    <div class="choices__inner">
                                        <select class="form-select choices__input" id="choices-publish-status-input" data-choices="" data-choices-search-false="" hidden="" tabindex="-1" data-choice="active">
                                            <option value="Published" selected="">Published</option>
                                            <option value="Scheduled">Scheduled</option>
                                            <option value="Draft">Draft</option>
                                        </select>
                                        <div class="choices__list choices__list--single"><div class="choices__item choices__item--selectable" data-item="" data-id="1" data-value="Published" aria-selected="true" role="option">Published</div></div>
                                    </div>
                                    <div class="choices__list choices__list--dropdown" aria-expanded="false">
                                        <div class="choices__list" role="listbox">
                                            <div
                                                    id="choices--choices-publish-status-input-item-choice-3"
                                                    class="choices__item choices__item--choice choices__item--selectable is-highlighted"
                                                    role="option"
                                                    data-choice=""
                                                    data-id="3"
                                                    data-value="Draft"
                                                    data-select-text="Press to select"
                                                    data-choice-selectable=""
                                                    aria-selected="true"
                                            >
                                                Draft
                                            </div>
                                            <div
                                                    id="choices--choices-publish-status-input-item-choice-1"
                                                    class="choices__item choices__item--choice is-selected choices__item--selectable"
                                                    role="option"
                                                    data-choice=""
                                                    data-id="1"
                                                    data-value="Published"
                                                    data-select-text="Press to select"
                                                    data-choice-selectable=""
                                            >
                                                Published
                                            </div>
                                            <div
                                                    id="choices--choices-publish-status-input-item-choice-2"
                                                    class="choices__item choices__item--choice choices__item--selectable"
                                                    role="option"
                                                    data-choice=""
                                                    data-id="2"
                                                    data-value="Scheduled"
                                                    data-select-text="Press to select"
                                                    data-choice-selectable=""
                                            >
                                                Scheduled
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="choices-publish-visibility-input" class="form-label">Visibility</label>
                                <div class="choices" data-type="select-one" tabindex="0" role="listbox" aria-label="Visibility" aria-haspopup="true" aria-expanded="false">
                                    <div class="choices__inner">
                                        <select class="form-select choices__input" id="choices-publish-visibility-input" data-choices="" data-choices-search-false="" hidden="" tabindex="-1" data-choice="active">
                                            <option value="Public" selected="">Public</option>
                                            <option value="Hidden">Hidden</option>
                                        </select>
                                        <div class="choices__list choices__list--single"><div class="choices__item choices__item--selectable" data-item="" data-id="1" data-value="Public" aria-selected="true" role="option">Public</div></div>
                                    </div>
                                    <div class="choices__list choices__list--dropdown" aria-expanded="false">
                                        <div class="choices__list" role="listbox">
                                            <div
                                                    id="choices--choices-publish-visibility-input-item-choice-2"
                                                    class="choices__item choices__item--choice choices__item--selectable is-highlighted"
                                                    role="option"
                                                    data-choice=""
                                                    data-id="2"
                                                    data-value="Hidden"
                                                    data-select-text="Press to select"
                                                    data-choice-selectable=""
                                                    aria-selected="true"
                                            >
                                                Hidden
                                            </div>
                                            <div
                                                    id="choices--choices-publish-visibility-input-item-choice-1"
                                                    class="choices__item choices__item--choice is-selected choices__item--selectable"
                                                    role="option"
                                                    data-choice=""
                                                    data-id="1"
                                                    data-value="Public"
                                                    data-select-text="Press to select"
                                                    data-choice-selectable=""
                                            >
                                                Public
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
