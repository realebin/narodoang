@extends('layout/main')
@section('title','Create User')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-8 ">
            <h1 class="mt-3"> Create Data Seminar</h1>
            
            <form method="post" action="/seminar"> 
                <!-- csrf supaya kita aman dari hackers-->
                <!-- id bwt nyambungin ke variable di controller & db nya-->
                @csrf
                <div class="form-group row">
                            <label for="nama_seminar" class="col-md-4 col-form-label text-md-right">{{ __('Nama Seminar') }}</label>

                            <div class="col-md-6">
                                <input id="nama_seminar" type="text" class="form-control @error('nama_seminar') is-invalid @enderror" name="nama_seminar" value="{{ old('nama_seminar') }}" placeholder="Masukkan Nama Seminar" required autocomplete="nama_seminar" autofocus>

                                @error('nama_seminar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="deskripsi" class="col-md-4 col-form-label text-md-right">{{ __('Deskripsi Seminar') }}</label>

                            <div class="col-md-6">
                                <input id="deskripsi" type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" value="{{ old('deskripsi') }}" placeholder="Masukkan Deskripsi Mengenai Seminar" required autocomplete="deskripsi">

                                @error('deskripsi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="topik_id" class="col-md-4 col-form-label text-md-right">{{ __('Topik') }}</label>
                                <div class="col-md-6">
                                    <select name="topik_id" id="topik_id" class="mdb-select md-form colorful-select dropdown-primary combox">
                                    <option></option>
                                        @foreach($topik as $t)
                                            <option value="{{$t->id_topik}}">{{$t->nama_topik}}</option>
                                        @endforeach
                                    </select>
                                    @error('topik_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                        </div>
                        <div class="form-group row">
                            <label for="waktu_mulai" class="col-md-4 col-form-label text-md-right">{{ __('Waktu Mulai') }}</label>
                                <div class="col-md-6">
                            <input id="waktu_mulai" type="datetime-local" class="form-control @error('waktu_mulai') is-invalid @enderror" name="waktu_mulai" value="{{ old('waktu_mulai') }}" placeholder="Masukkan Waktu Mulainya Seminar" required autocomplete="waktu_mulai">
                        </div>
                        </div>

                        <div class="form-group row">
                            <label for="waktu_selesai" class="col-md-4 col-form-label text-md-right">{{ __('Waktu Selesai') }}</label>
                                <div class="col-md-6">
                                    <input id="waktu_selesai" type="datetime-local" class="form-control @error('waktu_selesai') is-invalid @enderror" name="waktu_selesai" value="{{ old('waktu_selesai') }}" placeholder="Masukkan Waktu Selesainya Seminar" required autocomplete="waktu_selesai">
                                </div>
                        </div>

                        <div class="form-group row">
                            <label for="py" class="col-md-4 col-form-label text-md-right">{{ __('Penyelanggara Seminar') }}</label>
                                <div class="col-md-6">
                                    <select name="py" id="py" class="mdb-select md-form colorful-select dropdown-primary combox">
                                    <option></option>
                                        @foreach($user as $u)
                                            <option value="{{$u->id}}">{{$u->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('topik_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                        </div>

                        <div class="form-group row">
                            <label for="pb" class="col-md-4 col-form-label text-md-right">{{ __('Pembicara Seminar') }}</label>
                                <div class="col-md-6">
                                    <select name="pb" id="pb" class="mdb-select md-form colorful-select dropdown-primary combox">
                                        @foreach($user as $u)
                                        <option></option>
                                            <option value="{{$u->id}}">{{$u->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('topik_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                        </div>

                        <div id="list_deskripsi">
                        <!-- @php
                            $count = 0;
                            @endphp
                            @for($i = 0; $i< $count;$i++)
                                
                            <div class="form-group row">
                            <label for="pb" class="col-md-4 col-form-label text-md-right">{{ __('Pembicara Seminar') }}</label>
                                <div class="col-md-6">
                                    <select name="pb" id="pb" class="mdb-select md-form colorful-select dropdown-primary combox">
                                        @foreach($user as $u)
                                        <option></option>
                                            <option value="{{$u->id}}">{{$u->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('topik_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                        </div>

                                
                            @endfor -->
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                        <button type="button" class="btn btn-primary btn-add-user"  > <h5>+</h5> Tambah User (misal : moderator, pembicara, dsb) </button>
                            </div>
                        </div>



                        
                        <!-- <div class="well">
                            <div id="datetimepicker1" class="input-append date">
                                <input data-format="dd/MM/yyyy hh:mm:ss" type="text">
                                <span class="add-on">
                                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                </i>
                                </span>
                            </div>
                        </div> -->
                            <!-- <script type="text/javascript">
                            $(function() {
                                $('#datetimepicker1').datetimepicker({
                                language: 'pt-BR'
                                });
                            });
                            </script> -->



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Tambah Data') }}
                                </button>
                            </div>
                        </div>

            </form>

        </div>
    </div>
</div>

@endsection

@section('jquery')
<script type="text/javascript">

$('.btn-add-user').on('click',function(){
    var deskripsi_seminar="";
    var value_deskripsi="";
    $('#list_deskripsi').append(
        `

        <div class="form-group row">
                            <label for="sebagai" class="col-md-4 col-form-label text-md-right">{{ __('User Sebagai') }}</label>

                            <div class="col-md-6">
                                <input id="sebagai" type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="sebagai" value="{{ old('sebagai') }}" placeholder="Masukkan User Memiliki Jabatan Apa" required autocomplete="sebagai">

                                @error('deskripsi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

        <div class="form-group row">
                            <label for="pb" class="col-md-4 col-form-label text-md-right">{{ __('Pembicara Seminar') }}</label>
                                <div class="col-md-6">
                                    <select name="pb" id="pb" class="mdb-select md-form colorful-select dropdown-primary combox">
                                        @foreach($user as $u)
                                        <option></option>
                                            <option value="{{$u->id}}">{{$u->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('topik_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                        </div>
                        <div class="userrolesama">
                        </div>
        

        
        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                        <button type="button" class="btn btn-primary btn-add-userrole" > <h5>+</h5> Tambah User Dengan Role yang sama</button>
                            </div>
                        </div>
        `
    );
});
</script>


<script type="text/javascript">
$('.btn-add-userrole').on('click',function(){
    
    $('#userrolesama').append(
        `
        <div class="form-group row">
                            <label for="pb" class="col-md-4 col-form-label text-md-right">{{ __('Pembicara Seminar') }}</label>
                                <div class="col-md-6">
                                    <select name="pb" id="pb" class="mdb-select md-form colorful-select dropdown-primary combox">
                                        
                                 </div>
                        </div>
                        `
    );

});
</script>
@endsection