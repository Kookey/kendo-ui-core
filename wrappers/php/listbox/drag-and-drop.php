﻿<?php
require_once '../lib/Kendo/Autoload.php';
require_once '../include/header.php';
?>
<div id="example" role="application">
    <div class="demo-section k-content">
<?php
    $listbox1 = new \Kendo\UI\ListBox('listbox1');

    $listbox1->dataValueField("ProductID")
             ->dataTextField("ProductName")
             ->draggable(true)
             ->dropSources(array("listbox2"))
             ->connectWith("listbox2")
             ->selectable("Single");

    $listbox1->addEvent("function(e){setDiscontinued(e, true)}")
             ->remove("function(e){setDiscontinued(e, false)}");

    echo $listbox1->render();
?>
        <span class="k-icon k-i-redo"></span>
        <span class="k-icon k-i-redo flipped"></span>
<?php
    $listbox2 = new \Kendo\UI\ListBox('listbox2');

    $listbox2->dataValueField("ProductID")
             ->dataTextField("ProductName")
             ->draggable(true)
             ->dropSources(array("listbox1"))
             ->connectWith("listbox1")
             ->selectable("single");

    echo $listbox2->render();
?>

        <button id="button" type="button">Save changes</button>
    </div>
</div>

<script>
    var dataSource;

    $(document).ready(function () {
        var crudServiceBaseUrl = "https://demos.telerik.com/kendo-ui/service";

        $("#button").kendoButton({
            click: function (e) {
                dataSource.sync();
            }
        });

        dataSource = new kendo.data.DataSource({
            serverFiltering: false,
            transport: {
                read: {
                    url: crudServiceBaseUrl + "/Products",
                    dataType: "jsonp"
                },
                update: {
                    url: crudServiceBaseUrl + "/Products/Update",
                    dataType: "jsonp"
                },
                parameterMap: function (options, operation) {
                    if (operation !== "read" && options.models) {
                        return { models: kendo.stringify(options.models) };
                    }
                }
            },
            batch: true,
            schema: {
                model: {
                    id: "ProductID",
                    fields: {
                        ProductID: { editable: false, nullable: true },
                        ProductName: { validation: { required: true } },
                        UnitPrice: { type: "number", validation: { required: true, min: 1 } },
                        Discontinued: { type: "boolean" },
                        UnitsInStock: { type: "number", validation: { min: 0, required: true } }
                    }
                }
            }
        });

        dataSource.fetch(function () {
            var data = this.data();
            var listbox1 = $("#listbox1").data("kendoListBox");
            var listbox2 = $("#listbox2").data("kendoListBox");
            for (var i = 0; i < data.length; i++) {
                if (data[i]["Discontinued"]) {
                    listbox1.add(data[i]);
                }
                else {
                    listbox2.add(data[i]);
                }
            }
        });
    });

    function setDiscontinued(ev, flag) {
        var removedItems = ev.dataItems;
        for (var i = 0; i < removedItems.length; i++) {
            var item = dataSource.getByUid(removedItems[i].uid);
            item["Discontinued"] = flag;
            item.dirty = !item.dirty;
        }
    }
</script>

<style>
    #button {
        float: right;
        margin-top: 20px;
    }

    #example .demo-section {
        max-width: none;
        width: 555px;
    }

    #example .k-listbox {
        width: 255px;
        height: 310px;
    }

    #example .k-i-redo {
        margin-bottom: 10px;
        opacity: 0.5;
    }

    #example .k-i-redo:hover {
        color: inherit!important;
    }

    #example .flipped {
        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        -o-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
        margin-top: 30px;
        margin-right: 1px;
    }
</style>
<?php require_once '../include/footer.php'; ?>
