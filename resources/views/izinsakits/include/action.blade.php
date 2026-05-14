{{-- modal approved --}}
<div class="modal fade" id="modalApproved{{ $model->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Approved Request {{ $model->full_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('approved') }}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Date</label>
                        <input type="date" class="form-control" value="{{ $model->date }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <input type="text" class="form-control" value="{{ $model->description }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Detailed Description</label>
                        <textarea class="form-control" readonly id="" name="" rows="3" required>{{ $model->detailed_description }}
                        </textarea>
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
            <form action="{{ route('rejected') }}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Date</label>
                        <input type="date" class="form-control" value="{{ $model->date }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <input type="text" class="form-control" value="{{ $model->description }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Detailed Description</label>
                        <textarea class="form-control" readonly id="" name="" rows="3" required>{{ $model->detailed_description }}
                        </textarea>
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
        @can('izinsakit approved')
            <a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" title="Approved"
                data-bs-target="#modalApproved{{ $model->id }}">
                <i class="fa fa-check"></i>
            </a>
        @endcan

        @can('izinsakit rejected')
            <a href="#" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" title="Rejected"
                data-bs-target="#modalRejected{{ $model->id }}">
                <i class="fa fa-times"></i>
            </a>
        @endcan
    @endif
    @can('izinsakit view')
        <a href="{{ route('izinsakits.show', $model->id) }}" class="btn btn-outline-success btn-sm">
            <i class="fa fa-eye"></i>
        </a>
    @endcan
</td>
