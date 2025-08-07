$(document).ready(function() {
  $('#dataTable').DataTable({
      responsive: true,
      scrollX: true,  // Aktifkan scroll horizontal
      scrollCollapse: true,
      fixedColumns: {
          left: 1,    // Kolom pertama (nama cover) tetap terlihat
          right: 1    // Kolom terakhir (aksi) tetap terlihat
      },
      dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
           "<'row'<'col-sm-12'tr>>" +
           "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      language: {
          lengthMenu: "Tampilkan _MENU_ entri",
          search: "Cari:",
          info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
          infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
          infoFiltered: "(disaring dari _MAX_ total entri)",
          paginate: {
              first: "Pertama",
              last: "Terakhir",
              next: "Berikutnya",
              previous: "Sebelumnya"
          }
      },
      initComplete: function() {
          // Sesuaikan lebar kolom setelah inisialisasi
          this.api().columns.adjust().responsive.recalc();
      }
  });
  
  // Handle window resize
  $(window).on('resize', function() {
      var table = $('#dataTable').DataTable();
      table.columns.adjust().responsive.recalc();
  });
});