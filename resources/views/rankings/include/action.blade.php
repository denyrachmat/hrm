<td>
    <button type="button" class="btn btn-success open-modal-btn" data-modal-target="#myModal" data-id="{{ $model->id }}"
        data-name="{{ $model->full_name }}">
        <i class="fa fa-eye"></i> Detail
    </button>
</td>

<script>
    $(document).ready(function() {
        $(".open-modal-btn").click(function() {
            var targetModal = $(this).data("modal-target");
            var id = $(this).data("id");
            var name = $(this).data("name");
            var startDate = $("#start_date").val();
            var endDate = $("#end_date").val();

            // Ajax Request
            $.ajax({
                type: "POST",
                url: "/detailPoint",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {
                    id: id,
                    name: name,
                    start_date: startDate,
                    end_date: endDate,
                },
                success: function(response) {
                    $("#modalBody").html(response);
                    $(targetModal).modal("show");
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });
</script>
