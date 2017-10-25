$(function () {
   $('input[type=file]').change(function () {
      $('form').submit();
   });
   $('table').DataTable({
       "language" : {
           "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
       }
   });
});
