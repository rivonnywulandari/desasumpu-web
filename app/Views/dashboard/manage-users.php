<?php
$uri = service('uri')->getSegments();
$users = in_array('users', $uri);
?>

<?= $this->extend('dashboard/layouts/main'); ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-header mb-2">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="card-title">Manage <?= $manage; ?></h3>
                </div>
            </div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#adminTab">Admin Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#customerTab">Customer Account</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="adminTab">
                    <div class="col">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adminModal">
                            <i class="fa-solid fa-plus me-3"></i>New Admin
                        </a>
                        <div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="adminModalLabel">New Admin Registration</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= base_url('dashboard/users/admin/register'); ?>" method="post">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Register Admin</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <?php if (isset($adminData) && !empty($adminData)) : ?>
                        <div class="table-responsive">
                            <table class="table table-hover dt-head-center" id="table-manage">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Fullname</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $i = 1; ?>
                                    <?php foreach ($adminData as $item) : ?>
                                        <tr>
                                            <td><?= esc($i); ?></td>
                                            <td><?= esc($item['id']); ?></td>
                                            <td><?= esc($item['username']); ?></td>
                                            <td><?= esc($item['fullname']); ?></td>
                                            <td><?= esc($item['email']); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary" title="More Info" data-bs-toggle="modal" data-bs-target="#userDetailModal<?= esc($item['id']) ?>" data-userid="<?= esc($item['id']) ?>">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                </button>
                                                <div class="modal fade" id="userDetailModal<?= esc($item['id']) ?>" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="userDetailModalLabel">User Detail</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body" id="userDetailContent<?= esc($item['id']) ?>">
                                                                <div class="col-md-12 col-12 order-md-first order-last">
                                                                    <div class="mb-4">
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <img src="<?= (!empty($item['user_image'])) ? base_url('media/photos/user/') . esc($item['user_image']) : base_url('media/photos/user/default.png'); ?>" alt="photo" class="img-fluid img-thumbnail rounded-circle">
                                                                            </div>
                                                                            <div class="col-2"></div>
                                                                            <div class="col-6">
                                                                                <br>
                                                                                <p class="fw-bold fs-5 mb-1 text-start"><?= esc($item['username']) ?></p>
                                                                                <p class="fw-bold fs-6 mb-1 text-start"><?= esc($item['fullname']) ?></p>
                                                                                <p class="mb-1 text-start">Email: <?= esc($item['email']) ?></p>
                                                                                <p class="mb-1 text-start">Address: <?= empty($item['address']) ? '<i>(Belum dilengkapi)</i>' : esc($item['address']) ?></p>
                                                                                <p class="mb-1 text-start">Phone: <?= empty($item['phone']) ? '<i>(Belum dilengkapi)</i>' : esc($item['phone']); ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <a class="btn icon btn-outline-danger mx-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" onclick="deleteUsers('<?= esc($item['id']); ?>', '<?= esc($item['username']); ?>')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a> -->
                                                <form action="<?= base_url('dashboard/users/deleteobject/') . $item['id']; ?>" method="post" class="d-inline" id="deleteForm<?= esc($item['id']) ?>">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="id" id="id" value="<?= esc($item['id']); ?>">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger mx-1" onclick="deleteObject('<?= esc($item['id']); ?>', '<?= esc($item['username']); ?>', <?= ($users) ? 'true' : 'false'; ?>)">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="tab-pane fade" id="customerTab">
                    <!-- Konten untuk Customer Account -->
                    <?php if (isset($customerData) && !empty($customerData)) : ?>
                        <div class="table-responsive">
                            <table class="table table-hover dt-head-center" id="table-manage">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Fullname</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $i = 1; ?>
                                    <?php foreach ($customerData as $item) : ?>
                                        <tr>
                                            <td><?= esc($i); ?></td>
                                            <td><?= esc($item['id']); ?></td>
                                            <td><?= esc($item['username']); ?></td>
                                            <td><?= esc($item['fullname']); ?></td>
                                            <td><?= esc($item['email']); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary" title="More Info" data-bs-toggle="modal" data-bs-target="#userDetailModal<?= esc($item['id']) ?>" data-userid="<?= esc($item['id']) ?>">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                </button>
                                                <div class="modal fade" id="userDetailModal<?= esc($item['id']) ?>" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="userDetailModalLabel">User Detail</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body" id="userDetailContent<?= esc($item['id']) ?>">
                                                                <div class="col-md-12 col-12 order-md-first order-last">
                                                                    <div class="mb-4">
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <img src="<?= (!empty($item['user_image'])) ? base_url('media/photos/user/') . esc($item['user_image']) : base_url('media/photos/user/default.png'); ?>" alt="photo" class="img-fluid img-thumbnail rounded-circle">
                                                                            </div>
                                                                            <div class="col-2"></div>
                                                                            <div class="col-6">
                                                                                <br>
                                                                                <p class="fw-bold fs-5 mb-1 text-start"><?= esc($item['username']) ?></p>
                                                                                <p class="fw-bold fs-6 mb-1 text-start"><?= esc($item['fullname']) ?></p>
                                                                                <p class="mb-1 text-start">Email: <?= esc($item['email']) ?></p>
                                                                                <p class="mb-1 text-start">Address: <?= empty($item['address']) ? '<i>(Belum dilengkapi)</i>' : esc($item['address']) ?></p>
                                                                                <p class="mb-1 text-start">Phone: <?= empty($item['phone']) ? '<i>(Belum dilengkapi)</i>' : esc($item['phone']); ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="btn icon btn-outline-danger mx-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" onclick="deleteUsers('<?= esc($item['id']); ?>', '<?= esc($item['username']); ?>')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    $(document).ready(function() {
        $('#table-manage').DataTable({
            columnDefs: [{
                targets: ['_all'],
                className: 'dt-head-center'
            }],
            lengthMenu: [5, 10, 20, 50, 100]
        });

        $('.btn-outline-primary').on('click', function() {
            var userId = $(this).data('userid');
            $.ajax({
                url: '<?= base_url('api/users/') ?>' + userId,
                type: 'GET',
                success: function(response) {
                    $('#userDetailContent' + userId).html(response);
                    $('#userDetailModal' + userId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.3/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>