<td>
    <a href="{{ route('view-detail', $model->id) }}" title="View Detail"
        class="btn btn-outline-secondary btn-sm" title="Slip">
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('slip-employees', $model->id) }}" target="_blank" title="Slip Gaji"
        class="btn btn-outline-success btn-sm" title="Slip">
        <i class="fa fa-file"></i>
    </a>

    <button type="button" class="btn btn-outline-info btn-sm" title="Send Email" data-bs-toggle="modal"
        data-bs-target="#emailConfirmationModal"
        onclick="openEmailModal('{{ $model->id }}', '{{ $model->full_name }}', '{{ $model->period }}')">
        <i class="fa fa-envelope"></i>
    </button>
</td>

<!-- Single Modal -->
<div class="modal fade" id="emailConfirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('sendMailSalary') }}" method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Email Salary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modelId" name="salary_id">
                    <input type="text" class="form-control" placeholder="Title" id="title" name="title"
                        value="" required>
                    <br>
                    <textarea id="emailBody" name="email_body" required rows="10" class="form-control"
                        placeholder="Enter email body..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="sendButton" type="submit" class="btn btn-primary">Send Email</button>
                </div>
            </div>
        </form>

    </div>
</div>
