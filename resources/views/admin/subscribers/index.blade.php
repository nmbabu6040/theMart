@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid py-4">
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Newsletter Subscribers</h6>

                            <!-- Single Page Tab Navigation -->
                            <div>
                                <a href="{{ route('subscribers.index', ['tab' => 'active']) }}"
                                    class="btn btn-sm {{ $tab == 'active' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Active ({{ $activeCount }})
                                </a>
                                <a href="{{ route('subscribers.index', ['tab' => 'trash']) }}"
                                    class="btn btn-sm {{ $tab == 'trash' ? 'btn-danger' : 'btn-outline-danger' }}">
                                    Trash ({{ $trashCount }})
                                </a>
                            </div>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            @if (session('success'))
                                <div class="alert alert-success mx-4">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                #
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Email</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ $tab == 'trash' ? 'Deleted At' : 'Subscribed At' }}
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($subscribers as $subscriber)
                                            <tr>
                                                <td class="ps-4">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $subscribers->firstItem() + $loop->index }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $subscriber->email }}</p>
                                                </td>
                                                <td>
                                                    <span class="text-xs font-weight-bold">
                                                        {{ ($tab == 'trash' ? $subscriber->deleted_at : $subscriber->created_at)->format('d M, Y - h:i A') }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    @if ($tab == 'trash')
                                                        <!-- Restore Button -->
                                                        <a href="{{ route('subscribers.restore', $subscriber->id) }}"
                                                            class="btn btn-sm btn-success mb-0">Restore</a>

                                                        <!-- Permanent Delete -->
                                                        <form
                                                            action="{{ route('subscribers.forceDelete', $subscriber->id) }}"
                                                            method="POST" onsubmit="return confirm('Permanently delete?');"
                                                            style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger mb-0">Force
                                                                Delete</button>
                                                        </form>
                                                    @else
                                                        <!-- Soft Delete -->
                                                        <form action="{{ route('subscribers.destroy', $subscriber->id) }}"
                                                            method="POST" onsubmit="return confirm('Move to trash?');"
                                                            style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-warning mb-0">Move
                                                                Trash</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <p class="text-xs text-muted mb-0">No subscribers found in
                                                        {{ $tab }}.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="px-4 pt-3">
                                {{ $subscribers->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
