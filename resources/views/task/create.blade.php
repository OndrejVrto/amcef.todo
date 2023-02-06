@extends('layouts.app')

@section('content')
    <div class="col-lg-10 col-xl-9 mx-auto">
        <h2 class="text-end">Create new task</h2>

        <form action="{{ action(\App\Http\Controllers\Task\StoreTaskController::class) }}" method="POST">
            @csrf

            <div class="g-1">

                <div class="mb-3">
                    <label for="title" class="form-label">{{ __('Task title') }}</label>
                    <input
                        name="title"
                        type="text"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}"
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">

                    <div class="col-lg-6">
                        <label for="status" class="form-label">{{ __('Task Status') }}</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option></option>
                            @foreach ($taskStatuses as $taskStatus)
                                <option value="{{ $taskStatus->value }}" @selected(old('status') == $taskStatus->value)>
                                    {{ $taskStatus->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6">
                        <label for="deadline_until" class="form-label">{{ __('Deadline') }}</label>
                        <input
                            name="deadline_until"
                            type="date"
                            class="form-control @error('deadline_until') is-invalid @enderror"
                            value="{{ old('deadline_until') }}"
                        >
                        @error('deadline_until')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="categories" class="form-label">{{ __('Categories') }}</label>
                    <select name="categories[]" multiple size="5" class="form-select @error('categories') is-invalid @enderror">
                        <option value=""></option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((collect(old('categories'))->contains($category->id)))>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('categories')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="mt-3 d-flex justify-content-end">

                <a href="{{ action(\App\Http\Controllers\Task\AdminTaskController::class) }}" class="btn btn-outline-secondary px-5">
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
