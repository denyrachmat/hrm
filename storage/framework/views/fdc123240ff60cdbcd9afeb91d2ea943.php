<?php $__env->startSection('title', __('Dashboard')); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-md-12">
                <?php if(session('status')): ?>
                    <div class="alert alert-success alert-dismissible show fade">
                        <?php echo e(session('status')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <h4>Hi 👋, <?php echo e(auth()->user()->name); ?></h4>
                        <p><?php echo e(__('You are logged in!')); ?></p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="row g-3">
                                    <div class="col-md-4 mb-3">
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="addon-wrapping"><i
                                                    class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control" aria-describedby="addon-wrapping"
                                                id="daterange-btn" value="">
                                            <input type="hidden" name="start_date" id="start_date"
                                                value="<?php echo e($microFrom); ?>">
                                            <input type="hidden" name="end_date" id="end_date"
                                                value="<?php echo e($microTo); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="row text-center">
                                <div class="col-md-4 mt-3">
                                    <div class="card border">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Izin Sakit</h5>
                                            <h6 class="card-subtitle mb-2 text-muted" id="izin-sakit-total"></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="card border">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Attendance Revisions</h5>
                                            <h6 class="card-subtitle mb-2 text-muted" id="attendance-revisions-total"></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="card border">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Leave Requests</h5>
                                            <h6 class="card-subtitle mb-2 text-muted" id="leave-requests-total"></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="card border">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Izin Sakit</h5>
                                            <canvas class="mb-2" id="izinSakitChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Attendance Revisions</h5>
                                            <canvas class="mb-2" id="attendanceRevisionsChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Leave Requests</h5>
                                            <canvas class="mb-2" id="leaveRequestChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12 my-3">
                            <h6 class="card-title my-3 text-center">Employee Attendance Mapping</h6>
                            <hr>
                            <div class="col-md-3 mb-3">
                                <label for="tanggalInput" class="form-label">Select Date:</label>
                                <input type="date" class="form-control" id="tanggalInput" name="tanggalInput">
                            </div>
                            <div id="map" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12 my-3">
                            <h6 class="card-title my-3 text-center">Employee End Contract Date Less Than 90 Days</h6>
                            <hr>
                            <div class="table-responsive py-1">
                                <table class="table table-striped" id="data-table-end-contract" width="100%">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Employee')); ?></th>
                                            <th><?php echo e(__('End Contract Date')); ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.css" />
    <link href="<?php echo e(asset('mazer/css/daterangepicker.min.css')); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo e(asset('mazer/js/moment.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('mazer/js/daterangepicker.min.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([-6.2088, 106.8456], 8); // Set initial map view

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var markersData = []; // Variabel untuk menyimpan data marker

            // Function untuk membuat marker pada peta
            function createMarker(map, position, popupContent) {
                var marker = L.marker(position).addTo(map);
                marker.bindPopup(popupContent);
                return marker;
            }


            // Function untuk memperbarui peta berdasarkan tanggal
            function updateMapByDate(selectedDate) {
                // Hapus semua marker yang ada pada peta
                map.eachLayer(function(layer) {
                    if (layer instanceof L.Marker) {
                        map.removeLayer(layer);
                    }
                });

                // Buat permintaan AJAX untuk mendapatkan data marker berdasarkan tanggal
                fetch('/api/markers?tanggal=' + selectedDate)
                    .then(response => response.json())
                    .then(newMarkers => {
                        // Update markersData dengan data marker baru
                        markersData = newMarkers;
                        markersData.forEach(function(marker) {
                            // Pemeriksaan kondisi untuk nilai latitude dan longitude yang tidak null
                            if (marker.latitude !== "null" && marker.longitude !== "null") {
                                var position = [parseFloat(marker.latitude), parseFloat(marker
                                    .longitude)];
                                var popupContent =
                                    `<strong>${marker.full_name}</strong><br>
                                        Latitude: ${marker.latitude}<br>
                                        Longitude: ${marker.longitude}<br>
                                        Date: ${marker.date}<br>
                                        Time: ${marker.clock_in}<br>
                                        Status: ${marker.description}`;
                                createMarker(map, position, popupContent);
                            }
                        });

                    })
                    .catch(error => console.error('Error fetching markers:', error));
            }

            // Event listener untuk perubahan tanggal
            var tanggalInput = document.getElementById('tanggalInput');
            tanggalInput.addEventListener('change', function() {
                var selectedDate = this.value;
                updateMapByDate(selectedDate);
            });

            var currentDate = new Date();
            var options = {
                timeZone: 'Asia/Jakarta'
            };
            var year = currentDate.toLocaleDateString('en-US', options).split('/')[2];
            var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
            var day = ('0' + currentDate.getDate()).slice(-2);
            var defaultDate = year + '-' + month + '-' + day;
            tanggalInput.value = defaultDate;
            updateMapByDate(defaultDate);
        });
    </script>


    <script>
        let izinSakit;
        let attendanceRevisions;
        let leaveRequests;
        window.chart = {}

        $('#daterange-btn').on('change', function() {
            $.ajax({
                url: "<?php echo e(route('dashboard')); ?>",
                type: "GET",
                data: {
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val()
                },
                success: function(data) {
                    izinSakit = data.izinSakit;
                    attendanceRevisions = data.attendanceRevisions;
                    leaveRequests = data.leaveRequests;

                    // Update the totals
                    $('#izin-sakit-total').text(izinSakit.total + ' Data');
                    $('#attendance-revisions-total').text(attendanceRevisions.total + ' Data');
                    $('#leave-requests-total').text(leaveRequests.total + ' Data');

                    // Create the charts
                    const izinSakitData = [izinSakit.waiting, izinSakit.approved, izinSakit.rejected];
                    const attendanceRevisionsData = [attendanceRevisions.waiting, attendanceRevisions
                        .approved, attendanceRevisions.rejected
                    ];
                    const leaveRequestsData = [leaveRequests.waiting, leaveRequests.approved,
                        leaveRequests.rejected
                    ];

                    createChart('izinSakitChart', izinSakitData, 'Izin Sakit');
                    createChart('attendanceRevisionsChart', attendanceRevisionsData,
                        'Attendance Revisions');
                    createChart('leaveRequestChart', leaveRequestsData, 'Leave Requests');
                }
            })
        });

        function createChart(elementId, data, label) {
            const ctx = document.getElementById(elementId);
            const existingMessage = ctx.parentNode.querySelector('.no-data-message');
            if (existingMessage) {
                existingMessage.remove();
            }
            if (data.every(item => item === 0 || item === null)) {
                const message = document.createElement('h6');
                message.textContent = "0 Data";
                message.className = "card-subtitle text-muted no-data-message";
                ctx.parentNode.insertBefore(message, ctx);
                return;
            }

            if (window.chart[label.replaceAll(' ', '_')]) {
                window.chart[label.replaceAll(' ', '_')].destroy()
            }

            window.chart[label.replaceAll(' ', '_')] = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Waiting', 'Approved', 'Rejected'],
                    datasets: [{
                        label: label,
                        data: data, // Use the data argument here
                        backgroundColor: [
                            'rgb(255, 205, 86)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 99, 132)'
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    aspectRatio: 1.5,
                    responsive: true,
                }
            });
        }
    </script>

    <script>
        // Data Table End Contract Less Then 90 Days
        let dataEmployeesEndContractLessThen90Days = <?php echo json_encode($employeesEndContractLessThen90Days, 15, 512) ?>;
        let columnsEmployeesEndContractLessThen90Days = [{
                data: 'full_name',
                name: 'full_name'
            },
            {
                data: 'end_contract_date',
                name: 'end_contract_date'
            },
        ];

        var table = $('#data-table-end-contract').DataTable({
            data: dataEmployeesEndContractLessThen90Days,
            columns: columnsEmployeesEndContractLessThen90Days
        });
    </script>

    <script>
        var start = <?php echo e($microFrom); ?>

        var end = <?php echo e($microTo); ?>

        var label = '';
        $('#daterange-btn').daterangepicker({
                locale: {
                    format: 'DD MMM YYYY'
                },
                startDate: moment(start),
                endDate: moment(end),
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                        'month')],
                },
            },
            function(start, end, label) {
                $('#start_date').val(Date.parse(start));
                $('#end_date').val(Date.parse(end));
                if (isDate(start)) {
                    $('#daterange-btn span').html(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
                }
            });

        function isDate(val) {
            return Date.parse(val);
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project\Backend\hrm\resources\views/dashboard.blade.php ENDPATH**/ ?>