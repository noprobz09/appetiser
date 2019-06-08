@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <!-- Data Loader button -->
            <div class="clearfix text-center" style="margin-bottom: 30px;">
                <data-loader></data-loader>
            </div>

            <div class="card">
                <div class="card-header">Passers</div>
                
                <div class="card-body">
                
                    <add-examinee></add-examinee>
                    
                    <passers-lists></passers-lists>

                </div><!-- /card-body -->
            </div><!-- /card -->

        </div>
    </div>
</div>
@endsection

@push('scripts')
    
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    
@endpush
