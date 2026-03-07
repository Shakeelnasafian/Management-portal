<form action="<?php echo BASE_URL . 'operations/operations-filters' ?>" method="post">
    <div class="row">

        <div class="col-md-6">
            <input type="text" class="form-control" name="post_title" placeholder="Search By Title" autocomplete="off">
        </div>
        <div class="col-md-2">
            <input type="number" class="form-control" name="author_id" placeholder="User ID" autocomplete="off">
        </div>

        <div class="col-md-2">
            <input type="date" class="form-control" name="publish_date" placeholder="Select Date" autocomplete="off">
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-dark">Filter</button>
        </div>
    </div>

</form>




