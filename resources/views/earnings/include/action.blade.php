<td>
    @can('earning edit')
        <a href="{{ route('earnings.edit', $model->id) }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-pencil-alt"></i>
        </a>
    @endcan
</td>
