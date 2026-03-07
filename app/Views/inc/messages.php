<!-- flash message for userlogin -->
<?php  if (session()->getFlashdata('user_loggedin')) : ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
        <h5><i class="icon fas fa-check"></i>Login</h5>
        <?php echo session()->getFlashdata('user_loggedin'); ?>
    </div>
<?php endif; ?>
<!-- flash message for insert post -->
<?php  if (session()->getFlashdata('post_inserted')) : ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
        <h5><i class="icon fas fa-check"></i>Post Inserted</h5>
        <?php echo session()->getFlashdata('post_inserted'); ?>
    </div>
<?php endif; ?>
<!-- flash message for failed insert -->
<?php if(session()->getFlashdata('resubmit_post')): ?>
                  <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
                  <h5><i class="icon fas fa-ban"></i>Resubmit Post!</h5>
                    <?php echo session()->getFlashdata('resubmit_post'); ?>
                </div>
<?php endif; ?>

<!-- flash message for update success -->
<?php  if (session()->getFlashdata('post_updated')) : ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
        <h5><i class="icon fas fa-check"></i>Post Updated</h5>
        <?php echo session()->getFlashdata('post_updated'); ?>
    </div>
<?php endif; ?>

<!-- flash message for failed update -->
<?php if(session()->getFlashdata('update_failed')): ?>
        <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
        <h5><i class="icon fas fa-ban"></i>Update Failed!</h5>
        <?php echo session()->getFlashdata('update_failed'); ?>
    </div>
<?php endif; ?>

<!-- flash message for success resubmit-->
<?php  if (session()->getFlashdata('post_resubmited')) : ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
        <h5><i class="icon fas fa-check"></i>Post Resubmited</h5>
        <?php echo session()->getFlashdata('post_resubmited'); ?>
    </div>
<?php endif; ?>

<!-- flash message for laungaue-->
<?php  if (session()->getFlashdata('Language_error')) : ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
        <h5><i class="icon fas fa-check"></i>Select Language</h5>
        <?php echo session()->getFlashdata('Language_error'); ?>
    </div>
<?php endif; ?>

<!-- flash message for success resubmit-->
<?php  if (session()->getFlashdata('post_translated')) : ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
        <h5><i class="icon fas fa-check"></i>Post Translated</h5>
        <?php echo session()->getFlashdata('post_translated'); ?>
    </div>
<?php endif; ?>

<!-- flash message for laungaue-->
<?php  if (session()->getFlashdata('post_translation_error')) : ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
        <h5><i class="icon fas fa-check"></i>Translation Failed</h5>
        <?php echo session()->getFlashdata('post_translation_error'); ?>
    </div>
<?php endif; ?>






