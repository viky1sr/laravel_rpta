@extends('layouts.default')

@section('style-page')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        {{--        <div class="col-xl-3">--}}
        {{--            <!--begin::Card-->--}}
        {{--            <div class="card card-custom gutter-b card-stretch">--}}
        {{--                <!--begin::Body-->--}}
        {{--                <div class="card-body pt-4 d-flex flex-column justify-content-between">--}}
        {{--                    <!--begin::User-->--}}
        {{--                    <h3 class="text-justify">Contatc me</h3>--}}
        {{--                    <div class="d-flex align-items-center mb-7">--}}
        {{--                        <!--begin::Pic-->--}}
        {{--                        <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">--}}
        {{--                            <div class="symbol symbol-lg-75">--}}
        {{--                                <img alt="Pic" src="{{asset('assets/media/users/300_1.jpg')}}">--}}
        {{--                            </div>--}}
        {{--                            <div class="symbol symbol-lg-75 symbol-primary d-none">--}}
        {{--                                <span class="font-size-h3 font-weight-boldest">JM</span>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                        <!--end::Pic-->--}}
        {{--                        <!--begin::Title-->--}}
        {{--                        <div class="d-flex flex-column">--}}
        {{--                            <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">Luca Doncic</a>--}}
        {{--                            <span class="text-muted font-weight-bold">Head of Development</span>--}}
        {{--                        </div>--}}
        {{--                        <!--end::Title-->--}}
        {{--                    </div>--}}
        {{--                    <!--end::User-->--}}
        {{--                    <!--begin::Desc-->--}}
        {{--                    <p class="mb-7">I distinguish three--}}
        {{--                        <a href="#" class="text-primary pr-1">#XRS-54PQ</a>objectives First objectives and nice cooked rice</p>--}}
        {{--                    <!--end::Desc-->--}}
        {{--                    <!--begin::Info-->--}}
        {{--                    <div class="mb-7">--}}
        {{--                        <div class="d-flex justify-content-between align-items-center">--}}
        {{--                            <span class="text-dark-75 font-weight-bolder mr-2">Email:</span>--}}
        {{--                            <a href="#" class="text-muted text-hover-primary">luca@festudios.com</a>--}}
        {{--                        </div>--}}
        {{--                        <div class="d-flex justify-content-between align-items-cente my-1">--}}
        {{--                            <span class="text-dark-75 font-weight-bolder mr-2">Phone:</span>--}}
        {{--                            <a href="#" class="text-muted text-hover-primary">44(76)34254578</a>--}}
        {{--                        </div>--}}
        {{--                        <div class="d-flex justify-content-between align-items-center">--}}
        {{--                            <span class="text-dark-75 font-weight-bolder mr-2">Location:</span>--}}
        {{--                            <span class="text-muted font-weight-bold">Barcelona</span>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <!--end::Info-->--}}
        {{--                </div>--}}
        {{--                <!--end::Body-->--}}
        {{--            </div>--}}
        {{--            <!--end::Card-->--}}
        {{--        </div>--}}

        <div class="col-xl-12">
            <div class="container">
                <div class="row">

                    <div class=" col-md-3 col-sm-3">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b card-stretch">
                            <!--begin::Body-->
                            <div class="card-body text-center pt-4">
                                <!--begin::Toolbar-->
                                <!--end::Toolbar-->
                                <!--begin::User-->
                                <div class="mt-7">
                                    <div class="symbol symbol-circle symbol-lg-90">
                                        <img src="{{asset('assets/media/project-logos/1.png')}}" alt="image">
                                    </div>
                                </div>
                                <!--end::User-->
                                <!--begin::Name-->
                                <div class="my-4">
                                    <span class="text-dark font-weight-bold text-hover-primary font-size-h4">Perpustakaan</span>
                                </div>
                                <!--end::Name-->
                                <!--begin::Label-->
                                <span class="btn btn-text btn-light-success btn-sm font-weight-bold">Active</span>
                                <!--end::Label-->
                                <!--begin::Buttons-->
                                <div class="mt-9">
                                    <a
                                        @if(Auth::check())
                                        @if(Auth::user()->hasRole('admin'))
                                        href="{{route('perpustakaan.create-admin')}}"
                                        @else
                                        href="{{route('perpustakaan.create')}}"
                                        @endif
                                        @else
                                        href="{{route('perpustakaan.create')}}"
                                        @endif
                                        class="btn btn-light-primary font-weight-bolder btn-sm py-3 px-6 text-uppercase">Create project</a>
                                </div>
                                <!--end::Buttons-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <div class=" col-md-3 col-sm-3">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b card-stretch">
                            <!--begin::Body-->
                            <div class="card-body text-center pt-4">
                                <!--begin::Toolbar-->
                                <!--end::Toolbar-->
                                <!--begin::User-->
                                <div class="mt-7">
                                    <div class="symbol symbol-circle symbol-lg-90">
                                        <img src="{{asset('assets/media/project-logos/2.png')}}" alt="image">
                                    </div>
                                </div>
                                <!--end::User-->
                                <!--begin::Name-->
                                <div class="my-4">
                                    <span class="text-dark font-weight-bold text-hover-primary font-size-h4">Ruang Aula</span>
                                </div>
                                <!--end::Name-->
                                <!--begin::Label-->
                                <span class="btn btn-text btn-light-success btn-sm font-weight-bold">Active</span>
                                <!--end::Label-->
                                <!--begin::Buttons-->
                                <div class="mt-9">
                                    <a
                                        @if(Auth::check())
                                        @if(Auth::user()->hasRole('admin'))
                                        href="{{route('aula.create-admin')}}"
                                        @else
                                        href="{{route('aula.create')}}"
                                        @endif
                                        @else
                                        href="{{route('aula.create')}}"
                                        @endif
                                        class="btn btn-light-primary font-weight-bolder btn-sm py-3 px-6 text-uppercase">Create project</a>
                                </div>
                                <!--end::Buttons-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <div class=" col-md-3 col-sm-3">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b card-stretch">
                            <!--begin::Body-->
                            <div class="card-body text-center pt-4">
                                <!--begin::Toolbar-->
                                <!--end::Toolbar-->
                                <!--begin::User-->
                                <div class="mt-7">
                                    <div class="symbol symbol-circle symbol-lg-90">
                                        <img src="{{asset('assets/media/project-logos/3.png')}}" alt="image">
                                    </div>
                                </div>
                                <!--end::User-->
                                <!--begin::Name-->
                                <div class="my-4">
                                    <span class="text-dark font-weight-bold text-hover-primary font-size-h4">Ruang Laktaksi</span>
                                </div>
                                <!--end::Name-->
                                <!--begin::Label-->
                                <span class="btn btn-text btn-light-success btn-sm font-weight-bold">Active</span>
                                <!--end::Label-->
                                <!--begin::Buttons-->
                                <div class="mt-9">
                                    <a
                                        @if(Auth::check())
                                        @if(Auth::user()->hasRole('admin'))
                                        href="{{route('laktasi.create-admin')}}"
                                        @else
                                        href="{{route('laktasi.create')}}"
                                        @endif
                                        @else
                                        href="{{route('laktasi.create')}}"
                                        @endif
                                        class="btn btn-light-primary font-weight-bolder btn-sm py-3 px-6 text-uppercase">Create project</a>
                                </div>
                                <!--end::Buttons-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>

                    <div class="col-md-3 col-sm-3"></div>
                </div>
                <div class="row">
                    <div class=" col-md-3 col-sm-3">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b card-stretch">
                            <!--begin::Body-->
                            <div class="card-body text-center pt-4">
                                <!--begin::Toolbar-->
                                <!--end::Toolbar-->
                                <!--begin::User-->
                                <div class="mt-7">
                                    <div class="symbol symbol-circle symbol-lg-90">
                                        <img src="{{asset('assets/media/project-logos/4.png')}}" alt="image">
                                    </div>
                                </div>
                                <!--end::User-->
                                <!--begin::Name-->
                                <div class="my-4">
                                    <span class="text-dark font-weight-bold text-hover-primary font-size-h4">Lapangna Bulu Tangkis</span>
                                </div>
                                <!--end::Name-->
                                <!--begin::Label-->
                                <span class="btn btn-text btn-light-success btn-sm font-weight-bold">Active</span>
                                <!--end::Label-->
                                <!--begin::Buttons-->
                                <div class="mt-9">
                                    <a
                                        @if(Auth::check())
                                        @if(Auth::user()->hasRole('admin'))
                                        href="{{route('bulu-tangkis.create-admin')}}"
                                        @else
                                        href="{{route('bulu-tangkis.create')}}"
                                        @endif
                                        @else
                                        href="{{route('bulu-tangkis.create')}}"
                                        @endif
                                        class="btn btn-light-primary font-weight-bolder btn-sm py-3 px-6 text-uppercase">Create project</a>
                                </div>
                                <!--end::Buttons-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <div class=" col-md-3 col-sm-3">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b card-stretch">
                            <!--begin::Body-->
                            <div class="card-body text-center pt-4">
                                <!--begin::Toolbar-->
                                <!--end::Toolbar-->
                                <!--begin::User-->
                                <div class="mt-7">
                                    <div class="symbol symbol-circle symbol-lg-90">
                                        <img src="{{asset('assets/media/project-logos/5.png')}}" alt="image">
                                    </div>
                                </div>
                                <!--end::User-->
                                <!--begin::Name-->
                                <div class="my-4">
                                    <span class="text-dark font-weight-bold text-hover-primary font-size-h4">Lapangan Futsal</span>
                                </div>
                                <!--end::Name-->
                                <!--begin::Label-->
                                <span class="btn btn-text btn-light-success btn-sm font-weight-bold">Active</span>
                                <!--end::Label-->
                                <!--begin::Buttons-->
                                <div class="mt-9">
                                    <a
                                        @if(Auth::check())
                                        @if(Auth::user()->hasRole('admin'))
                                        href="{{route('futsal.create-admin')}}"
                                        @else
                                        href="{{route('futsal.create')}}"
                                        @endif
                                        @else
                                        href="{{route('futsal.create')}}"
                                        @endif
                                        class="btn btn-light-primary font-weight-bolder btn-sm py-3 px-6 text-uppercase">Create project</a>
                                </div>
                                <!--end::Buttons-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>

                    <div class="col-md-3 col-sm-3"></div>
                    <div class="col-md-3 col-sm-3"></div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script-page')

@stop
