<td>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-gear"></i>
        </button>
        <ul class="dropdown-menu">
            @can('employee view')
                <li>
                    <a href="{{ route('employees.show', $model->id) }}" class="dropdown-item">Detail</a>
                </li>
            @endcan
            @can('employee edit')
                <li>
                    <a href="{{ route('employees.edit', $model->id) }}" class="dropdown-item">Edit</a>
                </li>
            @endcan
            {{-- @can('reset device') --}}
            <li>
                <form action="{{ route('resetDevice', $model->id) }}" method="post" class="d-inline"
                    onsubmit="return confirm('Are you sure to Reset Device for this employee?')">
                    @csrf
                    @method('delete')
                    <button class="dropdown-item">Reset Device</button>
                </form>
            </li>
            {{-- @endcan --}}
            @can('employee delete')
                <li>
                    <form action="{{ route('employees.destroy', $model->id) }}" method="post" class="d-inline"
                        onsubmit="return confirm('Are you sure to delete this record?')">
                        @csrf
                        @method('delete')
                        <button style="color: red" class="dropdown-item"><i  class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                    </form>
                </li>
            @endcan

        </ul>
    </div>
</td>
