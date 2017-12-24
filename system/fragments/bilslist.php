<?/*php pr($arResult);*/?>
<nav class="navbar navbar-light bg-light justify-content-between">
  <a class="navbar-brand">Создание/Редактирование/Удаление</a>
  <form class="form-inline">
        <button id="createBillButton" class="btn btn-outline-success my-2 my-sm-0" type="button" >создать</button>
  </form>
</nav>
<div id="bills-table-area" ></div>
<div id="bill-form-template" style="display: none;" >
    <form>
        <div class="form-group row">
            <label for="staticId" class="col-sm-2 col-form-label">ID</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext staticId" >
            </div>
        </div>
        <div class="form-group row">
            <label for="staticAgent" class="col-sm-2 col-form-label">Агент</label>
            <div class="col-sm-10">
                <select class="staticAgent" >
                    <?php foreach($arResult["AGENCYS"] AS $arItem):?>
                    <option value="<?php echo $arItem["agency_id"];?>" ><?php echo $arItem["agency_name"];?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="staticUser" class="col-sm-2 col-form-label">Пользователь</label>
            <div class="col-sm-10">
                <input type="text" class="form-control staticUser" placeholder="Пользователь">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Дата</label>
            <div class="col-sm-10">
                <input type="text" class="staticDate" placeholder="Дата" readonly >
            </div>
        </div>
        <div class="form-group row">
            <label for="staticAmount" class="col-sm-2 col-form-label">Сумма</label>
            <div class="col-sm-10">
                <input type="text" class="form-control staticAmount" placeholder="Сумма">
            </div>
        </div>
        <div class="form-group debug"></div>
    </form>
</div>

<script>
window.billsTable = null; // Списко счетов
function CBillsTable(data){
    that = this;
    this.data = data;
    this.tableHolder = $("#bills-table-area");
    
    $('#createBillButton').bind('click', function(){
        that.openEditForm({});
    });
    
    this.deleteItem = function(arItem) {
        var billId = arItem['id'];
        
        $.ajax({
            type: "DELETE",
            url: "/rest/bills/?id="+billId,
            data: {item: arItem},
            success: function(){
                var itemRowId = 'itemRow'+billId;
                var row = that.tbody.find('#'+itemRowId);
                row.remove();
            },
            dataType: " json"
        });
    }
    
    this.buildItemRow = function(arItem) {
        var tr = $('<tr></tr>');
        var td = $('<td></td>');
        var throu = $('<th scope="row" ></th>');
        var div = $('<div></div>');
        var a = $('<a></a>');
        
        var newTr = tr.clone();
        var itemRowId = 'itemRow'+arItem['id'];
        var oldRow = that.tbody.find('#'+itemRowId);
        if(oldRow.length){
            newTr = oldRow;
            newTr.html('');
        }
        else{
            newTr.attr('id', itemRowId);
            that.tbody.append(newTr); 
        }
        
            
        var newTh = throu.clone();
        newTh.html(arItem['id']);
        newTr.append(newTh);
            
            var newTd = td.clone();
            newTd.html(arItem['agency_name'])
            newTr.append(newTd);
            
            var newTd = td.clone();
            newTd.html(arItem['user_id'])
            newTr.append(newTd);
            
            var newTd = td.clone();
            newTd.html(arItem['date'])
            newTr.append(newTd);
            
            var newTd = td.clone();
            newTd.html(arItem['amount'])
            newTr.append(newTd);
            
            // Ссылка на редактирование
            var newTd = td.clone();
            var newDiv = div.clone();
            var newA = a.clone();
            newA.html('ред');
            newA.attr('href', '');
            newDiv.append(newA);
            newTd.append(newDiv);
            
            newA.bind('click', {item: arItem},function(event){
                that.openEditForm(event.data.item);
                return false;
            });
            
            // Ссылка на удаление
            var newDiv = div.clone();
            var newA = a.clone();
            newA.html('удл');
            newA.attr('href', '');
            newDiv.append(newA);
            newTd.append(newDiv);
            
            newA.bind('click', {item: arItem},function(event){
                that.deleteItem(event.data.item);
                return false;
            });
            
            newTr.append(newTd);
            
            /*var newTd = td.clone();
            newTd.html(JSON.stringify(arItem));
            newTr.append(newTd);*/
    }
    
    this.saveBillItem = function(arItem, fn) {
        function afterSaveHandler(res) {
            that.buildItemRow(res['item']);
            fn();
        }

        $.ajax({
            type: "POST",
            url: "/rest/bills",
            data: {item: arItem},
            success: afterSaveHandler,
            dataType: " json"
        });
    }
    
    this.openEditForm = function(item) {
        console.log(JSON.stringify(item));
        var mrkupTpl = $("#bill-form-template").html();
        var formTpl = $(mrkupTpl);
        formTpl.find('.debug').html(JSON.stringify(item));
        
        var arElFields = {
            'id': formTpl.find('.staticId'),
            'agency_id': formTpl.find('.staticAgent'),
            'user_id': formTpl.find('.staticUser'),
            'date': formTpl.find('.staticDate'),
            'amount': formTpl.find('.staticAmount')
        };
        
        for(var key in arElFields)
            arElFields[key].val(item[key]);

        formTpl.dialog({
            height: 400,
            width: 800,
            modal: true,
            buttons: {
                "Сохранить": function() {
                    var dlog = this;
                    var arItem = {};
                    for(var key in arElFields)
                        arItem[key] = arElFields[key].val();
                    that.saveBillItem(arItem, function(){
                        $(dlog).dialog("close");
                    });
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
        
        formTpl.find('.staticDate').datepicker({
            showOn: "button",
            buttonImage: "/assets/icons/w512h5121380476717calendar.png",
            buttonImageOnly: true,
            buttonText: "Select date"
        });
    }
    
    this.renderTable = function(){
        var table = $('<table class="table table-striped"></table>');
        var thead = $('<thead></thead>');
        var thcol = $('<th scope="col" ></th>');
        that.tbody = $('<tbody></tbody>');
        var tr = $('<tr></tr>');
        var td = $('<td></td>');
        var throu = $('<th scope="row" ></th>');
        var div = $('<div></div>');
        var a = $('<a></a>');
        
        table.append(thead);
        
        var newTh = thcol.clone();
        newTh.html("ID");
        thead.append(newTh);
        
        var newTh = thcol.clone();
        newTh.html("Агент");
        thead.append(newTh);
        
        var newTh = thcol.clone();
        newTh.html("Пользователь");
        thead.append(newTh);
        
        var newTh = thcol.clone();
        newTh.html("Дата");
        thead.append(newTh);
        
        var newTh = thcol.clone();
        newTh.html("Сумма");
        thead.append(newTh);
        
        var newTh = thcol.clone();
        newTh.html("Действия");
        thead.append(newTh);
        
        table.append(that.tbody);

        for(var i in data.ITEMS){
            that.buildItemRow(data.ITEMS[i]);
        }

        $("#bills-table-area").append(table);
    }
}

function success(data) {
    var billsTable = new CBillsTable(data);
    billsTable.renderTable();
}

$.ajax({
  dataType: "json",
  url: "/rest/bills",
  success: success
});

</script>