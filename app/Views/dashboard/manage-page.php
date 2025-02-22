<?php
$uri = service('uri')->getSegments();
$users = in_array('users', $uri);
// $package = in_array('package', $uri);
// $packagetype = in_array('packagetype', $uri);
// $servicepackage = in_array('servicepackage', $uri);
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
                <div class="col">
                    <a href="<?= current_url(); ?>/new" class="btn btn-primary float-end"><i class="fa-solid fa-plus me-3"></i>New <?= $manage; ?></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover dt-head-center" id="table-manage">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php if (isset($data)) : ?>
                            <?php $i = 1; ?>
                            <?php foreach ($data as $item) : ?>
                                <tr>
                                    <td><?= esc($i); ?></td>
                                    <td><?= esc($item['id']); ?></td>
                                    <?php if ($manage == 'Facility Type') : ?>
                                        <td><?= esc($item['type']); ?></td>
                                    <?php elseif ($manage == 'Package Type') : ?>
                                        <td><?= esc($item['type_name']); ?></td>
                                    <?php else : ?>
                                        <td><?= esc($item['name']); ?></td>
                                    <?php endif; ?>
                                    <td>
                                        <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info" class="btn icon btn-outline-primary mx-1" href="<?= current_url() . '/' . esc($item['id']); ?>">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </a>
                                        <?php if ($manage == 'Facility Type') : ?>
                                            <form action="<?= base_url('dashboard/facilitytype/deleteobject/') . $item['id']; ?>" method="post" class="d-inline" id="deleteForm<?= esc($item['id']) ?>">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="id" id="id" value="<?= esc($item['id']); ?>">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger mx-1" onclick="deleteObject('<?= esc($item['id']); ?>', '<?= esc($item['type']); ?>', <?= ($users) ? 'true' : 'false'; ?>)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </form>
                                        <?php elseif ($manage == 'Service') : ?>
                                            <form action="<?= base_url('dashboard/servicepackage/deleteobject/') . $item['id']; ?>" method="post" class="d-inline" id="deleteForm<?= esc($item['id']) ?>">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="id" id="id" value="<?= esc($item['id']); ?>">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger mx-1" onclick="deleteObject('<?= esc($item['id']); ?>', '<?= esc($item['name']); ?>', <?= ($users) ? 'true' : 'false'; ?>)">
                                                <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </form>
                                        <?php elseif ($manage == 'Package Type') : ?>
                                            <form action="<?= base_url('dashboard/packagetype/deleteobject/') . $item['id']; ?>" method="post" class="d-inline" id="deleteForm<?= esc($item['id']) ?>">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="id" id="id" value="<?= esc($item['id']); ?>">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger mx-1" onclick="deleteObject('<?= esc($item['id']); ?>', '<?= esc($item['type_name']); ?>', <?= ($users) ? 'true' : 'false'; ?>)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </form>
                                        <?php elseif ($manage == 'Package') : ?>
                                            <form action="<?= base_url('dashboard/package/deleteobject/') . $item['id']; ?>" method="post" class="d-inline" id="deleteForm<?= esc($item['id']) ?>">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="id" id="id" value="<?= esc($item['id']); ?>">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger mx-1" onclick="deleteObject('<?= esc($item['id']); ?>', '<?= esc($item['name']); ?>', <?= ($users) ? 'true' : 'false'; ?>)">
                                                <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </form>
                                        <?php else : ?>
                                            <!-- <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger mx-1" href="<?= current_url() . '/delete' . '/' . esc($item['id']); ?>">
                                                <i class="fa-solid fa-trash"></i>
                                            </a> -->
                                        <?php endif; ?>

                                    </td>
                                    <?php $i++ ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
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
    });
</script>
<?= $this->endSection() ?>