<!doctype html>

<html lang="en">

<?php $this->load->view('main/head') ?>

<body>

<div class="jumbotron text-center">
    <h1>Users List</h1>
</div>

<div class="container">
    <?php if ($arr = $this->session->flashdata('result')) : ?>
        <div class="alert alert-success" role="alert">
            <?= $arr ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($users) : ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <th scope="row"><?= $user['id'] ?></th>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['email'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="3">No results</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


</body>
</html>

