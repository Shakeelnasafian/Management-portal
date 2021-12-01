$(document).ready(function() {

$(function() {
    // Summernote
    $('.textarea').summernote();

   //Initialize Select2 Elements
   $('.select2').select2();

   //Initialize Select2 Elements
   $('.select2bs4').select2({
       theme: 'bootstrap4'
   });

   $("#datetimepicker").datetimepicker({
       
   });

   $("#website_links").focusout(function() {
    var input = $(this);
    var val = input.val();
    if (val && !val.match(/^https([s]?):\/\/.*/)) {
        input.val('http://' + val);
    }
  
  });


});//function ends

    
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#'+activeTab).children('a').addClass("active")
        $('#'+activeTab).addClass('menu-open');

    }

});//ready function ends here

$(document).on('click','.nav-item', function(e) {
    localStorage.setItem('activeTab', $(this).attr("id"));


    $(this).children('.sub-child');
});

