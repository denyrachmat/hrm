<td>
    @can('attendance view')
    <a href="{{ route('attendances.show', $model->id) }}" class="btn btn-outline-success btn-sm">
        <i class="fa fa-eye"></i>
    </a>
    @endcan
</td>
