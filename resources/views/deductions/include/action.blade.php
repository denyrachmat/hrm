<td>

    @can('deduction edit')
        <a href="{{ route('deductions.edit', $model->id) }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-pencil-alt"></i>
        </a>
    @endcan
</td>
