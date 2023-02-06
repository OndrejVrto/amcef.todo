@extends('layouts.app')

@section('content')
    <div class="col-lg-10 col-xl-9 mx-auto">
        <h2 class="text-end">Sharing task</h2>

        <form action="{{ action(\App\Http\Controllers\Task\ShareSaveTaskController::class, $task) }}" method="POST">
            @csrf

            <div class="g-1">

                <h3>{{ $task->title }}</h3>
                <p>{{ $task->description }}</p>

                <hr>

                <div class="mb-3">
                    <label for="guests" class="form-label">{{ __('Guests') }}</label>

                    <div class="row pb-4 no-gutters row-cols-1 row-cols-md-2 row-cols-xl-3">
                        @foreach ($users as $user)
                            <div class="col text-break">
                                <input
                                    type="checkbox"
                                    name="guest[{{ $user->id }}]"
                                    value="{{ $user->id }}"
                                    class="d-inline permission m-2"
                                    @checked(($guests->contains($user->id)))
                                >
                                {{ $user->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end">

                <a href="{{ action(\App\Http\Controllers\Task\AdminTaskController::class) }}"
                    class="btn btn-outline-secondary px-5"
                >
                    <i class="fa-solid fa-reply mr-2"></i>
                    {{ __('Back') }}
                </a>

                <button type="submit" class="btn bg-amcef-green px-5 ms-2 border border-2 border-amcef-black">
                    <i class="fa-solid fa-save mr-2"></i>
                    {{ __('Save') }}
                </button>

            </div>
        </form>
    </div>
@endsection
