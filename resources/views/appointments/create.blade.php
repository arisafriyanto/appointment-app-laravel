@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 mb-3 mb-sm-0 mx-auto mt-5" style="padding-bottom: 50px">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('appointments.index') }}" class="btn btn-light">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                    class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                                </svg>
                            </a>

                            Create Appointment
                        </h5>
                        <p class="card-text">Please fill out all forms to book an appointment.</p>

                        <form action="{{ route('appointments.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    id="date" name="date" value="{{ old('date') }}" min="{{ $minDate }}">
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="start" class="form-label">Start Time</label>
                                <input type="time" class="form-control @error('start') is-invalid @enderror"
                                    id="start" name="start" value="{{ old('start') }}">
                                @error('start')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="end" class="form-label">End Time</label>
                                <input type="time" class="form-control @error('end') is-invalid @enderror" id="end"
                                    name="end" value="{{ old('end') }}">
                                @error('end')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="participants" class="form-label">Participants</label>
                                <select multiple class="form-control @error('participants') is-invalid @enderror"
                                    id="participants" name="participants[]">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}
                                            ({{ $user->preferred_timezone }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('participants')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
