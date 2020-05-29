<!doctype html>

<html lang="en">

<?php $this->load->view('main/head') ?>

<body>

<div class="jumbotron text-center">
    <h1>Registration Form</h1>
</div>

<div class="container">
    <?php if ($arr = $this->session->flashdata('result')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $arr ?>
        </div>
    <?php endif; ?>

   <?php $old = $this->session->flashdata('old'); ?>

    <div class="row">
        <div class="col-sm-6">
            <form action="<?= base_url('/') ?>" method="post" id="register_form">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input name="username"
                           type="text"
                           class="form-control"
                           placeholder="Enter username"
                           id="username"
                           value="<?= $old && isset($old['username']) ? $old['username'] : '' ?>"
                           required
                    >
                </div>
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input name="email"
                           type="email"
                           class="form-control"
                           placeholder="Enter email"
                           id="email"
                           value="<?= $old && isset($old['email']) ? $old['email'] : '' ?>"
                           required
                    >
                </div>
                <div class="g-recaptcha" data-sitekey="<?= $recaptcha_site_key ?>"></div>
                <br/>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script src="<?= $recaptcha_api_url ?>" async defer></script>

<script>
    // validating captcha on client side
    document.getElementById("register_form").addEventListener("submit",function(evt)
    {
        var response = grecaptcha.getResponse();
        if(response.length == 0)
        {
            //reCaptcha not verified
            alert("Please verify you are a human!");
            evt.preventDefault();
            return false;
        }
    });
</script>

</body>
</html>

