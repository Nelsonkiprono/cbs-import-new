@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Name</th>
                  <th scope="col">External ID</th>
                  <th scope="col">Phone No</th>
                  <th scope="col">office</th>
                </tr>
              </thead>
              <tbody>
                @foreach($clients as $client)
                <tr>
                  <th scope="row">{{ $client->id }}</th>
                  <td>{{ $client->display_name  }}</td>
                  <td>{{ $client->external_id  }}</td>
                  <td>{{ $client->mobile_no  }}</td>
                  <td>{{ $client->office->name  }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
