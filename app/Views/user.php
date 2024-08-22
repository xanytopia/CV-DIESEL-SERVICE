
<body>
            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Users
                        </h6>
                        <a href="">Show All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">Username</th>
                                    <th scope="col">Level</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                foreach ($darren as $key) { ?>
                                <tr>
                                    <td><?= $key->username ?></td>
                                    <td><?= $key->level ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="<?= base_url('home/hapususer')?>">Detail</a>
                                        <a class="btn btn-sm btn-primary" href="<?= base_url('home/hapususer')?>">Reset Password</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Recent Sales End -->

