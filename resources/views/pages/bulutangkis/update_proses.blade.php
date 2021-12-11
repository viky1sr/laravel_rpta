@extends('layouts.default')

@section('style-page')

@stop

@section('content')
    <div class="card card-custom gutter-b example example-compact">
        <!--begin::Form-->

        @role('admin')
        <div class="card-body updateHidden">
            <button class="btn btn-sm btn-info float-right" data-toggle="modal" data-target="#updateStatus">Update Status</button>
        </div>
        @endrole
        <br>

        @if(Auth::user()->hasRole('member') && $data->status == 1)
            <h2 class="text-center" id="time"></h2>
        @endif

        @role('admin')
        @if($file_data != null)
            @if($data->status == 0 || $data->status == 3 )
                <div class="container">
                    <h5>Status : {{$data->is_status['status_name']}}</h5>
                    <div class="progress">
                        <button type="button" class="btn btn-success progress-bar" data-toggle="modal" data-target=""
                                role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                            <span class="container">100%</span>
                        </button>
                    </div>
                </div>
            @else
                <div class="container">
                    <h5>Status : {{$data->is_status['status_name']}}</h5>
                    <div class="progress">
                        <button type="button" class="btn btn-info progress-bar" data-toggle="modal" data-target=""
                                role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:75%">
                            <span class="container">75%</span>
                        </button>
                    </div>
                </div>
            @endif
        @else
            <div class="container">
                <h5>Status : {{$data->is_status['status_name']}}</h5>
                <div class="progress">
                    @if($data->created_by == 1)
                        <button type="button" class="btn btn-success progress-bar" data-toggle="modal" data-target=""
                                role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                            <span class="container">100%</span>
                        </button>
                    @else
                        @if($data->status == 1)
                            <button type="button" class="btn btn-primary progress-bar" data-toggle="modal" data-target=""
                                    role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">
                                <span class="container">50%</span>
                            </button>
                        @else
                            <button type="button" class="btn btn-success progress-bar" data-toggle="modal" data-target=""
                                    role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                <span class="container">100%</span>
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        @endif
        @endrole
        @role('member')
        @if($file_data != null)
            @if($data->status == 0 || $data->status == 3 )
                <div class="container">
                    <h5>Status : {{$data->is_status['status_name']}}</h5>
                    <div class="progress">
                        <button type="button" class="btn btn-success progress-bar" data-toggle="modal" data-target=""
                                role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                            <span class="container">100%</span>
                        </button>
                    </div>
                </div>
            @else
                <div class="container">
                    <h5>Status : {{$data->is_status['status_name']}}</h5>
                    <div class="progress">
                        <button type="button" class="btn btn-info progress-bar" data-toggle="modal" data-target=""
                                role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:75%">
                            <span class="container">75%</span>
                        </button>
                    </div>
                </div>
            @endif
        @else
            <div class="container">
                <h5>Status : {{$data->is_status['status_name']}}</h5>
                <div class="progress">
                    @if($data->status == 1)
                        <button type="button" class="btn btn-primary progress-bar" data-toggle="modal" data-target=""
                                role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">
                            <span class="container">50%</span>
                        </button>
                    @else
                        <button type="button" class="btn btn-success progress-bar" data-toggle="modal" data-target=""
                                role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                            <span class="container">100%</span>
                        </button>
                    @endif
                </div>
            </div>
        @endif
        @endrole

        <form id="aulaForm" method="post" action="{{ route('bulu-tangkis.upload-file',$id) }}" enctype="multipart/form-data" >
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Instansi</label>
                            <input type="text" disabled class="form-control form-control-solid" value="{{$data->instansi ?? null}}" placeholder="Example input">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Pemesan</label>
                            <input type="text" disabled min="1" class="form-control form-control-solid" value="{{$data->nama_pemesan ?? null}}" placeholder="Example input">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Number Phone</label>
                            <input type="text" disabled class="form-control form-control-solid" placeholder="Example input" value="{{$data->no_hp ?? null}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Pemesanan</label>
                            <input type="date" disabled class="form-control form-control-solid" placeholder="Example input" value="{{$data->tanggal_pemesanan ?? null}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jam Booking</label>
                            <input type="text" disabled class="form-control form-control-solid" placeholder="Example input" value="{{$data->waktu_booking ?? null}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Type Booking</label>
                            <input type="text" disabled class="form-control form-control-solid" placeholder="Example input" value="{{$data->type_booking == 1 ? 'Event' : 'Reguler'}}">
                        </div>
                    </div>
                    @if($data->type_booking == 1)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lama Booking</label>
                                <input type="text" disabled name="th_terbit" class="form-control form-control-solid" placeholder="Example input" value="{{$data->lama_booking.' Hari' ?? null}}">
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="waktu_booking">Waktu Booking</label>
                        <div class="form-group">
                            <select name="waktu_booking" id="waktu_booking" class="form-control select2" disabled>
                                <option value="">---</option>
                                @foreach($waktus as $key => $item)
                                    <option value="{{$item}}"
                                        {{isset($data->waktu_booking) && $data->waktu_booking == $item ? "selected" : "" }}> {{$item}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if(Auth::user()->hasRole('member') || $data->created_by == Auth::user()->id)
                        <div class="col-md-4 disabledTrue">
                            <div class="form-group">
                                <label for="">File Pendukung <span class="text-danger">*</span></label>
                                <input type="text" hidden class="form-control unable" name="aula_id" value="{{$data->id}}">
                                <input type="file" class="form-control readOnly" name="file_aula">
                            </div>
                        </div>
                    @endif

                    @if(!empty($file_data))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Download File Pendukung</label>
                                <a href="{{route('bulu-tangkis.download',$data->id)}}" class="btn btn-sm btn-info btn-block"><span class="fa fa-download"></span></a>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="tujuan_kegiatan" >Tujuan Kegiatan</label>
                            <textarea class="disabled" id="tujuan_kegiatan" cols="110" rows="5">
                                                {{$data->tujuan_kegiatan ?? null}}
                            </textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="hideButton btn btn-primary mr-2 submitBtn">Submit</button>
                <a href="{{route('bulu-tangkis.index')}}" class="btn btn-secondary backBtn">Back</a>
            </div>
        </form>
        <!--end::Form-->
    </div>

    <div class="modal fade" id="updateStatus" tabindex="-1" role="dialog" aria-labelledby="updateStatusLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusLabel">Update Status aula</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="statusForm" method="post" action="{{ route('bulu-tangkis.upload-file',$id) }}" enctype="multipart/form-data" >
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" id="isStatus" class="form-control">
                                        <option value="">---</option>
                                        <option value="3">Success</option>
                                        <option value="0">Reject</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 d-none" id="isReason">
                                <label>Reason</label>
                                <div class="form-group">
                                    <textarea name="reason" id="" cols="65" rows="3"  class="form-control">

                                    </textarea>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="disabledStatus" class="btn btn-primary statusSubmit">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @role('member')
    <div class="modal fade" id="statusReject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-warning">Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <p class="text-danger">Status : Reject</p>
                        <label>Reason</label>
                        <div class="form-group">
                             <textarea name="reason" disabled readonly id="" cols="65" rows="3"  class="form-control">
                            {{$data->info_status['reason'] ?? null}}
                             </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-warning" >Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="text-danger">Please upload file pendukung.</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--                    <button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>
    @endrole
@stop

@section('script-page')

    <script type="text/javascript">
        // Set a valid end date
        var countDownDate = new Date('{{$data->created_at}}').getTime() + (2*60*60*1000);
        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the countdown date
            var distance = countDownDate - now;

            // Calculate Remaining Time
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            // document.getElementById("time").innerHTML = days + "d " + hours + "h "
            //     + minutes + "m " + seconds + "s ";

            document.getElementById("time").innerHTML = "Durasi Upload: " + hours + "h "
                + minutes + "m " + seconds + "s ";

            // If the countdown is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("time").innerHTML = "REFRESH";
                @if($data->status == 1)
                window.location.reload(true)
                @endif
            }
        }, 1000);
    </script>

    <script type="text/javascript">
        $('.disabled').prop('disabled',true)
        var check = '{{$id}}';
        var checkFile = '{{isset($file_data->id) ? $file_data->id : 0}}';

        if(check != null) {
            @if($data->created_by == 1 || $data->status == 1 && Auth::user()->hasRole('admin') || $data->status == 3 )
            $('.hideButton').prop('hidden',true)
            @endif
            if(checkFile == 0) {
                @if(Auth::user()->hasRole('member') && $data->status == 1)
                $("#exampleModal").modal('show')

                setTimeout(function(){
                    $("#exampleModal").modal('toggle')
                }, 15000);
                @endif
            } else {
                $('.readOnly').prop('readonly',true)
                $('.disabledTrue').prop('hidden',true)
                $('.removeTrue').prop('hidden',true)
            @role('member')
                $('.hideButton').prop('hidden',true)
            @endrole
            }
        }

        $(document).ready(function(){
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
                            toastr["success"](data.messages);
                            window.location.reload(true)
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

            $('.statusSubmit').on('click', (e) => {
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
                    data: new FormData($('#statusForm')[0]),
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: (data) => {
                        if(data.status === "ok"){
                            toastr["success"](data.messages);
                            $("#disabledStatus").prop('disabled', true);
                            window.location.reload(true)
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
        })

        $('#isStatus').on('change', function() {
            var status = $(this).val();
            if(status == '') {
                status = 3;
            }
            if(status == 0) {
                $('#isReason').removeClass('d-none')
            } else if(status == 3) {
                $('#isReason').addClass('d-none')
            }
        })

        var checkStatus = '{{$data->status ?? ""}}';

        if(checkStatus == 0 || checkStatus == 1 || checkStatus == 3) {
            $('.updateHidden').addClass('d-none')
            if(checkStatus == 0) {
                $("#statusReject").modal('show')
                setTimeout(function(){
                    $("#statusReject").modal('toggle')
                }, 60000);
            }
        }
    </script>
@stop
