<!-- flash message for userlogin -->
<?php  if ($this->session->flashdata('user_loggedin')) : ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i>Login</h5>
        <?php echo $this->session->flashdata('user_loggedin'); ?>
    </div>
<?php endif; ?>
<!-- flash message for insert post -->
<?php  if ($this->session->flashdata('post_inserted')) : ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i>Post Inserted</h5>
        <?php echo $this->session->flashdata('post_inserted'); ?>
    </div>
<?php endif; ?>
<!-- flash message for failed insert -->
<?php if($this->session->flashdata('resubmit_post')): ?>
                  <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i>Resubmit Post!</h5>
                    <?php echo $this->session->flashdata('resubmit_post'); ?>
                </div>
<?php endif; ?>

<!-- flash message for update success -->
<?php  if ($this->session->flashdata('post_updated')) : ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i>Post Updated</h5>
        <?php echo $this->session->flashdata('post_updated'); ?>
    </div>
<?php endif; ?>

<!-- flash message for failed update -->
<?php if($this->session->flashdata('update_failed')): ?>
        <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i>Update Failed!</h5>
        <?php echo $this->session->flashdata('update_failed'); ?>
    </div>
<?php endif; ?>

<!-- flash message for success resubmit-->
<?php  if ($this->session->flashdata('post_resubmited')) : ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i>Post Resubmited</h5>
        <?php echo $this->session->flashdata('post_resubmited'); ?>
    </div>
<?php endif; ?>

<!-- flash message for laungaue-->
<?php  if ($this->session->flashdata('Language_error')) : ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i>Select Language</h5>
        <?php echo $this->session->flashdata('Language_error'); ?>
    </div>
<?php endif; ?>

<!-- flash message for success resubmit-->
<?php  if ($this->session->flashdata('post_translated')) : ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i>Post Translated</h5>
        <?php echo $this->session->flashdata('post_translated'); ?>
    </div>
<?php endif; ?>

<!-- flash message for laungaue-->
<?php  if ($this->session->flashdata('post_translation_error')) : ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i>Translation Failed</h5>
        <?php echo $this->session->flashdata('post_translation_error'); ?>
    </div>
<?php endif; ?>

