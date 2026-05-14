{{-- modal approved --}}
<div class="modal fade" id="modalApproved{{ $model->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Approved Request {{ $model->full_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('attendance-revisions.approved') }}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Date</label>
                        <input type="date" class="form-control" value="{{ \Carbon\Carbon::parse($model->date)->format('Y-m-d') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Reason</label>
                        <input type="text" class="form-control" value="{{ $model->reason }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Catatan</label>
                        <input type="hidden" name="id" id="id" value="{{ $model->id }}">
                        <input type="hidden" name="status" id="status" value="Approved">
                        <textarea class="form-control" id="catatan" name="catatan" rows="3" required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Approved</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal rejected --}}
<div class="modal fade" id="modalRejected{{ $model->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rejected Request {{ $model->full_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('attendance-revisions.rejected') }}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Date</label>
                        <input type="date" class="form-control" value="{{ \Carbon\Carbon::parse($model->date)->format('Y-m-d') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Reason</label>
                        <input type="text" class="form-control" value="{{ $model->reason }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Catatan</label>
                        <input type="hidden" name="id" id="id" value="{{ $model->id }}">
                        <input type="hidden" name="status" id="status" value="Rejected">
                        <textarea class="form-control" id="catatan" name="catatan" rows="3" required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Rejected</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<td>
    @if ($model->status == 'Waiting')
        @can('attendance revision approved')
            <a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" title="Approved"
                data-bs-target="#modalApproved{{ $model->id }}">
                <i class="fa fa-check"></i>
            </a>
        @endcan

        @can('attendance revision rejected')
            <a href="#" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" title="Rejected"
                data-bs-target="#modalRejected{{ $model->id }}">
                <i class="fa fa-times"></i>
            </a>
        @endcan
    @endif

    @can('attendance revision view')
    <a href="{{ route('attendance-revisions.show', $model->id) }}" class="btn btn-outline-success btn-sm">
        <i class="fa fa-eye"></i>
    </a>
    @endcan

    @can('attendance revision edit')
        <a href="{{ route('attendance-revisions.edit', $model->id) }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-pencil-alt"></i>
        </a>
    @endcan

    @can('attendance revision delete')
        <form action="{{ route('attendance-revisions.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-outline-danger btn-sm">
                <i class="ace-icon fa fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>
