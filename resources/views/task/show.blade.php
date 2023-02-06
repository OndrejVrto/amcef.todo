@extends('layouts.app')

@section('content')
    <div class="col-lg-10 col-xl-9 mx-auto">
        <h2 class="text-end">Detail task</h2>

        <div class="g-1">

            <div class="mb-3">
                <label for="title" class="form-label">{{ __('Task title') }}</label>
                <input
                    type="text"
                    disabled
                    class="form-control"
                    value="{{ $task->title }}"
                >
            </div>

            <div class="row mb-3">

                <div class="col-lg-6">
                    <label for="status" class="form-label">{{ __('Task Status') }}</label>

                    <input
                        type="text"
                        disabled
                        class="form-control"
                        value="{{ $task->status->value }}"
                    >
                </div>

                <div class="col-lg-6">
                    <label for="deadline_until" class="form-label">{{ __('Deadline') }}</label>
                    <input
                        type="date"
                        disabled
                        class="form-control"
                        value="{{ $task->deadline_until->format('Y-m-d') }}"
                    >
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">{{ __('Description') }}</label>
                <textarea disabled name="description" rows="3" class="form-control">{{ $task->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="categories" class="form-label">{{ __('Categories') }}</label>
                <select name="categories[]" multiple size="5" disabled class="form-select">
                    @foreach ($categories as $category)
                        <option
                            @selected( in_array($category->id, old("categories") ?: []) OR in_array($category->id, $selectedCategories) )
                        >
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="mt-3 d-flex justify-content-end">
            <a href="{{ action(\App\Http\Controllers\Task\AdminTaskController::class) }}"
                class="btn btn-outline-secondary px-5"
            >
                <i class="fa-solid fa-reply me-0"></i>
                {{ __('Back') }}
            </a>
        </div>
    </div>
@endsection
