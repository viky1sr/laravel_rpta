@extends('layouts.default')

@section('style-page')

@stop

@section('content')
    <div class="card card-custom gutter-b example example-compact">
        <!--begin::Form-->
        @role('member')
        <form id="perpustakaanForm" method="post" action="{{empty($id) ? route('perpustakaan.store') : route('perpustakaan.update',$id)}}" enctype="multipart/form-data" >
            @endrole
            @role('admin')
            <form id="perpustakaanForm" method="post" action="{{empty($id) ? route('perpustakaan.store-admin') : route('perpustakaan.update-admin',$id)}}" enctype="multipart/form-data" >
                @endrole
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Intansi</label>
                            <input type="text" name="instansi" class="form-control form-control-solid" value="{{$data->penerbit ?? null}}" placeholder="Example input">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Pemesan</label>
                            <input type="text" name="nama_pemesan" min="1" class="form-control form-control-solid" value="{{$data->jumlah_buku ?? null}}" placeholder="Example input">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Number Phone</label>
                            <input type="text" name="no_hp" maxlength="15" class="form-control form-control-solid" placeholder="Example input" value="{{$data->lokasi ?? null}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Pemesanan</label>
                            <input type="date" name="tanggal_pemesanan" class="form-control form-control-solid" placeholder="Example input" value="{{$data->th_terbit ?? null}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="waktu_booking">Waktu Booking</label>
                        <select name="waktu_booking" id="waktu_booking" class="form-control">
                            <option value="">---</option>
                            @foreach($waktus as $key => $item)
                                <option value="{{$item}} "
                                    {{isset($data->waktu_booking) && $data->waktu_booking == $item ? "selected" : "" }}> <i class="">{{$item}}</i>
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Type Booking</label>
                            <select name="type_booking" class="form-control " id="typeBooking">
                                <option value="">---</option>
                                <option value="1">Event</option>
                                <option value="2">Reguler</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 d-none" id="lamaBooking">
                        <div class="form-group">
                            <label>Lama Booking /Hari</label>
                            <select name="lama_booking" class="form-control " id="typeBooking">
                                <option value="">---</option>
                                <option value="1">1 Hari</option>
                                <option value="2">2 Hari</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label>Tujuan Kegiatan</label>
                        <div class="form-group">
                            <textarea name="tujuan_kegiatan" class="form-control disabled" id="tujuan_kegiatan" cols="110" rows="5">
                                {{$data->tujuan_kegiatan ?? null}}
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary mr-2 submitBtn">Submit</button>
                <a href="{{ route('perpustakaan.index')}}" class="btn btn-secondary backBtn">Cancel</a>
            </div>
        </form>
        <!--end::Form-->
    </div>
@stop

@section('script-page')
    <script src="{{asset('assets/js/pages/crud/file-upload/image-input.js')}}"></script>

    <script type="text/javascript">
        $('#typeBooking').on('change', function() {
            let idBooking = $(this).val();
            if(idBooking == 1) {
                $('#lamaBooking').removeClass('d-none')
            } else {
                $('#lamaBooking').addClass('d-none')
            }
        })

        $(document).ready(() => {
            $('#perpustakaanForm').on('submit', (e) => {
                   e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: $(this).attr("action"),
                    // data: $(this).find('input,select,textarea').serialize(),
                    data: new FormData($('#perpustakaanForm')[0]),
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $('.submitBtn').html('<button class="btn btn-danger spinner spinner-darker-success spinner-right mr-3"> Upload File </button>');
                        $('.submitBtn').prop('disabled', true);
                        $('.backBtn').addClass('d-none');
                    },
                    success: (data) => {
                        if(data.status === "ok"){
                            $('.submitBtn').html('Submit');
                            $('.submitBtn').prop('disabled', false);
                            $('.backBtn').removeClass('d-none');
                            toastr["success"](data.messages);
                            window.location.href = data.route
                        }
                    },
                    error: (data) => {
                        var data = data.responseJSON;
                        if(data.status == "fail"){
                            $('.submitBtn').html('Submit');
                            $('.submitBtn').prop('disabled', false);
                            $('.backBtn').removeClass('d-none');
                            toastr["error"](data.messages);
                        }
                    }
                });
            });
        })
    </script>
@stop
