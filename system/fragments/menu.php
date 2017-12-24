<div class="main-left-menu nav flex-column nav-pills" aria-orientation="vertical">
  <a href="/fragment/" class="nav-link active" >О приложении</a>
  <a href="/fragment/redcels/" class="nav-link" >Красные ячейки</a>
  <a href="/fragment/fibon/" class="nav-link" >Фибоначчи</a>
  <a href="/fragment/import/" class="nav-link" >Импорт данных</a>
  <a href="/fragment/report/" class="nav-link" >Отчет по импорту</a>
  <a href="/fragment/crud/" class="nav-link" >Реализация CRUD</a>
</div>
<script>
	$(".main-left-menu a").bind("click", function(event){
		$.get(this.href, function(html) {
			$(".app-body").html(html);
		});
		
		$(".main-left-menu a").removeClass("active");
		$(this).addClass("active");
		
		return false;
	});
</script>