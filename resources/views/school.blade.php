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
                <div class="card-header">Schools</div>
                
                <div class="card-body">
                
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">School</th>
                            <th scope="col">Number of Passers</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($schools) && $schools->count() > 0)
                            @foreach ($schools as $school)
                            <tr>
                                <td>{{ $school->name }}</td>
                                <td>{{ $school->passers_count }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>No data found!</td>
                            </tr>
                        @endif
                        
                    </tbody>
                </table>
                    
                </div><!-- /card-body -->
            </div><!-- /card -->

        </div>
    </div>
</div>
@endsection

