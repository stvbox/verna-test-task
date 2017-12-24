<nav class="navbar navbar-light bg-light justify-content-between">
    <a class="navbar-brand">Отчет</a>
    <form class="form-inline">
        <input id="date-range" class="form-control mr-sm-2" type="text" name="daterange" value="" />
        <button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="return buildReport();" >сформировать</button>
    </form>
</nav>

<script>
function buildReport() {
    var data = { range: $('#date-range').val() };
    $.post('/fragment/reptable', data, function(html) {
        $("#report-table").html(html);
    });
    
    return false;
}
buildReport();
</script>

<div id="report-table" ></div>

<script type="text/javascript">
$('input[name="daterange"]').daterangepicker({
    "showDropdowns": true,
    timePicker: false,
    timePickerIncrement: 30,
    locale: {
        "format": 'DD.MM.YYYY',
        "separator": "-",
        "applyLabel": "Выбрать",
        "cancelLabel": "Отмена",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
        "monthNames": [
            "Янваарь",
            "Ферваль",
            "Март",
            "Арпель",
            "Май",
            "Июнь",
            "Июль",
            "Август",
            "Сентябрь",
            "Октябрь",
            "Ноябрь",
            "Декабрь"
        ],
        "firstDay": 1
    }
});
</script>