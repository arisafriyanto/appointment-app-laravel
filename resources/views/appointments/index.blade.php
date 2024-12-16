@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 mb-3 mb-sm-0 mx-auto mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Appointments</h5>
                            <div>
                                <a href="{{ route('appointments.create') }}" class="btn btn-outline-primary">Create</a>
                            </div>
                        </div>
                        <p class="card-text">List the data of your appointments.</p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Title</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Creator</th>
                                    <th>Participants</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $page = $appointments->currentPage();
                                    $perPage = $appointments->perPage();
                                    $startNo = ($page - 1) * $perPage + 1;
                                @endphp
                                @foreach ($appointmentss as $index => $appointment)
                                    <tr>
                                        <td>{{ $startNo + $index }}.</td>
                                        <td>{{ $appointment['title'] }}</td>
                                        <td>{{ $appointment['start']->format('d F, Y H:i') }}</td>
                                        <td>{{ $appointment['end']->format('d F, Y H:i') }}</td>
                                        <td>{{ $appointment['creator'] }}</td>
                                        <td>{{ implode(', ', $appointment['participants']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div>
                            {{ $appointments->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
