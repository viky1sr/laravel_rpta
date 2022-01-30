@extends('layouts.default')

@section('style-page')

@stop

@section('content')
    <div class="card card-custom gutter-b example example-compact">
        <!--begin::Form-->
            <form id="aulaForm" method="post" action="{{route('genetika.store')}}" enctype="multipart/form-data" >
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Intansi</label>
                            <input type="text" name="instansi" class="form-control form-control-solid" value="{{$data->penerbit ?? null}}" placeholder="Example input">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nama Pemesan</label>
                            <input type="text" name="nama_pemesan" min="1" class="form-control form-control-solid" value="{{$data->jumlah_buku ?? null}}" placeholder="Example input">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Type Pelaksanaan</label>
                            <select name="model" class="form-control" >
                                <option value="">---</option>
                                <option value="Ruang Perpustakaan">Ruang Perpustakaan</option>
                                <option value="Ruang Aula">Ruang Aula</option>
                                <option value="Ruang Laktaksi">Ruang Laktaksi</option>
                                <option value="Lapangan Bulu Tangkis">Lapangan Bulu Tangkis</option>
                                <option value="Lapangan Futsal">Lapangan Futsal</option>
                            </select>
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
                            <select name="lama_booking_e" class="form-control">
                                <option value="">---</option>
                                <option value="1">1 Hari</option>
                                <option value="2">2 Hari</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 d-none" id="lamaBookingRegulasi">
                        <div class="form-group">
                            <label>Lama Booking /Minggu</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="lama_booking_r" placeholder="Ex: 10" aria-label="Username" aria-describedby="basic-addon1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Minggu</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label>Tujuan Kegiatan</label>
                        <div class="form-group">
                            <textarea name="tujuan_kegiatan" class="disabled" id="tujuan_kegiatan" cols="110" rows="5">
                                {{$data->tujuan_kegiatan ?? null}}
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary mr-2 ">Submit</button>
                <button type="" class="btn btn-secondary ">Cancel</button>
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
                $('#lamaBookingRegulasi').addClass('d-none')
            } else if(idBooking == 2) {
                $('#lamaBooking').addClass('d-none')
                $('#lamaBookingRegulasi').removeClass('d-none')
            } else {
                $('#lamaBooking').addClass('d-none')
                $('#lamaBookingRegulasi').addClass('d-none')
            }
        })

        $(document).ready(() => {
            $('#aulaForm').on('submit', (e) => {
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
                    data: new FormData($('#aulaForm')[0]),
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
                            toastr["success"](data.message);
                            window.location.href = data.route
                        }
                    },
                    error: (data) => {
                        var data = data.responseJSON;
                        if(data.status == "fail"){
                            $('.submitBtn').html('Submit');
                            $('.submitBtn').prop('disabled', false);
                            $('.backBtn').removeClass('d-none');
                            toastr["error"](data.message);
                        }
                    }
                });
            });
        })
    </script>
@stop
