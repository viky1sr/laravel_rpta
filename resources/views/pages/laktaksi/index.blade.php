@extends('layouts.default')

@section('style-page')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <div class="card card-custom card-stretch gutter-b bg-light-info col-xl-12">
        <div class="card-body">
            <!--begin: Search Form-->
            <form class="mb-15">
                <div class="row mb-6">
                    <div class="col-lg-3 mb-lg-0 mb-6">
                        <label>Nama Pemesan:</label>
                        <input type="text" name="kode_buku" id="kode_buku" class="form-control datatable-input" placeholder="E.g: 4590" data-col-index="0" />
                    </div>
                    <div class="col-lg-3 mb-lg-0 mb-6">
                        <label>Intansi:</label>
                        <input type="text" class="form-control datatable-input" name="judul" id="judul" placeholder="Fullstack Javascript" data-col-index="1" />
                    </div>
                    <div class="col-lg-3 mb-lg-0 mb-6">
                        <label>Status:</label>
                        <select name="status" id="status" class="form-control form-control-solid datatable-input">
                            <option value=""><i class="">---</i></option>
                            @forelse($status as $key => $item)
                                <option value="{{$key}}"><i class="">{{$item}}</i></option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-lg-3 mb-lg-0 mb-6">
                        <label>Waktu Booking:</label>
                        <select name="jam_booking"  class="jam_booking form-control form-control-solid datatable-input">
                            <option value=""><i class="">---</i></option>
                            @forelse($waktus as $key => $item)
                                <option value="{{$key}}"><i class="">{{$item}}</i></option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="row mb-8">
                    <div class="col-lg-6 mb-lg-0 mb-12">
                        <label>Tanggal Booking:</label>
                        <div class="input-daterange input-group" id="kt_datepicker">
                            <input type="text" class="form-control datatable-input waktu_booking_start" name="waktu_booking_start" placeholder="From" data-col-index="3" />
                            <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-ellipsis-h"></i>
															</span>
                            </div>
                            <input type="text" class="form-control datatable-input waktu_booking_end" name="waktu_booking_end" placeholder="To" data-col-index="3" />
                        </div>
                    </div>

                    <div class="col-lg-3 mb-lg-0 mb-6">
                        <label>Kode Booking:</label>
                        <input type="text" class="form-control datatable-input" id="kode_booking" name="kode_booking"  placeholder="Kode Bokking"  data-col-index="1" />
                    </div>

                    @role('admin')
                    <div class="col-lg-3 mb-lg-0 mb-6">
                        <label>Create By:</label>
                        <select name="created_by"  class="created_by form-control form-control-solid datatable-input">
                            <option value=""><i class="">---</i></option>
                            @forelse($users as $key => $item)
                                <option value="{{$item->id}}"><i class="">{{$item->first_name.' '.$item->last_name }}</i></option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    @endrole

                </div>
                <div class="row mt-8">
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-primary btn-primary--icon" id="filter">
													<span>
														<i class="la la-search"></i>
														<span>Search</span>
													</span>
                        </button>&#160;&#160;
                        <button class="btn btn-secondary btn-secondary--icon" id="kt_reset">
													<span>
														<i class="la la-close"></i>
														<span>Reset</span>
													</span>
                        </button>
                        @if(Auth::user()->hasRole('member'))
                            <a href="{{route('laktasi.create')}}" class="btn btn-sm btn-info float-right">Create Booking</a>
                        @else
                            <a href="{{route('laktasi.create-admin')}}" class="btn btn-sm btn-info float-right">Create Booking</a>
                        @endif
                    </div>
                </div>
            </form>
            <!--begin: Datatable-->
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" id="dataTable">
                <thead>
                <tr>
                    <th>Nama Pemesanan</th>
                    <th>Intansi</th>
                    <th>Tanggal Booking</th>
                    <th>Waktu Booking</th>
                    <th>Kode Booking</th>
                    <th>Status</th>
                    @role('admin')
                    <th>Created By</th>
                    @endrole
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Nama Pemesanan</th>
                    <th>Intansi</th>
                    <th>Tanggal Booking</th>
                    <th>Waktu Booking</th>
                    <th>Kode Booking</th>
                    <th>Status</th>
                    @role('admin')
                    <th>Created By</th>
                    @endrole
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
@stop

@section('script-page')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script type="text/javascript">
        "use strict";
        var KTDatatablesSearchOptionsAdvancedSearch = function() {

            $.fn.dataTable.Api.register('column().title()', function() {
                return $(this.header()).text().trim();
            });

            var initTable1 = function() {
                // begin first table
                var table = $('#dataTable').DataTable({
                    responsive: true,
                    // Pagination settings
                    dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                    // read more: https://datatables.net/examples/basic_init/dom.html

                    lengthMenu: [5, 10, 25, 50],

                    pageLength: 10,

                    language: {
                        'lengthMenu': 'Display _MENU_',
                    },

                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url : '{{route('laktasi.data-tables')}}',
                        type: 'GET',
                        data: function (d) {
                            d.nama_pemesan = $('#nama_pemesan').val();
                            d.instansi = $('#instansi').val();
                            d.kode_booking = $('#kode_booking').val();
                            d.status    = $('#status').val();
                            d.no_induk    = $('#no_induk').val();
                            d.waktu_booking_start    = $('.waktu_booking_start').val();
                            d.waktu_booking_end    = $('.waktu_booking_end').val();
                            d.jam_booking    = $('.jam_booking').val();
                            d.created_by    = $('.created_by').val();
                        }
                    },

                    columns: [
                        {data : 'nama_pemesan' , name: 'nama_pemesan'},
                        {data : 'instansi' , name: 'instansi'},
                        {data : 'tanggal_pemesanan' , name: 'tanggal_pemesanan'},
                        {data : 'waktu_booking' , name: 'waktu_booking'},
                        {data : 'kode_booking' , name: 'kode_booking'},
                        {data : 'status_name' , name: 'status_name'},
                    @role('admin')
                        {data : 'full_name' , name: 'full_name'}
                        ,@endrole
                        {data: 'id', name: 'id' , searchable: false , orderable: false ,render : function(data, type , row) {
                                return '<a href="aula/show/'+row.id+'" title="show" ><i class="fa fa-fw fa-eye text-info"></i></a>'
                            }
                        }
                    ],

                    initComplete: function() {
                        this.api().columns().every(function() {
                            var column = this;

                            switch (column.title()) {
                                case 'status':
                                    var status = {
                                        1: {'title': 'Pending', 'class': 'label-light-primary'},
                                        2: {'title': 'Success', 'class': ' label-light-success'},
                                        3: {'title': 'Reject', 'class': ' label-light-danger'},
                                    };
                                    column.data().unique().sort().each(function(d, j) {
                                        $('.datatable-input[data-col-index="6"]').append('<option value="' + d + '">' + status[d].title + '</option>');
                                    });
                                    break;
                            }
                        });
                    },

                    columnDefs: [
                        {
                            targets: 6,
                            render: function(data, type, full, meta) {
                                var status = {
                                    1: {'title': 'Pending', 'class': 'label-light-primary'},
                                    2: {'title': 'Success', 'class': ' label-light-success'},
                                    3: {'title': 'Reject', 'class': ' label-light-danger'},
                                };
                                if (typeof status[data] === 'undefined') {
                                    return data;
                                }
                                return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
                            },
                        },
                    ],
                });

                $('#applyForm').on('submit', (e) => {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var id =$('#id').val();
                    var url = "{{ url('meminjam-buku') }}" + '/' + id;

                    $.ajax({
                        type: 'POST',
                        url: url,
                        // data: $(this).find('input,select,textarea').serialize(),
                        data: new FormData($('#applyForm')[0]),
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: (data) => {
                            if(data.status === "ok"){
                                $('#modal-form').modal('hide');
                                toastr["success"](data.messages);
                                table.ajax.reload();
                            }
                        },
                        error: (data) => {
                            var data = data.responseJSON;
                            if(data.status == "fail"){
                                toastr["error"](data.messages);
                            }
                        }
                    });
                });

                $('#filter').click(function(){
                    $('#dataTable').DataTable().draw(true);
                });

                $('#kt_reset').on('click', function(e) {
                    e.preventDefault();
                    $('.datatable-input').each(function() {
                        $(this).val('');
                        table.column($(this).data('col-index')).search('', false, false);
                    });
                    table.table().draw();
                });

                $('#kt_datepicker').datepicker({
                    todayHighlight: true,
                    templates: {
                        leftArrow: '<i class="la la-angle-left"></i>',
                        rightArrow: '<i class="la la-angle-right"></i>',
                    },
                });
                $('#kt_datepicker1').datepicker({
                    todayHighlight: true,
                    templates: {
                        leftArrow: '<i class="la la-angle-left"></i>',
                        rightArrow: '<i class="la la-angle-right"></i>',
                    },
                });

            };

            return {

                //main function to initiate the module
                init: function() {
                    initTable1();
                },

            };

        }();

        jQuery(document).ready(function() {
            KTDatatablesSearchOptionsAdvancedSearch.init();
        });

        function applyPeminjaman(id) {
            $('input[name=_method]').val('POST');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('meminjam-buku') }}" + '/' + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('#id').val(data.id);
                },
                error : function() {
                    toastr["error"]('Nothing data.');
                }
            })
        }

    </script>
@stop
