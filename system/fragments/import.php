<nav class="navbar navbar-light bg-light justify-content-between">
  <a class="navbar-brand">ИмпортОтчет</a>
  <form class="form-inline">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" onclick="return procedImportFromCsv();" >импорт данных</button>
  </form>
</nav>
<script>
function procedImportFromCsv() {
	$.get('/service/importcsv', function(data) {
		$("#debug-log").html(data);
	}).fail(function(data){
		$("#debug-log").html(data);
	});
	return false;
}
</script>

<div class="alert alert-primary" role="alert">
CREATE TABLE "networks" ( `agency_network_id` INTEGER PRIMARY KEY AUTOINCREMENT, `agency_network_name` TEXT NOT NULL UNIQUE )
</div>
<div class="alert alert-primary" role="alert">
CREATE TABLE "agencys" ( `agency_id` INTEGER PRIMARY KEY AUTOINCREMENT, `agency_network_id` INTEGER NOT NULL, `agency_name` TEXT NOT NULL UNIQUE )
</div>
<div class="alert alert-primary" role="alert">
CREATE TABLE `bills` ( `id` INTEGER PRIMARY KEY AUTOINCREMENT, `agency_id` INTEGER NOT NULL, `user_id` INTEGER NOT NULL, `date` INTEGER NOT NULL, `amount` INTEGER NOT NULL )
</div>

<div id="debug-log" >
    
</div>