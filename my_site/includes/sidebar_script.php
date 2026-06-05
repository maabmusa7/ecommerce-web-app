<script>

  var sidebar = document.getElementById('sidebar');
  var overlay = document.getElementById('overlay');
  var toggleBtn = document.getElementById('sidebarToggle');
  var closeBtn = document.getElementById('closeBtn');

  toggleBtn.onclick = function(){
    sidebar.style.left= '0';
    overlay.style.display = 'block';
      };

  closeBtn.onclick = function(){
    sidebar.style.left= '-300px';
    overlay.style.display = 'none';
  };

   overlay.onclick = function(){
    sidebar.style.left= '-300px';
    overlay.style.display = 'none';
  };
      
  
</script>