@extends('layouts.app')

@section('content')

    @forelse ($unreadNotifications as $notification)
        <div class="alert alert-amcef-green" role="alert">

            <span class="me-3">[{{ $notification->created_at }}]</span>
            {{ __('Task') }}
            "<span class="fw-bolder">{{ $notification->data['title'] }}</span>"
            @switch($notification->type)
                @case('App\Notifications\TaskDoneNotification')
                    {{ __('is done') }}.
                    <a href="{{ $notification->data['url'] }}"
                        class="ms-4"
                        title="__('Visit detail')"
                    >
                        {{ __('Visit detail') }}
                    </a>
                    @break
                @case('App\Notifications\TaskShareNotification')
                    {{ __('is sharing with you!') }}
                    <a href="{{ $notification->data['url'] }}"
                        class="ms-4"
                        title="__('Visit detail')"
                    >
                        {{ __('Visit detail')}}
                    </a>
                    @break
                @case('App\Notifications\TaskUnshareNotification')
                    {{ __('is no longer shared by you.') }}
                    @break
                @default
            @endswitch

            <a href="#" class="float-end mark-as-read text-amcef-black" data-id="{{ $notification->id }}">
                {{ __('Mark as read') }}
            </a>
        </div>
        @if($loop->last)
            <a href="#" id="mark-all" class="btn btn-amcef-green border border-2 border-amcef-black mb-5">
                {{ __('Mark all as read') }}
            </a>
        @endif
    @empty
    @endforelse

    <form action="{{ action(\App\Http\Controllers\Task\AdminTaskController::class, request()->query->all()) }}">
        <div class="row g-1">
            <div class="col-lg-10">
                <row class="row g-1">
                    <div class="col-lg-4">
                        <label for="sorting" class="form-label">{{ __('Sort By') }}</label>
                        <select name="sorting" class="form-select">
                            <option></option>
                            <option @selected($filterSorting == "title") value="title">{{ __('Title') }}</option>
                            <option @selected($filterSorting == "deadline") value="deadline">{{ __('Deadline') }}</option>
                            <option @selected($filterSorting == "status") value="status">{{ __('Task status') }}</option>
                            <option @selected($filterSorting == "status_deadline") value="status_deadline">{{ __('Task status and deadline') }}</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label for="owner-type" class="form-label">{{ __('User type') }}</label>
                        <select name="owner-type" class="form-select">
                            <option></option>
                            @foreach ($ownerTypes as $ownerType)
                                <option value="{{ $ownerType->value }}" @selected($filterOwnerType == $ownerType->value)>
                                    {{ $ownerType->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="task-status" class="form-label">{{ __('Task Status') }}</label>
                        <select name="task-status" class="form-select">
                            <option></option>
                            @foreach ($taskStatuses as $taskStatus)
                                <option value="{{ $taskStatus->value }}" @selected($filterTaskStatuse == $taskStatus->value)>
                                    {{ $taskStatus->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="category" class="form-label">{{ __('Category') }}</label>
                        <select name="category" class="form-select">
                            <option></option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($filterCategory == $category->id)>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </row>
            </div>

            <div class="col-lg-2 d-flex align-items-end justify-content-end mt-3">
                <a href="{{ action(\App\Http\Controllers\Task\AdminTaskController::class) }}" class="btn btn-amcef-black me-2">{{ __('Reset') }}</a>
                <button type="submit" class="btn btn-amcef-green border border-2 border-amcef-black">{{ __('Filter') }}</button>
            </div>
        </div>
    </form>

    <div class="mt-4">
        <a href="{{ action(\App\Http\Controllers\Task\CreateTaskController::class) }}"
            class="btn btn-amcef-green border border-2 border-amcef-black"
        >
            {{ __('Add new task') }}
        </a>

        <table class="table table-hover align-middle table-striped my-4">
            <thead>
                <tr class="table-amcef-green">
                    {{-- <th scope="col" width="1%"></th> --}}
                    <th scope="col" width="1%"></th>
                    {{-- <th scope="col" class="text-center" width="5%">Status</th> --}}
                    <th scope="col" width="15%">{{ __('Title') }}</th>
                    <th scope="col" class="d-none d-xl-table-cell" width="30%">{{ __('Description') }}</th>
                    <th scope="col" class="d-none d-md-table-cell" width="10%">{{ __('Deadline') }}</th>
                    <th scope="col" class="d-none d-xl-table-cell" width="12%">{{ __('Categories') }}</th>
                    <th scope="col" colspan="4" width="1%"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                    <tr title="{{ $task->status->label() }}">
                        {{-- <td>
                            {{ $task->id }}
                        </td> --}}
                        <td>
                            <i class="{{ $task->status->icon() }}"></i>
                        </td>
                        {{-- <td class="small text-center">
                            {{ $task->status->label() }}
                        </td> --}}
                        <td class="small fw-bolder">
                            {{ $task->title }}
                        </td>
                        <td class="text-wrap d-none d-xl-table-cell text-break small">
                            {{ $task->cropDescription }}
                        </td>
                        <td class="d-none d-md-table-cell small">
                            {{-- {{ $task->deadline_until }} --}}
                            {{ $task->deadlineForHuman }}
                        </td>
                        <td class="text-wrap d-none d-xl-table-cell text-break small">
                            @foreach ($task->categories as $category)
                                <span
                                    @class([
                                        'ms-1 mb-1 badge text-amcef-black',
                                        'bg-warning' => $filterCategory === $category->id,
                                        'bg-amcef-green' => $filterCategory !== $category->id,
                                    ])
                                >
                                    {{ $category->title }}
                                </span>
                            @endforeach
                        </td>

                        @if ($task->isGuest)
                            <td class="text-start">
                                <div class="d-inline-flex">
                                    <a href="{{ action(\App\Http\Controllers\Task\DetailTaskController::class, $task) }}"
                                        class="w35 me-1 btn btn-outline-success btn-sm btn-flat"
                                        title="Show task detail"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        @else
                            @if (null === $task->deleted_at)
                                <td class="text-start">
                                    <div class="d-inline-flex">
                                        <a href="{{ action(\App\Http\Controllers\Task\DetailTaskController::class, $task) }}"
                                            class="w35 me-1 btn btn-outline-success btn-sm btn-flat"
                                            title="Show task detail"
                                        >
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ action(\App\Http\Controllers\Task\ShareTaskController::class, $task) }}"
                                            class="w35 me-1 btn btn-outline-amcef-black btn-sm btn-flat"
                                            title="Share this Task"
                                        >
                                            <i class="fa-solid fa-handshake"></i>
                                        </a>
                                        <a href="{{ action(\App\Http\Controllers\Task\EditTaskController::class, $task) }}"
                                            class="w35 me-1 btn btn-outline-primary btn-sm btn-flat"
                                            title="Edit task"
                                        >
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <a href="{{ action(\App\Http\Controllers\Task\DeleteTaskController::class, $task) }}"
                                            class="w35 me-1 btn btn-outline-danger btn-sm btn-flat"
                                            title="Delete task"
                                        >
                                            <i class="fa-regular fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            @else
                                <td class="text-center">
                                    <div class="d-inline-flex">
                                        <a href="{{ action(\App\Http\Controllers\Task\RestoreTaskController::class, $task) }}"
                                            class="w35 me-1 btn btn-outline-success btn-sm btn-flat"
                                            title="Restore task"
                                        >
                                            <i class="fa-regular fa-thumbs-up"></i>
                                        </a>
                                        <a href="{{ action(\App\Http\Controllers\Task\ForceDeleteTaskController::class, $task) }}"
                                            class="w35 me-1 btn btn-outline-danger btn-sm btn-flat"
                                            title="Hard Detete task"
                                        >
                                            <i class="fa-regular fa-thumbs-down"></i>
                                        </a>
                                    </div>
                                </td>
                            @endif

                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="20">
                            {{ __('No results after filtering.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection


@section('scripts')
<script>
    function sendMarkRequest(id = null) {
        return $.ajax("{{ action(\App\Http\Controllers\MarkNotificationController::class) }}", {
            method: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id
            }
        });
    }

    $(function() {
        $('.mark-as-read').click(function() {
            let request = sendMarkRequest($(this).data('id'));

            request.done(() => {
                $(this).parents('div.alert').remove();
                if ($('div.alert').length == 0) {
                    $('#mark-all').remove();
                }
            });
        });

        $('#mark-all').click(function() {
            let request = sendMarkRequest();

            request.done(() => {
                $('div.alert').remove();
                $('#mark-all').remove();
            })
        });
    });
</script>
@endsection
