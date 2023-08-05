@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    
        
                 
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">Phone</th>
                          <th scope="col">Start</th>
                          <th scope="col">End</th>
                          <th scope="col">Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($loans as $client_loan)
                        <tr>
                          <th scope="row">{{ $client_loan->phone }}</th>
                          <th scope="row">{{ $client_loan->start_date }}</th>
                          <td>{{ $client_loan->end_date }}</td>
                          <td>{{ $client_loan->amount }}</td>
                        </tr>
                         @endforeach
                      </tbody>
                        </table>
        </div>
    </div>
</div>
@endsection
