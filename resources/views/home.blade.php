@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-8 mb-3 mb-sm-0 mx-auto mt-5">
                <div class="card bg-body-tertiary border-0">
                    <div class="card-body px-4 py-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title pb-3">Welcome {{ Auth::user()->name }} to the Appointment App 👏</h3>
                        </div>
                        <p class="card-text pb-3">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque congue lectus non urna
                            scelerisque congue. Nunc cursus nulla sit amet gravida ullamcorper. Proin varius ex nec felis
                            imperdiet, et ornare turpis consectetur. Praesent eget tortor eget purus tristique sagittis id
                            rutrum nulla. In vel volutpat arcu. Vivamus id justo euismod, iaculis sapien quis, vestibulum
                            tortor. Ut tempus ante justo, nec mattis odio fringilla sed. Curabitur ullamcorper ultricies
                            tellus, varius tristique tellus varius eget. Nullam accumsan volutpat est, eu luctus arcu
                            fringilla nec.
                        </p>
                        <a href="{{ route('appointments.index') }}" class="btn btn-primary">See Appointments</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
