<div class="card-body">

    <?php if (session()->getFlashdata('error-message')) : ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            <?php echo session()->getFlashdata('error-message'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('user_loggedin')) : ?>
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
            <h5><i class="icon fas fa-info"></i> Alert!</h5>
            Info alert preview. This alert is dismissable.
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('user_loggedin')) : ?>
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
            Warning alert preview. This alert is dismissable.
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success-message')) : ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
            <h5><i class="icon fas fa-check"></i> Alert!</h5>
            <?php echo session()->getFlashdata('success-message'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('campaign-success')) : ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
            <h5><i class="icon fas fa-check"></i> Alert!</h5>
            <?php echo session()->getFlashdata('campaign-success'); ?>
        </div>
    <?php endif; ?>


    <?php if (session()->getFlashdata('campaign-error')) : ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            <?php echo session()->getFlashdata('campaign-error'); ?>
        </div>
    <?php endif; ?>



</div>




