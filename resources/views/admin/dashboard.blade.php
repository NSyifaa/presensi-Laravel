@extends('layout.main')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-calendar-alt"></i> Dashboard</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        {{-- <h4>Selamat datang, {{ Auth::user(); }}!</h4> --}}
                        <p>Ini adalah halaman dashboard admin.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection