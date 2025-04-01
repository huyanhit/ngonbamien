@extends('Admin::Layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-9">
                <div class="row">
                @foreach($data as $value)
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate" >
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{$value['title']}}</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0"><i class="ri-arrow-right-up-line fs-13 align-middle"></i> +16.24 %</h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">$<span class="counter-value" data-target="559.25">{{$value['page']}}</span>k</h4>
                                        <a href="{{$value['link']}}" class="text-decoration-underline">View net earnings</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                            <i class="bx bx-dollar-circle text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Recent Comment</h4>
                        <div class="flex-shrink-0">
                            <button type="button" class="btn btn-soft-primary btn-sm">
                                View All
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div data-simplebar="init" class="mx-n3 px-3 simplebar-scrollable-y" style="height: 375px;">
                            <div class="simplebar-wrapper" style="margin: 0px -16px;">
                                <div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div>
                                <div class="simplebar-mask">
                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                        <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                                            <div class="simplebar-content" style="padding: 0px 16px;">
                                                <div class="vstack gap-3">
                                                    <div class="d-flex gap-3">
                                                        <img src="/images/users/avatar-3.jpg" alt="" class="avatar-sm rounded flex-shrink-0" />
                                                        <div class="flex-shrink-1">
                                                            <h6 class="mb-2">Diana Kohler <span class="text-muted">Has commented</span></h6>
                                                            <p class="text-muted mb-0">" Really well-written and informative. The emotional connection strategy is something I’ll be testing out more! "</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-3">
                                                        <img src="/images/users/avatar-5.jpg" alt="" class="avatar-sm rounded flex-shrink-0" />
                                                        <div class="flex-shrink-1">
                                                            <h6 class="mb-2">Tonya Noble <span class="text-muted">Has commented</span></h6>
                                                            <p class="text-muted mb-0">" Incredibly helpful tips, especially about adding a call to action. I’ve been missing that step and will implement it in my next post! "</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-3">
                                                        <img src="/images/users/avatar-6.jpg" alt="" class="avatar-sm rounded flex-shrink-0" />
                                                        <div class="flex-shrink-1">
                                                            <h6 class="mb-2">Donald Palmer <span class="text-muted">Has commented</span></h6>
                                                            <p class="text-muted mb-0">" Fantastic read! The power of visuals and trends really stood out to me. Thanks for sharing these useful insights! "</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-3">
                                                        <img src="/images/users/avatar-7.jpg" alt="" class="avatar-sm rounded flex-shrink-0" />
                                                        <div class="flex-shrink-1">
                                                            <h6 class="mb-2">Joseph Parker <span class="text-muted">Has commented</span></h6>
                                                            <p class="text-muted mb-0">" Great post! Simple yet powerful tips that I can start using immediately. Thanks for sharing your expertise! "</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-3">
                                                        <img src="/images/users/avatar-9.jpg" alt="" class="avatar-sm rounded flex-shrink-0" />
                                                        <div class="flex-shrink-1">
                                                            <h6 class="mb-2">Timothy Smith <span class="text-muted">Has commented</span></h6>
                                                            <p class="text-muted mb-0">" Wow, this has opened my eyes to a new perspective on creating content. Emotional triggers—such a smart way to engage users! "</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-3">
                                                        <img src="/images/users/avatar-10.jpg" alt="" class="avatar-sm rounded flex-shrink-0" />
                                                        <div class="flex-shrink-1">
                                                            <h6 class="mb-2">Alexis Clarke <span class="text-muted">Has commented</span></h6>
                                                            <p class="text-muted mb-0">" Fantastic read! The power of visuals and trends really stood out to me. Thanks for sharing these useful insights! "</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-3">
                                                        <img src="/images/users/avatar-2.jpg" alt="" class="avatar-sm rounded flex-shrink-0" />
                                                        <div class="flex-shrink-1">
                                                            <h6 class="mb-2">Thomas Taylor <span class="text-muted">Has commented</span></h6>
                                                            <p class="text-muted mb-0">" Loved the section on visual storytelling. It’s true that images speak louder on social media platforms. More visuals in my next posts for sure! "</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: 384px; height: 729px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 192px; transform: translate3d(0px, 183px, 0px); display: block;"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body d-flex gap-3 align-items-center"><div class="avatar-sm">
                            <div class="avatar-title border bg-primary-subtle border-primary border-opacity-25 rounded-2 fs-17">
                                <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="feather feather-bar-chart icon-dual-primary"
                                >
                                    <line x1="12" y1="20" x2="12" y2="10"></line>
                                    <line x1="18" y1="20" x2="18" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="16"></line>
                                </svg>
                            </div>
                        </div>

                        <div class="flex-grow-1">
                            <p class="mb-0 text-muted">Online</p>
                            <h5 class="fs-15">{{$counter['online']}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body d-flex gap-3 align-items-center"><div class="avatar-sm">
                            <div class="avatar-title border bg-primary-subtle border-primary border-opacity-25 rounded-2 fs-17">
                                <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="feather feather-bar-chart icon-dual-primary"
                                >
                                    <line x1="12" y1="20" x2="12" y2="10"></line>
                                    <line x1="18" y1="20" x2="18" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="16"></line>
                                </svg>
                            </div>
                        </div>

                        <div class="flex-grow-1">
                            <p class="mb-0 text-muted">Today</p>
                            <h5 class="fs-15">{{$counter['today']}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body d-flex gap-3 align-items-center"><div class="avatar-sm">
                            <div class="avatar-title border bg-primary-subtle border-primary border-opacity-25 rounded-2 fs-17">
                                <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="feather feather-bar-chart icon-dual-primary"
                                >
                                    <line x1="12" y1="20" x2="12" y2="10"></line>
                                    <line x1="18" y1="20" x2="18" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="16"></line>
                                </svg>
                            </div>
                        </div>

                        <div class="flex-grow-1">
                            <p class="mb-0 text-muted">Total</p>
                            <h5 class="fs-15">{{$counter['total']}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body d-flex gap-3 align-items-center"><div class="avatar-sm">
                            <div class="avatar-title border bg-primary-subtle border-primary border-opacity-25 rounded-2 fs-17">
                                <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="feather feather-bar-chart icon-dual-primary"
                                >
                                    <line x1="12" y1="20" x2="12" y2="10"></line>
                                    <line x1="18" y1="20" x2="18" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="16"></line>
                                </svg>
                            </div>
                        </div>

                        <div class="flex-grow-1">
                            <p class="mb-0 text-muted">Dung lượng</p>
                            <h5 class="fs-15">{{ number_format($size['upload'] / 1048576, 2) }} MB</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body d-flex gap-3 align-items-center"><div class="avatar-sm">
                            <div class="avatar-title border bg-primary-subtle border-primary border-opacity-25 rounded-2 fs-17">
                                <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="feather feather-bar-chart icon-dual-primary"
                                >
                                    <line x1="12" y1="20" x2="12" y2="10"></line>
                                    <line x1="18" y1="20" x2="18" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="16"></line>
                                </svg>
                            </div>
                        </div>

                        <div class="flex-grow-1">
                            <p class="mb-0 text-muted">File không còn sử dụng</p>
                            <a onclick="event.preventDefault(); if(confirm('Bạn muốn xóa file không còn sử dụng.'))
                                        this.closest('form').submit()" > Xóa </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
