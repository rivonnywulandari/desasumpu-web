<?= $this->extend('dashboard/layouts/main'); ?>

<?= $this->section('content') ?>
<section class="section">

    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="card-title"><?= $title; ?></h3>
                </div>
                <div class="col">
                    <a href="<?= base_url('dashboard/sumpu/edit'); ?>/<?= esc($data['id']); ?>" class="btn btn-primary float-end"><i class="fa-solid fa-pencil me-3"></i>Edit Information</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-12 order-md-first order-last">
                    <div class="mb-5">
                        <p class="text-primary mb-2">Name</p>
                        <p class="fs-5"><?= esc($data['name']); ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="text-primary mb-2">Type of Tourism</p>
                        <p class="fs-5"><?= esc($data['type_of_tourism']); ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="text-primary mb-2">Address</p>
                        <p class="fs-5"><?= esc($data['address']); ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="text-primary mb-2">Open</p>
                        <p class="fs-5"><?= esc($data['open']); ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="text-primary mb-2">Close</p>
                        <p class="fs-5"><?= esc($data['close']); ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="text-primary mb-2">Ticket Price</p>
                        <p class="fs-5"><?= esc($data['ticket_price']); ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="text-primary mb-2">Contact Person</p>
                        <p class="fs-5"><?= esc($data['contact_person']); ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="text-primary mb-2">Bank Name</p>
                        <p class="fs-5"><?= esc($data['bank_name']); ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="text-primary mb-2">Bank Code</p>
                        <p class="fs-5"><?= esc($data['bank_code']); ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="text-primary mb-2">Bank Account Holder Name</p>
                        <p class="fs-5"><?= esc($data['bank_account_holder']); ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="text-primary mb-2">Bank Account Number</p>
                        <p class="fs-5"><?= esc($data['bank_account_number']); ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-12 order-md-last order-first mb-5">
                    <p class="text-primary mb-2">Gallery</p>
                    <div class="row gallery" data-bs-toggle="modal" data-bs-target="#galleryModal">
                        <?php $i = 0; ?>
                        <?php foreach ($data['gallery'] as $g) : ?>
                            <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-2 mb-md-2 mb-2">
                                <a href="#">
                                    <img class="w-100 active" src="<?= base_url('media/photos/' . $folder . '/' . esc($g));
                                                                    ?>" data-bs-target="#Gallerycarousel" data-bs-slide-to="<?= esc($i); ?>" />
                                </a>
                            </div>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-md-6 col-12 order-md-last order-first mb-5">
                    <p class="text-primary mb-2">QR Code</p>
                    <div class="row gallery" data-bs-toggle="modal" data-bs-target="#qrModal">
                        <?php if ($data['qr_url'] != null) : ?>
                            <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-2 mb-md-2 mb-2">
                                <a href="#">
                                    <img class="w-100 active" src="<?= base_url('media/photos/sumpu/' . $data['qr_url']); ?>"" data-bs-target="#Qrcarousel" />
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="galleryModalTitle">
                        Our Gallery
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="Gallerycarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <?php $i = 0; ?>
                            <?php foreach ($data['gallery'] as $x) : ?>
                                <button type="button" data-bs-target="#Gallerycarousel" data-bs-slide-to="<?= esc($i); ?>" class="<?= ($i == 0) ? 'active' : ''; ?>"></button>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="carousel-inner">
                            <?php $i = 0; ?>
                            <?php foreach ($data['gallery'] as $g) : ?>
                                <div class="carousel-item<?= ($i == 0) ? ' active' : ''; ?>">
                                    <img class="d-block w-100" src="<?= base_url('media/photos/' . $folder . '/' . esc($g)); ?>">
                                </div>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </div>
                        <a class="carousel-control-prev" href="#Gallerycarousel" role="button" type="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#Gallerycarousel" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalTitle">
                        Our QR
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="Qrcarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <?php if ($data['qr_url'] != null) : ?>
                                <button type="button" data-bs-target="#Qrcarousel" ></button>
                            <?php endif; ?>
                        </div>
                        <div class="carousel-inner">
                        <?php if ($data['qr_url'] != null) : ?>
                                <div class="carousel-item<?= ($data['qr_url']) ? ' active' : ''; ?>">
                                    <img class="d-block w-100" src="<?= base_url('media/photos/sumpu/' . $data['qr_url']); ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                        <a class="carousel-control-prev" href="#Qrcarousel" role="button" type="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#Qrcarousel" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

</section>
<?= $this->endSection() ?>